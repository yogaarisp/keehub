<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('+ Tambah Kategori')
                ->modalHeading('Tambah Kategori Baru')
                ->modalSubmitActionLabel('Simpan Kategori')
                ->modalCancelAction(false)
                ->modalWidth(MaxWidth::ThreeExtraLarge)
                ->url(null)
                ->successNotificationTitle('Kategori baru berhasil ditambahkan!')
                ->createAnother(false),
        ];
    }
}
