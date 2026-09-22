<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    public const STATUSES = ['unpaid', 'partial', 'paid', 'refunded', 'void'];

    protected $fillable = [
        'code',
        'order_id',
        'customer_id',
        'subtotal',
        'discount',
        'shipping',
        'total',
        'paid_amount',
        'status',
        'due_date',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'integer',
            'discount' => 'integer',
            'shipping' => 'integer',
            'total' => 'integer',
            'paid_amount' => 'integer',
            'due_date' => 'date',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function remainingAmount(): int
    {
        return max(0, $this->total - $this->paid_amount);
    }

    public function recalculateStatus(): void
    {
        $paid = (int) $this->payments()->sum('amount');
        $this->paid_amount = $paid;

        if ($this->status === 'void') {
            $this->save();

            return;
        }

        if ($paid <= 0) {
            $this->status = 'unpaid';
        } elseif ($paid < $this->total) {
            $this->status = 'partial';
        } else {
            $this->status = 'paid';
        }

        $this->save();
    }

    public static function generateCode(): string
    {
        return 'INV-'.now()->format('Ymd').'-'.str_pad((string) (static::query()->whereDate('created_at', today())->count() + 1), 3, '0', STR_PAD_LEFT);
    }
}
