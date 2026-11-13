<?php

namespace App\Models;

use App\Services\CodeGenerator;
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
        'invoice_number',
        'customer_id',
        'company_name',
        'source',
        'service_type',
        'device_name',
        'serial_number',
        'device_specs',
        'completeness',
        'status',
        'due_date',
        'completed_at',
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
            'due_date' => 'date',
            'completed_at' => 'datetime',
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

    public function devices(): HasMany
    {
        return $this->hasMany(ServiceDevice::class)->orderBy('sort_order');
    }

    public function deviceCount(): int
    {
        $count = $this->devices()->count();

        return $count > 0 ? $count : 1;
    }

    public function devicesSummary(): string
    {
        $devices = $this->devices;
        if ($devices->isEmpty()) {
            return $this->device_name ?: 'Unit PC';
        }

        if ($devices->count() === 1) {
            return $devices->first()->device_name;
        }

        return $devices->first()->device_name.' (+'.($devices->count() - 1).' unit lainnya)';
    }

    public function syncPrimaryDeviceAttributes(): void
    {
        $devices = $this->devices()->orderBy('sort_order')->get();
        if ($devices->isEmpty()) {
            return;
        }

        $first = $devices->first();
        if ($devices->count() === 1) {
            $this->device_name = $first->device_name;
            $this->serial_number = $first->serial_number;
            $this->device_specs = $first->device_specs;
            $this->completeness = $first->completeness;
            $this->problem_description = $first->problem_description;
            $this->diagnosis = $first->diagnosis;
            if ($first->service_type) {
                $this->service_type = $first->service_type;
            }
        } else {
            $this->device_name = $first->device_name.' (+'.($devices->count() - 1).' unit lainnya)';
            $serials = $devices->pluck('serial_number')->filter()->take(3)->implode(', ');
            $this->serial_number = $serials ? $serials.($devices->count() > 3 ? '...' : '') : null;
            $this->problem_description = $devices->map(fn ($d, $i) => ($i + 1).'. '.$d->device_name.': '.($d->problem_description ?: '-'))->implode("\n");
        }

        $this->saveQuietly();
    }

    public static function generateCode(): string
    {
        return CodeGenerator::next('SVC');
    }

    public static function generateInvoiceNumber(): string
    {
        return CodeGenerator::next('INV-SVC');
    }

    public function invoiceTotal(): int
    {
        return (int) $this->items
            ->filter(fn (ServiceItem $item) => $item->part_source !== 'vendor')
            ->sum('total');
    }

    public function workOrderTotal(): int
    {
        return (int) $this->items->sum('total');
    }

    public function vendorPartsTotal(): int
    {
        return (int) $this->items
            ->filter(fn (ServiceItem $item) => $item->part_source === 'vendor')
            ->sum('total');
    }

    public function keehubPartsTotal(): int
    {
        return (int) $this->items
            ->filter(fn (ServiceItem $item) => $item->item_type === 'product' && $item->part_source === 'keehub')
            ->sum('total');
    }

    public function laborTotal(): int
    {
        return (int) $this->items
            ->filter(fn (ServiceItem $item) => $item->item_type === 'labor')
            ->sum('total');
    }

    public function syncTotalCost(): void
    {
        $this->total_cost = $this->invoiceTotal();
        $this->save();
    }
}
