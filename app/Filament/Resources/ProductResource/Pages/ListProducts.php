<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\Product;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('+ Tambah Produk')
                ->modalHeading('Tambah Produk Baru')
                ->modalSubmitActionLabel('Simpan Produk')
                ->modalCancelAction(false)
                ->modalWidth(MaxWidth::SevenExtraLarge)
                ->url(null)
                ->using(fn (array $data): Product => ProductResource::createProductWithRelations($data))
                ->successNotificationTitle('Produk baru berhasil ditambahkan!')
                ->createAnother(false),
        ];
    }
}
