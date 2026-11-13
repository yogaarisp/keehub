<?php

namespace App\Filament\Resources\QuotationResource\Pages;

use App\Filament\Resources\QuotationResource;
use App\Models\Quotation;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditQuotation extends EditRecord
{
    protected static string $resource = QuotationResource::class;

    public function getHeading(): string
    {
        return 'Ubah Penawaran '.$this->record->code;
    }

    public function getSubheading(): ?string
    {
        return ($this->record->customer?->name ?? 'Pelanggan Umum')
            .' • Rp '.number_format((int) $this->record->total, 0, ',', '.');
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()->label('Lihat Detail'),
            DeleteAction::make()->label('Hapus'),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['subtotal'] = (int) ($data['subtotal'] ?? 0);
        $data['discount'] = max(0, (int) ($data['discount'] ?? 0));
        $data['shipping'] = max(0, (int) ($data['shipping'] ?? 0));
        $data['total'] = max(0, $data['subtotal'] - $data['discount'] + $data['shipping']);

        return $data;
    }

    protected function afterSave(): void
    {
        /** @var Quotation $quotation */
        $quotation = $this->getRecord();
        $subtotal = (int) $quotation->items()->sum('total');
        $total = max(0, $subtotal - (int) $quotation->discount + (int) $quotation->shipping);

        $quotation->update([
            'subtotal' => $subtotal,
            'total' => $total,
        ]);
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }
}

