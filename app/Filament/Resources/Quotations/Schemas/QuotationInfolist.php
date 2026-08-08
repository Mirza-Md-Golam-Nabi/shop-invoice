<?php

namespace App\Filament\Resources\Quotations\Schemas;

use App\Models\Quotation;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;

class QuotationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                View::make('filament.quotations.view-quotation')
                    ->viewData(fn (Quotation $record) => ['record' => $record]),
            ]);
    }
}
