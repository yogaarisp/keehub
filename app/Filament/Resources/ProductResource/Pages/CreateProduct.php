<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Models\Inventory;
use App\Models\ProductImage;
use App\Models\ProductSpec;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $specsData = $data['specs_data'] ?? [];
        $imagesUpload = $data['images_upload'] ?? [];
        unset($data['specs_data'], $data['images_upload']);

        $record = static::getModel()::create($data);

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

        foreach ($imagesUpload as $i => $path) {
            ProductImage::query()->create([
                'product_id' => $record->id,
                'path' => $path,
                'is_primary' => $i === 0,
                'sort_order' => $i,
            ]);
        }

        Inventory::query()->firstOrCreate(
            ['product_id' => $record->id],
            ['current_stock' => 0, 'min_stock' => 2]
        );

        return $record;
    }
}
