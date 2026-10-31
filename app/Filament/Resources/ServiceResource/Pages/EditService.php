<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Filament\Resources\ServiceResource;
use App\Models\Service;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditService extends EditRecord
{
    protected static string $resource = ServiceResource::class;

    public function getHeading(): string
    {
        return 'Ubah Servis '.$this->record->code;
    }

    public function getSubheading(): ?string
    {
        return ($this->record->customer?->name ?? 'Klien Umum')
            .($this->record->device_name ? ' • '.$this->record->device_name : '');
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()
                ->label('Lihat Detail'),
            DeleteAction::make()
                ->label('Hapus Servis'),
        ];
    }

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
