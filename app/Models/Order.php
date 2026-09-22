<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    public const STATUSES = ['pending', 'confirmed', 'processing', 'ready', 'shipped', 'completed', 'cancelled'];

    public const TYPES = ['product', 'pc_build', 'service', 'product_service'];

    public const CHANNELS = ['website', 'admin', 'whatsapp', 'offline'];

    protected $fillable = [
        'code',
        'customer_id',
        'user_id',
        'type',
        'channel',
        'status',
        'subtotal',
        'discount',
        'shipping_cost',
        'total',
        'notes',
        'pc_build_id',
        'quotation_id',
        'service_id',
        'shipping_name',
        'shipping_phone',
        'shipping_address',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'integer',
            'discount' => 'integer',
            'shipping_cost' => 'integer',
            'total' => 'integer',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function statusHistory(): HasMany
    {
        return $this->hasMany(OrderStatusHistory::class)->latest();
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    public function shipment(): HasOne
    {
        return $this->hasOne(Shipment::class);
    }

    public function pcBuild(): BelongsTo
    {
        return $this->belongsTo(PcBuild::class);
    }

    public function quotation(): BelongsTo
    {
        return $this->belongsTo(Quotation::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function generateCode(): string
    {
        return 'ORD-'.now()->format('Ymd').'-'.str_pad((string) (static::query()->whereDate('created_at', today())->count() + 1), 3, '0', STR_PAD_LEFT);
    }

    public function recalculateTotalsFromItems(): void
    {
        $subtotal = (int) $this->items()->sum('total');
        $this->subtotal = $subtotal;
        $this->total = $subtotal - (int) $this->discount + (int) $this->shipping_cost;
        $this->save();

        $this->invoice?->update([
            'subtotal' => $this->subtotal,
            'discount' => $this->discount,
            'shipping' => $this->shipping_cost,
            'total' => $this->total,
        ]);
        $this->invoice?->recalculateStatus();
    }
}
