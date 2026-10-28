<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use App\Services\OrderService;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\MaxWidth;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('+ Buat Order')
                ->modalHeading('Buat Pesanan Baru')
                ->modalWidth(MaxWidth::FourExtraLarge)
                ->slideOver()
                ->url(null)
                ->mutateFormDataUsing(function (array $data): array {
                    $data['channel'] = $data['channel'] ?? 'admin';

                    return $data;
                })
                ->after(function (Order $record) {
                    $record->recalculateTotalsFromItems();

                    if ($record->status !== 'pending') {
                        $record->forceFill(['status' => 'pending'])->save();
                    }

                    OrderService::createInvoice($record);

                    OrderStatusHistory::createInitial($record, auth()->user());
                })
                ->successNotificationTitle('Pesanan baru berhasil dibuat!')
                ->successRedirectUrl(fn (Order $record): string => OrderResource::getUrl('view', ['record' => $record]))
                ->createAnother(false),
        ];
    }
}
