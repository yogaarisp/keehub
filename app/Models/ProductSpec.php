<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductSpec extends Model
{
    protected $fillable = [
        'product_id',
        'key',
        'value',
        'value_numeric',
        'unit',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'value_numeric' => 'float',
        ];
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
