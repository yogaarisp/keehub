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
