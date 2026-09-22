<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PcBuild extends Model
{
    public const PURPOSES = ['gaming', 'office', 'programming', 'editing', 'streaming', 'design', 'ai', 'server'];

    public const SLOTS = ['cpu', 'motherboard', 'ram', 'gpu', 'storage', 'psu', 'case', 'cooler'];

    protected $fillable = [
        'code',
        'user_id',
        'customer_id',
        'name',
        'purpose',
        'budget',
        'total_price',
        'status',
        'share_token',
    ];

    protected function casts(): array
    {
        return [
            'budget' => 'integer',
            'total_price' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(PcBuildItem::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function quotations(): HasMany
    {
        return $this->hasMany(Quotation::class);
    }

    public static function generateCode(): string
    {
        return 'PCB-'.now()->format('Ymd').'-'.str_pad((string) (static::query()->whereDate('created_at', today())->count() + 1), 3, '0', STR_PAD_LEFT);
    }
}
