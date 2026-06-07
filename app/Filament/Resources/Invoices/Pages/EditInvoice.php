<?php

namespace App\Filament\Resources\Invoices\Pages;

use App\Filament\Resources\Invoices\InvoiceResource;
use App\Models\Product;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditInvoice extends EditRecord
{
    protected static string $resource = InvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['items'] = $this->record->items->map(fn ($item) => [
            'product_name' => $item->product?->name ?? '',
            'description' => $item->description,
            'quantity' => $item->quantity,
            'rate' => $item->rate,
            'amount' => $item->amount,
        ])->toArray();

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $items = $data['items'] ?? [];
        unset($data['items']);

        $record->update($data);

        $record->items()->delete();

        foreach ($items as $item) {
            $product = Product::firstOrCreate(['name' => trim($item['product_name'])]);

            $record->items()->create([
                'product_id' => $product->id,
                'description' => $item['description'] ?? '',
                'quantity' => $item['quantity'],
                'rate' => $item['rate'],
                'amount' => $item['amount'],
            ]);
        }

        return $record;
    }
}
