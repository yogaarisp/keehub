<?php

namespace App\Filament\Resources\ShipmentResource\Pages;

use App\Filament\Resources\ShipmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;

class ListShipments extends ListRecords
{
    protected static string $resource = ShipmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('+ Buat Pengiriman')
                ->modalHeading('Buat Pengiriman Baru')
                ->modalSubmitActionLabel('Simpan Pengiriman')
                ->modalCancelAction(false)
                ->modalWidth(MaxWidth::SevenExtraLarge)
                ->url(null)
                ->mutateFormDataUsing(function (array $data): array {
                    if (! empty($data['is_pickup'])) {
                        $data['courier'] = $data['courier'] ?? 'Pickup at Store';
                    }

                    return $data;
                })
                ->successNotificationTitle('Pengiriman baru berhasil dibuat!')
                ->createAnother(false),
        ];
    }
}
