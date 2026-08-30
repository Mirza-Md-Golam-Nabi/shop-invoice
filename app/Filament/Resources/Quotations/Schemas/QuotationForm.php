<?php

namespace App\Filament\Resources\Quotations\Schemas;

use App\Models\Product;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class QuotationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Customer Information')
                    ->columns(5)
                    ->compact()
                    ->schema([
                        TextInput::make('customer_name')
                            ->label('Customer Name')
                            ->placeholder('Enter customer name')
                            ->columnSpan(2),
                        Textarea::make('customer_address')
                            ->label('Address')
                            ->rows(1)
                            ->placeholder('Enter customer address')
                            ->columnSpan(2),
                        DatePicker::make('date')
                            ->required()
                            ->default(today())
                            ->native(false),
                    ]),

                Section::make('Quotation Items')
                    ->schema([
                        Repeater::make('items')
                            ->schema([
                                TextInput::make('product_name')
                                    ->label('Product')
                                    ->placeholder('Type product name...')
                                    ->required()
                                    ->datalist(fn (): array => Product::orderBy('name')->get(['name'])->map(fn ($p) => $p->name)->toArray())
                                    ->columnSpan(3),
                                TextInput::make('description')
                                    ->label('Description')
                                    ->placeholder('Item description')
                                    ->columnSpan(3),
                                TextInput::make('quantity')
                                    ->label('Qty')
                                    ->required()
                                    ->numeric()
                                    ->default(1)
                                    ->minValue(1)
                                    ->live(debounce: 1000)
                                    ->afterStateUpdated(function (Get $get, Set $set) {
                                        $set('amount', round((float) $get('quantity') * (float) $get('rate'), 2));
                                        self::recalculateFromItem($get, $set);
                                    })
                                    ->columnSpan(2),
                                TextInput::make('rate')
                                    ->label('Rate')
                                    ->required()
                                    ->numeric()
                                    ->default(0)
                                    ->prefix('৳')
                                    ->live(debounce: 1000)
                                    ->afterStateUpdated(function (Get $get, Set $set) {
                                        $set('amount', round((float) $get('quantity') * (float) $get('rate'), 2));
                                        self::recalculateFromItem($get, $set);
                                    })
                                    ->columnSpan(2),
                                TextInput::make('amount')
                                    ->label('Amount')
                                    ->numeric()
                                    ->prefix('৳')
                                    ->disabled()
                                    ->dehydrated()
                                    ->columnSpan(2),
                            ])
                            ->columns(12)
                            ->addActionLabel('+ Add Product')
                            ->reorderable(false)
                            ->live()
                            ->deleteAction(
                                fn ($action) => $action->after(fn (Get $get, Set $set) => self::recalculate($get, $set))
                            ),
                    ]),

                Section::make('Summary')
                    ->columns(3)
                    ->compact()
                    ->schema([
                        TextInput::make('subtotal')
                            ->label('Subtotal')
                            ->numeric()
                            ->prefix('৳')
                            ->disabled()
                            ->dehydrated(),
                        TextInput::make('discount')
                            ->label('Discount')
                            ->numeric()
                            ->prefix('৳')
                            ->default(0)
                            ->minValue(0)
                            ->live()
                            ->afterStateUpdated(fn (Get $get, Set $set) => self::recalculate($get, $set)),
                        TextInput::make('total')
                            ->label('Total')
                            ->numeric()
                            ->prefix('৳')
                            ->disabled()
                            ->dehydrated(),
                    ]),
            ]);
    }

    // Repeater item এর ভেতর থেকে call হবে (../../ দিয়ে parent access)
    private static function recalculateFromItem(Get $get, Set $set): void
    {
        $items = $get('../../items');
        $subtotal = collect($items)
            ->sum(fn ($item) => (float) ($item['amount'] ?? 0));

        $subtotal = round($subtotal, 2);
        $discount = (float) $get('../../discount');

        $set('../../subtotal', $subtotal);
        $set('../../total', round($subtotal - $discount, 2));
    }

    // Repeater এর বাইরে (root level) থেকে call হবে
    private static function recalculate(Get $get, Set $set): void
    {
        $subtotal = collect($get('items'))
            ->sum(fn ($item) => (float) ($item['amount'] ?? 0));

        $subtotal = round($subtotal, 2);
        $discount = (float) $get('discount');

        $set('subtotal', $subtotal);
        $set('total', round($subtotal - $discount, 2));
    }
}
