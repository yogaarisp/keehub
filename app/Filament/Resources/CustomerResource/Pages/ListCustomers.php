<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;

class ListCustomers extends ListRecords
{
    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('+ Pelanggan Baru')
                ->modalHeading('Tambah Pelanggan Baru')
                ->modalSubmitActionLabel('Simpan Pelanggan')
                ->modalCancelAction(false)
                ->modalWidth(MaxWidth::ThreeExtraLarge)
                ->url(null)
                ->createAnother(false)
                ->successNotificationTitle('Pelanggan baru berhasil ditambahkan!'),
        ];
    }
}
