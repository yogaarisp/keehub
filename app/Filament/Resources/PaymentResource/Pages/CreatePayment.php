<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use App\Filament\Resources\PaymentResource;
use App\Models\Invoice;
use App\Services\PaymentService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreatePayment extends CreateRecord
{
    protected static string $resource = PaymentResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $invoice = Invoice::findOrFail($data['invoice_id'] ?? null);

        return PaymentService::record(
            $invoice,
            $data['method'],
            (int) $data['amount'],
            $data['paid_at'],
            $data['reference'] ?? null,
            $data['notes'] ?? null,
            auth()->id()
        );
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
