<?php

namespace App\Filament\Resources\Invoices\Pages;

use App\Filament\Resources\Invoices\InvoiceResource;
use App\Models\Invoice;
use App\Models\Product;
use Filament\Resources\Pages\CreateRecord;

class CreateInvoice extends CreateRecord
{
    protected static string $resource = InvoiceResource::class;

    protected function handleRecordCreation(array $data): Invoice
    {
        $items = $data['items'] ?? [];
        unset($data['items']);

        /** @var Invoice $invoice */
        $invoice = Invoice::create($data);

        foreach ($items as $item) {
            $product = Product::firstOrCreate(['name' => trim($item['product_name'])]);

            $invoice->items()->create([
                'product_id' => $product->id,
                'description' => $item['description'] ?? '',
                'quantity' => $item['quantity'],
                'rate' => $item['rate'],
                'amount' => round((float) $item['quantity'] * (float) $item['rate'], 2),
            ]);
        }

        return $invoice;
    }
}
