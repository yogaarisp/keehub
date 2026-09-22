<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shipment extends Model
{
    public const STATUSES = ['preparing', 'shipped', 'in_transit', 'delivered', 'pickup'];

    public const COURIERS = ['JNE', 'J&T', 'SiCepat', 'AnterAja', 'Pos', 'Cargo', 'Local Courier', 'Custom'];

    protected $fillable = [
        'order_id',
        'courier',
        'tracking_number',
        'shipping_cost',
        'shipped_at',
        'status',
        'is_pickup',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'shipping_cost' => 'integer',
            'shipped_at' => 'date',
            'is_pickup' => 'boolean',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
