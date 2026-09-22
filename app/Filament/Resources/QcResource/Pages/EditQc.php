<?php

namespace App\Filament\Resources\QcResource\Pages;

use App\Filament\Resources\QcResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditQc extends EditRecord
{
    protected static string $resource = QcResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
