<?php

namespace App\Filament\Resources\Quotations\Pages;

use App\Filament\Resources\Quotations\QuotationResource;
use App\Models\Product;
use App\Models\Quotation;
use Filament\Resources\Pages\CreateRecord;

class CreateQuotation extends CreateRecord
{
    protected static string $resource = QuotationResource::class;

    protected function handleRecordCreation(array $data): Quotation
    {
        $items = $data['items'] ?? [];
        unset($data['items']);

        /** @var Quotation $quotation */
        $quotation = Quotation::create($data);

        foreach ($items as $item) {
            $product = Product::firstOrCreate(['name' => trim($item['product_name'])]);

            $quotation->items()->create([
                'product_id' => $product->id,
                'description' => $item['description'] ?? '',
                'quantity' => $item['quantity'],
                'rate' => $item['rate'],
                'amount' => $item['amount'],
            ]);
        }

        return $quotation;
    }
}
