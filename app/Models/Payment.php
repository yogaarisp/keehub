<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    public const METHODS = ['cash', 'transfer', 'qris', 'ewallet', 'debit', 'credit', 'other'];

    protected $fillable = [
        'code',
        'invoice_id',
        'method',
        'amount',
        'paid_at',
        'reference',
        'notes',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'integer',
            'paid_at' => 'date',
        ];
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted(): void
    {
        static::created(fn (Payment $payment) => $payment->invoice->recalculateStatus());
        static::deleted(fn (Payment $payment) => $payment->invoice->recalculateStatus());
    }
}
