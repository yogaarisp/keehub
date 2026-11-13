<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Filament\Resources\ServiceResource;
use App\Models\Service;
use App\Models\ServiceStatusHistory;
use Filament\Resources\Pages\CreateRecord;

class CreateService extends CreateRecord
{
    protected static string $resource = ServiceResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['code'] = $data['code'] ?? Service::generateCode();
        $data['invoice_number'] = $data['invoice_number'] ?? Service::generateInvoiceNumber();

        if (! empty($data['devices'])) {
            $first = reset($data['devices']);
            $count = count($data['devices']);
            if ($count === 1) {
                $data['device_name'] = $first['device_name'] ?? 'Unit PC';
                $data['serial_number'] = $first['serial_number'] ?? null;
                $data['device_specs'] = $first['device_specs'] ?? null;
                $data['completeness'] = $first['completeness'] ?? null;
                $data['problem_description'] = $first['problem_description'] ?? null;
                $data['diagnosis'] = $first['diagnosis'] ?? null;
                if (! empty($first['service_type'])) {
                    $data['service_type'] = $first['service_type'];
                }
            } else {
                $data['device_name'] = ($first['device_name'] ?? 'Unit PC').' (+ '.($count - 1).' unit lainnya)';
                $serials = collect($data['devices'])->pluck('serial_number')->filter()->take(3)->implode(', ');
                $data['serial_number'] = $serials ? $serials.($count > 3 ? '...' : '') : null;
                $data['problem_description'] = collect($data['devices'])
                    ->map(fn ($d, $i) => ($i + 1).'. '.($d['device_name'] ?? 'Unit').': '.($d['problem_description'] ?? '-'))
                    ->implode("\n");
                if (! empty($first['service_type'])) {
                    $data['service_type'] = $first['service_type'];
                }
            }
        }

        $data['service_type'] = $data['service_type'] ?? 'troubleshooting';

        return $data;
    }

    protected function afterCreate(): void
    {
        /** @var Service $record */
        $record = $this->getRecord();

        $record->syncPrimaryDeviceAttributes();

        // Calculate item totals
        foreach ($record->items as $item) {
            $item->total = (int) $item->quantity * (int) $item->price;
            $item->save();
        }

        $record->syncTotalCost();

        ServiceStatusHistory::query()->create([
            'service_id' => $record->id,
            'from_status' => null,
            'to_status' => $record->status,
            'notes' => 'Servis baru dibuat oleh admin (B2B / Multi-Device)',
            'user_id' => auth()->id(),
        ]);
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }
}
