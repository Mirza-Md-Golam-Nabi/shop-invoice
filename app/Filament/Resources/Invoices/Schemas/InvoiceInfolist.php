<?php

namespace App\Filament\Resources\Invoices\Schemas;

use App\Models\Invoice;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;

class InvoiceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                View::make('filament.invoices.view-invoice')
                    ->viewData(fn (Invoice $record) => ['record' => $record]),
            ]);
    }
}
