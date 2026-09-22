<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QcRecord extends Model
{
    public const CHECKLIST = [
        'hardware' => [
            'cpu_detected' => 'CPU detected',
            'ram_detected' => 'RAM detected',
            'ssd_detected' => 'SSD detected',
            'gpu_detected' => 'GPU detected',
            'usb' => 'USB',
            'lan' => 'LAN',
            'wifi' => 'WiFi',
            'audio' => 'Audio',
            'display' => 'Display',
        ],
        'software' => [
            'bios' => 'BIOS',
            'windows' => 'Windows',
            'driver' => 'Driver',
            'update' => 'Update',
        ],
        'testing' => [
            'cpu_stress' => 'CPU stress test',
            'gpu_stress' => 'GPU stress test',
            'ram_test' => 'RAM test',
            'storage_health' => 'Storage health',
        ],
    ];

    protected $fillable = [
        'service_id',
        'order_id',
        'technician_id',
        'checklist',
        'notes',
        'result',
        'checked_at',
    ];

    protected function casts(): array
    {
        return [
            'checklist' => 'array',
            'checked_at' => 'datetime',
        ];
    }

    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
