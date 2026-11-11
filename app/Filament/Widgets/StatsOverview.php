<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\InventoryResource;
use App\Filament\Resources\OrderResource;
use App\Filament\Resources\PaymentResource;
use App\Filament\Resources\ServiceResource;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Service;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected static ?string $pollingInterval = '60s';

    protected function getColumns(): int
    {
        return 4;
    }

    protected function getStats(): array
    {
        $salesToday = (float) Payment::query()->whereDate('paid_at', today())->sum('amount');
        $salesMonth = (float) Payment::query()
            ->whereYear('paid_at', now()->year)
            ->whereMonth('paid_at', now()->month)
            ->sum('amount');

        $ordersToday = Order::query()->whereDate('created_at', today())->count();
        $pendingOrders = Order::query()->whereIn('status', ['pending', 'confirmed', 'processing'])->count();

        $activeServices = Service::query()->whereNotIn('status', ['completed', 'cancelled'])->count();
        $serviceToday = Service::query()->whereDate('created_at', today())->count();

        $lowStock = Inventory::query()->whereColumn('current_stock', '<=', 'min_stock')->count();

        return [
            Stat::make('Penjualan Hari Ini', 'Rp '.number_format($salesToday, 0, ',', '.'))
                ->description('Bulan ini: Rp '.number_format($salesMonth, 0, ',', '.'))
                ->color('success')
                ->icon('heroicon-m-banknotes')
                ->url(PaymentResource::getUrl('index')),

            Stat::make('Pesanan Hari Ini', (string) $ordersToday)
                ->description($pendingOrders.' pesanan perlu diproses')
                ->color('info')
                ->icon('heroicon-m-shopping-bag')
                ->url(OrderResource::getUrl('index')),

            Stat::make('Servis Aktif', (string) $activeServices)
                ->description($serviceToday.' unit masuk hari ini')
                ->color('warning')
                ->icon('heroicon-m-wrench-screwdriver')
                ->url(ServiceResource::getUrl('index')),

            Stat::make('Stok Menipis', (string) $lowStock)
                ->description($lowStock > 0 ? 'Perlu restock segera' : 'Semua stok aman')
                ->color($lowStock > 0 ? 'danger' : 'success')
                ->icon('heroicon-m-archive-box')
                ->url(InventoryResource::getUrl('index')),
        ];
    }
}
