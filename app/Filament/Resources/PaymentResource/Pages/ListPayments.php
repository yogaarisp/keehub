<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use App\Filament\Resources\PaymentResource;
use App\Models\Invoice;
use App\Models\Payment;
use App\Services\PaymentService;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;

class ListPayments extends ListRecords
{
    protected static string $resource = PaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('+ Catat Pembayaran')
                ->modalHeading('Catat Pembayaran Baru')
                ->modalSubmitActionLabel('Simpan Pembayaran')
                ->modalCancelAction(false)
                ->modalWidth(MaxWidth::SevenExtraLarge)
                ->url(null)
                ->using(function (array $data): Payment {
                    $invoice = Invoice::findOrFail($data['invoice_id']);

                    return PaymentService::record(
                        $invoice,
                        $data['method'],
                        (int) $data['amount'],
                        $data['paid_at'],
                        $data['reference'] ?? null,
                        $data['notes'] ?? null,
                        auth()->id()
                    );
                })
                ->successNotificationTitle('Pembayaran berhasil dicatat!')
                ->createAnother(false),
        ];
    }
}
