<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Filament\Resources\ServiceResource;
use App\Models\Service;
use Filament\Resources\Pages\EditRecord;

class EditService extends EditRecord
{
    protected static string $resource = ServiceResource::class;

    protected function afterSave(): void
    {
        /** @var Service $record */
        $record = $this->getRecord();

        foreach ($record->items as $item) {
            $item->total = (int) $item->quantity * (int) $item->price;
            $item->save();
        }

        $record->syncTotalCost();
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }
}
