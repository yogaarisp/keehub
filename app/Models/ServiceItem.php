<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceItem extends Model
{
    protected $fillable = [
        'service_id',
        'item_type',
        'part_source',
        'product_id',
        'name',
        'description',
        'warranty_info',
        'quantity',
        'price',
        'total',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'price' => 'integer',
            'total' => 'integer',
        ];
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function isFromVendor(): bool
    {
        return $this->part_source === 'vendor';
    }

    public function isFromKeeHub(): bool
    {
        return $this->part_source === 'keehub';
    }

    public function partSourceLabel(): string
    {
        return match ($this->part_source) {
            'vendor' => 'Dari Vendor',
            default => 'Dari KeeHub',
        };
    }

    public function invoicePrice(): int
    {
        return $this->isFromVendor() ? 0 : (int) $this->price;
    }

    public function invoiceTotal(): int
    {
        return $this->isFromVendor() ? 0 : (int) $this->total;
    }
}
