<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceDevice extends Model
{
    protected $fillable = [
        'service_id',
        'device_name',
        'service_type',
        'serial_number',
        'device_specs',
        'completeness',
        'problem_description',
        'diagnosis',
        'status',
        'notes',
        'sort_order',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ServiceItem::class, 'service_device_id');
    }

    public function displayName(): string
    {
        $label = $this->device_name;
        if ($this->serial_number) {
            $label .= ' (SN/Asset: '.$this->serial_number.')';
        }

        return $label;
    }
}

