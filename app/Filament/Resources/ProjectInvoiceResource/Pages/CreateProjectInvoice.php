<?php

namespace App\Filament\Resources\ProjectInvoiceResource\Pages;

use App\Filament\Resources\ProjectInvoiceResource;
use App\Models\ProjectInvoice;
use Filament\Resources\Pages\CreateRecord;

class CreateProjectInvoice extends CreateRecord
{
    protected static string $resource = ProjectInvoiceResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['code'] = $data['code'] ?? ProjectInvoice::generateCode();

        $subtotal = 0;
        if (! empty($data['items']) && is_array($data['items'])) {
            foreach ($data['items'] as $item) {
                $qty = max(1, (int) ($item['quantity'] ?? 1));
                $price = max(0, (int) ($item['price'] ?? 0));
                $subtotal += ($qty * $price);
            }
        }

        $discount = max(0, (int) ($data['discount'] ?? 0));
        $tax = max(0, (int) ($data['tax'] ?? 0));
        $total = max(0, $subtotal - $discount + $tax);

        $data['subtotal'] = $subtotal;
        $data['total'] = $total;

        return $data;
    }

    protected function afterCreate(): void
    {
        $invoice = $this->getRecord();
        $subtotal = (int) $invoice->items()->sum('total');
        $discount = max(0, (int) $invoice->discount);
        $tax = max(0, (int) $invoice->tax);
        $total = max(0, $subtotal - $discount + $tax);

        $invoice->update([
            'subtotal' => $subtotal,
            'total' => $total,
        ]);
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
