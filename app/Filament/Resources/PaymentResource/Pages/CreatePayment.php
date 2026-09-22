<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use App\Filament\Resources\PaymentResource;
use App\Models\Invoice;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreatePayment extends CreateRecord
{
    protected static string $resource = PaymentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }

    protected function beforeCreate(): void
    {
        $invoice = Invoice::findOrFail($this->data['invoice_id'] ?? null);

        try {
            PaymentService::record(
                $invoice,
                $this->data['method'],
                (int) $this->data['amount'],
                $this->data['paid_at'],
                $this->data['reference'] ?? null,
                $this->data['notes'] ?? null,
                auth()->id()
            );

            $this->halt();

            Notification::make()->title('Payment tercatat')->body('Status invoice diperbarui otomatis.')->success()->send();

            $this->redirect(static::getResource()::getUrl('index'));
        } catch (\DomainException $e) {
            Notification::make()->title('Gagal mencatat payment')->body($e->getMessage())->danger()->send();
            $this->halt();
        }
    }
}
