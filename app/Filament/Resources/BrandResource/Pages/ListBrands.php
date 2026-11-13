<?php

namespace App\Filament\Resources\BrandResource\Pages;

use App\Filament\Resources\BrandResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;

class ListBrands extends ListRecords
{
    protected static string $resource = BrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('+ Tambah Brand')
                ->modalHeading('Tambah Brand Baru')
                ->modalSubmitActionLabel('Simpan Brand')
                ->modalCancelAction(false)
                ->modalWidth(MaxWidth::ThreeExtraLarge)
                ->url(null)
                ->successNotificationTitle('Brand baru berhasil ditambahkan!')
                ->createAnother(false),
        ];
    }
}
