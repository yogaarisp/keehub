<?php

namespace App\Filament\Resources\QcResource\Pages;

use App\Filament\Resources\QcResource;
use Filament\Resources\Pages\CreateRecord;

class CreateQc extends CreateRecord
{
    protected static string $resource = QcResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['checklist'] = [
            'hardware' => array_values($this->data['checklist_hardware'] ?? []),
            'software' => array_values($this->data['checklist_software'] ?? []),
            'testing' => array_values($this->data['checklist_testing'] ?? []),
        ];
        $data['technician_id'] = $data['technician_id'] ?? auth()->id();
        $data['checked_at'] = now();

        return $data;
    }
}
