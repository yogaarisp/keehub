<?php

namespace App\Models;

use App\Services\CodeGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quotation extends Model
{
    public const STATUSES = ['draft', 'sent', 'accepted', 'rejected', 'expired', 'converted'];

    protected $fillable = [
        'code',
        'customer_id',
        'pc_build_id',
        'quotation_date',
        'expired_date',
        'subtotal',
        'discount',
        'shipping',
        'total',
        'status',
        'notes',
        'terms',
        'order_id',
    ];

    protected function casts(): array
    {
        return [
            'quotation_date' => 'date',
            'expired_date' => 'date',
            'subtotal' => 'integer',
            'discount' => 'integer',
            'shipping' => 'integer',
            'total' => 'integer',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(QuotationItem::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function pcBuild(): BelongsTo
    {
        return $this->belongsTo(PcBuild::class);
    }

    public static function generateCode(): string
    {
        return CodeGenerator::next('QT', 'Ym');
    }
}
