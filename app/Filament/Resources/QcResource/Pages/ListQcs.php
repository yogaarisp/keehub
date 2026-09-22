<?php

namespace App\Filament\Resources\QcResource\Pages;

use App\Filament\Resources\QcResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListQcs extends ListRecords
{
    protected static string $resource = QcResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
