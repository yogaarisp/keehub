<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    public const TYPES = ['product', 'build', 'service', 'labor', 'customer_owned'];

    protected $fillable = [
        'order_id',
        'item_type',
        'product_id',
        'name',
        'description',
        'quantity',
        'price',
        'total',
        'affects_stock',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'price' => 'integer',
            'total' => 'integer',
            'affects_stock' => 'boolean',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
