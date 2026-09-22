<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\ProductImage;
use App\Models\ProductSpec;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['specs_data'] = $this->getRecord()->specs->map(fn ($spec) => [
            'key' => $spec->key,
            'value' => $spec->value,
            'value_numeric' => $spec->value_numeric,
            'unit' => $spec->unit,
        ])->toArray();

        $data['images_upload'] = $this->getRecord()->images->pluck('path')->toArray();

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $specsData = $data['specs_data'] ?? [];
        $imagesUpload = $data['images_upload'] ?? [];
        unset($data['specs_data'], $data['images_upload']);

        $record->update($data);

        $record->specs()->delete();
        foreach ($specsData as $i => $spec) {
            ProductSpec::query()->create([
                'product_id' => $record->id,
                'key' => $spec['key'],
                'value' => $spec['value'],
                'value_numeric' => $spec['value_numeric'] ?? null,
                'unit' => $spec['unit'] ?? null,
                'sort_order' => $i,
            ]);
        }

        $record->images()->delete();
        foreach ($imagesUpload as $i => $path) {
            ProductImage::query()->create([
                'product_id' => $record->id,
                'path' => $path,
                'is_primary' => $i === 0,
                'sort_order' => $i,
            ]);
        }

        return $record;
    }
}
