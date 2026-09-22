<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Services\OrderService;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['channel'] = $data['channel'] ?? 'admin';

        return $data;
    }

    protected function afterCreate(): void
    {
        $order = $this->getRecord();
        $order->recalculateTotalsFromItems();

        if ($order->status !== 'pending') {
            $order->forceFill(['status' => 'pending'])->save();
        }

        OrderService::createInvoice($order);

        OrderStatusHistory::createInitial($order, auth()->user());
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }
}
