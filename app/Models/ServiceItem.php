<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceItem extends Model
{
    protected $fillable = [
        'service_id',
        'service_device_id',
        'item_type',
        'part_source',
        'bill_to_client',
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
            'bill_to_client' => 'boolean',
            'quantity' => 'integer',
            'price' => 'integer',
            'total' => 'integer',
        ];
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(ServiceDevice::class, 'service_device_id');
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

    public function isBilledToClient(): bool
    {
        if ($this->bill_to_client !== null) {
            return (bool) $this->bill_to_client;
        }

        return ! $this->isFromVendor();
    }

    public function invoicePrice(): int
    {
        return $this->isBilledToClient() ? (int) $this->price : 0;
    }

    public function invoiceTotal(): int
    {
        return $this->isBilledToClient() ? (int) $this->total : 0;
    }
}
