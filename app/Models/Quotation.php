<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quotation extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_address',
        'date',
        'subtotal',
        'discount',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'subtotal' => 'decimal:2',
            'discount' => 'decimal:2',
        ];
    }

    public function items(): HasMany
    {
        return $this->hasMany(QuotationItem::class);
    }

    public function total(): float
    {
        return (float) ($this->subtotal - $this->discount);
    }

    protected function quotationNo(): Attribute
    {
        return Attribute::get(fn () => sprintf('CA-Q-%05d', $this->id));
    }
}
