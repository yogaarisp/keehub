<?php

namespace App\Filament\Resources\QuotationResource\Pages;

use App\Filament\Resources\QuotationResource;
use App\Models\Quotation;
use Filament\Resources\Pages\CreateRecord;

class CreateQuotation extends CreateRecord
{
    protected static string $resource = QuotationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['code'] = $data['code'] ?? Quotation::generateCode();
        $data['subtotal'] = (int) ($data['subtotal'] ?? 0);
        $data['discount'] = max(0, (int) ($data['discount'] ?? 0));
        $data['shipping'] = max(0, (int) ($data['shipping'] ?? 0));
        $data['total'] = max(0, $data['subtotal'] - $data['discount'] + $data['shipping']);

        return $data;
    }

    protected function afterCreate(): void
    {
        $quotation = $this->getRecord();
        $subtotal = (int) $quotation->items()->sum('total');
        $total = max(0, $subtotal - (int) $quotation->discount + (int) $quotation->shipping);

        $quotation->update([
            'code' => $quotation->code ?: Quotation::generateCode(),
            'subtotal' => $subtotal,
            'total' => $total,
        ]);
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }
}
