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

        return $data;
    }

    protected function afterCreate(): void
    {
        /** @var Service $record */
        $record = $this->getRecord();

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
            'notes' => 'Servis baru dibuat oleh admin (B2B / Manual)',
            'user_id' => auth()->id(),
        ]);
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }
}
