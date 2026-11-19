<?php

namespace App\Filament\Resources\ProjectInvoiceResource\Pages;

use App\Filament\Resources\ProjectInvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProjectInvoices extends ListRecords
{
    protected static string $resource = ProjectInvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Buat Invoice Project Baru'),
        ];
    }
}
