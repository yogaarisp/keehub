<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Service extends Model
{
    public const TYPES = [
        'rakit_pc' => 'Rakit PC',
        'upgrade_pc' => 'Upgrade PC',
        'cleaning' => 'Cleaning',
        'thermal_paste' => 'Thermal Paste',
        'install_windows' => 'Install Windows',
        'driver_installation' => 'Driver Installation',
        'troubleshooting' => 'Troubleshooting',
        'hardware_checking' => 'Hardware Checking',
        'cable_management' => 'Cable Management',
        'data_storage' => 'Data/Storage Service',
        'other' => 'Other',
    ];

    public const STATUSES = ['received', 'checking', 'waiting_approval', 'processing', 'testing', 'ready', 'completed', 'cancelled'];

    protected $fillable = [
        'code',
        'customer_id',
        'source',
        'service_type',
        'status',
        'problem_description',
        'diagnosis',
        'estimated_cost',
        'total_cost',
        'technician_id',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'estimated_cost' => 'integer',
            'total_cost' => 'integer',
        ];
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(ServiceItem::class);
    }

    public function statusHistory(): HasMany
    {
        return $this->hasMany(ServiceStatusHistory::class)->latest();
    }

    public function qcRecord(): HasOne
    {
        return $this->hasOne(QcRecord::class);
    }

    public static function generateCode(): string
    {
        return 'SVC-'.now()->format('Ymd').'-'.str_pad((string) (static::query()->whereDate('created_at', today())->count() + 1), 3, '0', STR_PAD_LEFT);
    }
}
