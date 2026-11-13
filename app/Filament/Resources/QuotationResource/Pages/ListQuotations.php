<?php

namespace App\Filament\Resources\QuotationResource\Pages;

use App\Filament\Resources\QuotationResource;
use App\Models\Quotation;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;

class ListQuotations extends ListRecords
{
    protected static string $resource = QuotationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('+ Buat Penawaran')
                ->modalHeading('Buat Penawaran Baru')
                ->modalSubmitActionLabel('Simpan Penawaran')
                ->modalCancelAction(false)
                ->modalWidth(MaxWidth::SevenExtraLarge)
                ->url(null)
                ->mutateFormDataUsing(function (array $data): array {
                    $data['code'] = $data['code'] ?? Quotation::generateCode();
                    $data['subtotal'] = (int) ($data['subtotal'] ?? 0);
                    $data['discount'] = max(0, (int) ($data['discount'] ?? 0));
                    $data['shipping'] = max(0, (int) ($data['shipping'] ?? 0));
                    $data['total'] = max(0, $data['subtotal'] - $data['discount'] + $data['shipping']);

                    return $data;
                })
                ->after(function (Quotation $record): void {
                    $subtotal = (int) $record->items()->sum('total');
                    $total = max(0, $subtotal - (int) $record->discount + (int) $record->shipping);

                    $record->update([
                        'code' => $record->code ?: Quotation::generateCode(),
                        'subtotal' => $subtotal,
                        'total' => $total,
                    ]);
                })
                ->successNotificationTitle('Penawaran baru berhasil dibuat!')
                ->successRedirectUrl(fn (Quotation $record): string => QuotationResource::getUrl('view', ['record' => $record]))
                ->createAnother(false),
        ];
    }
}
