<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('+ Tambah Pengguna')
                ->modalHeading('Tambah Pengguna Baru')
                ->modalSubmitActionLabel('Simpan Pengguna')
                ->modalCancelAction(false)
                ->modalWidth(MaxWidth::ThreeExtraLarge)
                ->url(null)
                ->successNotificationTitle('Pengguna baru berhasil ditambahkan!')
                ->createAnother(false),
        ];
    }
}
