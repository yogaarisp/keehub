<?php

namespace App\Filament\Widgets;

use App\Models\Inventory;
use App\Models\Order;
use App\Models\Payment;
use App\Models\PcBuild;
use App\Models\Service;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected static ?string $pollingInterval = '60s';

    protected function getStats(): array
    {
        $salesToday = (float) Payment::query()->whereDate('paid_at', today())->sum('amount');

        $ordersToday = Order::query()->whereDate('created_at', today())->count();

        $serviceToday = Service::query()->whereDate('created_at', today())->count();

        $lowStock = Inventory::query()->whereColumn('current_stock', '<=', 'min_stock')->count();

        $pendingBuildRequests = PcBuild::query()->where('status', 'draft')->whereHas('user')->count();

        return [
            Stat::make('Sales Today', 'Rp '.number_format($salesToday, 0, ',', '.'))
                ->description('Total payment tercatat hari ini')
                ->color('success')
                ->icon('heroicon-m-banknotes'),
            Stat::make('Orders Today', (string) $ordersToday)->color('info')->icon('heroicon-m-shopping-bag'),
            Stat::make('Service Today', (string) $serviceToday)->color('warning')->icon('heroicon-m-wrench-screwdriver'),
            Stat::make('Low Stock', (string) $lowStock)->color($lowStock > 0 ? 'danger' : 'success')->icon('heroicon-m-exclamation-triangle'),
            Stat::make('Build Requests', (string) $pendingBuildRequests)->description('PC Build tersimpan (draft)')->color('gray')->icon('heroicon-m-computer-desktop'),
        ];
    }
}
