<?php

namespace App\Services;

use App\Models\Service;
use App\Models\ServiceStatusHistory;
use App\Models\User;

class ServiceService
{
    public static function statusFlow(): array
    {
        return [
            'received' => ['checking', 'cancelled'],
            'checking' => ['waiting_approval', 'cancelled'],
            'waiting_approval' => ['processing', 'cancelled'],
            'processing' => ['testing', 'cancelled'],
            'testing' => ['ready'],
            'ready' => ['completed'],
            'completed' => [],
            'cancelled' => [],
        ];
    }

    public static function setStatus(Service $service, string $newStatus, ?string $notes = null, ?User $user = null): Service
    {
        if (! in_array($newStatus, Service::STATUSES, true)) {
            throw new \InvalidArgumentException("Invalid status: {$newStatus}");
        }

        if (! in_array($newStatus, self::statusFlow()[$service->status] ?? [], true)) {
            throw new \DomainException("Transisi status tidak valid: {$service->status} → {$newStatus}.");
        }

        $from = $service->status;
        $service->status = $newStatus;
        $service->save();

        ServiceStatusHistory::query()->create([
            'service_id' => $service->id,
            'from_status' => $from,
            'to_status' => $newStatus,
            'notes' => $notes,
            'user_id' => $user?->id,
        ]);

        return $service;
    }
}
