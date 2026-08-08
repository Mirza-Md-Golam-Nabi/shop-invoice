<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Number;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\Mpdf;

class QuotationPdfController extends Controller
{
    private const ALLOWED_PAGE_SIZES = ['A4', 'A5'];

    private const PAGE_CONFIG = [
        'A5' => [
            'maxLines' => 17,
            'withDescription' => 11,
            'descBreaks' => [35, 70],
            'view' => 'filament.quotations.pdf-quotation-a5',
        ],
        'A4' => [
            'maxLines' => 26,
            'withDescription' => 16,
            'descBreaks' => [50, 95],
            'view' => 'filament.quotations.pdf-quotation-a4',
        ],
    ];

    public function download(Request $request, Quotation $quotation): Response
    {
        $quotation->load('items.product');

        $pageSize = $this->resolvePageSize($request);
        $total = $this->calculateTotal($quotation);
        $inWord = $this->totalInWords($total);

        $mpdf = $this->buildMpdf($pageSize);
        $mpdf->WriteHTML($this->renderView($quotation, $pageSize, $total, $inWord));

        return response($mpdf->Output('', 'S'))
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="'.$quotation->quotation_no.'.pdf"');
    }

    private function resolvePageSize(Request $request): string
    {
        $size = $request->query('page_size');

        return in_array($size, self::ALLOWED_PAGE_SIZES, strict: true) ? $size : 'A5';
    }

    private function calculateTotal(Quotation $quotation): float
    {
        return round((float) $quotation->subtotal - (float) $quotation->discount, 2);
    }

    private function totalInWords(float $total): string
    {
        return ucwords(str_replace('-', ' ', Number::spell($total))).' Only /-';
    }

    private function buildMpdf(string $pageSize): Mpdf
    {
        $fontPath = public_path('fonts');

        return new Mpdf([
            'format' => $pageSize,
            'orientation' => 'P',
            'fontDir' => array_merge((new ConfigVariables)->getDefaults()['fontDir'], [$fontPath]),
            'fontdata' => (new FontVariables)->getDefaults()['fontdata'] + [
                'solaimanlipi' => ['R' => 'SolaimanLipi.ttf', 'useOTL' => 0xFF],
            ],
            'margin_top' => 5,
            'margin_bottom' => 3,
            'margin_left' => 12,
            'margin_right' => 12,
            'default_font' => 'solaimanlipi',
        ]);
    }

    private function renderView(Quotation $quotation, string $pageSize, float $total, string $inWord): string
    {
        $config = self::PAGE_CONFIG[$pageSize];

        return view($config['view'], [
            'record' => $quotation,
            'total' => $total,
            'inWord' => $inWord,
            'css' => $this->loadCss(),
            'emptyRows' => $this->calculateEmptyRows($quotation, $config),
        ])->render();
    }

    private function calculateEmptyRows(Quotation $quotation, array $config): int
    {
        $usedLines = 0;
        $withDescriptionCount = 0;

        foreach ($quotation->items as $item) {
            if (blank($item->description)) {
                $usedLines++;

                continue;
            }

            $length = strlen($item->description);
            $withDescriptionCount++;

            foreach ($config['descBreaks'] as $breakPoint) {
                if ($length > $breakPoint) {
                    $withDescriptionCount++;
                }
            }
        }

        $usedLines += round(($config['maxLines'] / $config['withDescription']) * $withDescriptionCount);

        return max(0, $config['maxLines'] - $usedLines);
    }

    private function loadCss(): string
    {
        try {
            $manifest = json_decode(
                file_get_contents(public_path('build/.vite/manifest.json')),
                associative: true,
                flags: JSON_THROW_ON_ERROR,
            );

            return file_get_contents(public_path('build/'.$manifest['resources/css/pdf.css']['file']));
        } catch (\Throwable) {
            return '';
        }
    }
}
