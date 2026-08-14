<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Number;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use Mpdf\Mpdf;

class InvoicePdfController extends Controller
{
    private const ALLOWED_PAGE_SIZES = ['A4', 'A5'];

    private const PAGE_CONFIG = [
        'A5' => [
            'maxLines' => 17,
            'withDescription' => 11,
            'descBreaks' => [35, 70],
            'view' => 'filament.invoices.pdf-invoice-a5',
        ],
        'A4' => [
            'maxLines' => 26,
            'withDescription' => 16,
            'descBreaks' => [50, 95],
            'view' => 'filament.invoices.pdf-invoice-a4',
        ],
    ];

    public function download(Request $request, Invoice $invoice): RedirectResponse
    {
        $invoice->load('items.product');

        $pageSize = $this->resolvePageSize($request);
        $total = $this->calculateTotal($invoice);
        $inWord = $this->totalInWords($total);

        $mpdf = $this->buildMpdf($pageSize);
        $mpdf->WriteHTML($this->renderView($invoice, $pageSize, $total, $inWord));

        $relativePath = $this->storePdf($invoice, $mpdf);

        return redirect(Storage::disk('public')->url($relativePath));
    }

    private function storePdf(Invoice $invoice, Mpdf $mpdf): string
    {
        $disk = Storage::disk('public');
        $relativePath = 'invoices/'.$invoice->invoice_no.'.pdf';

        if ($invoice->pdf_path && $disk->exists($invoice->pdf_path)) {
            $disk->delete($invoice->pdf_path);
        }

        $disk->makeDirectory('invoices');

        $mpdf->Output($disk->path($relativePath), 'F');

        $invoice->update(['pdf_path' => $relativePath]);

        return $relativePath;
    }

    private function resolvePageSize(Request $request): string
    {
        $size = $request->query('page_size');

        return in_array($size, self::ALLOWED_PAGE_SIZES, strict: true) ? $size : 'A5';
    }

    private function calculateTotal(Invoice $invoice): float
    {
        return round((float) $invoice->subtotal - (float) $invoice->discount, 2);
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

    private function renderView(Invoice $invoice, string $pageSize, float $total, string $inWord): string
    {
        $config = self::PAGE_CONFIG[$pageSize];

        return view($config['view'], [
            'record' => $invoice,
            'total' => $total,
            'inWord' => $inWord,
            'css' => $this->loadCss(),
            'emptyRows' => $this->calculateEmptyRows($invoice, $config),
        ])->render();
    }

    private function calculateEmptyRows(Invoice $invoice, array $config): int
    {
        $usedLines = 0;
        $withDescriptionCount = 0;

        foreach ($invoice->items as $item) {
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
                file_get_contents(public_path('build/manifest.json')),
                associative: true,
                flags: JSON_THROW_ON_ERROR,
            );

            return file_get_contents(public_path('build/'.$manifest['resources/css/pdf.css']['file']));
        } catch (\Throwable) {
            return '';
        }
    }
}
