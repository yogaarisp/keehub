<?php

namespace App\Filament\Pages;

use App\Filament\Resources\OrderResource;
use App\Filament\Resources\ServiceResource;
use Filament\Actions\Action;
use Illuminate\Contracts\Support\Htmlable;

class Dashboard extends \Filament\Pages\Dashboard
{
    public function getTitle(): string|Htmlable
    {
        return 'Dashboard';
    }

    public function getSubheading(): ?string
    {
        return 'Ringkasan penjualan, antrean servis, dan status stok KeeHub hari ini.';
    }

    public static function getNavigationLabel(): string
    {
        return 'Dashboard';
    }

    public function getColumns(): int|string|array
    {
        return [
            'default' => 1,
            'lg' => 12,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('new_order')
                ->label('Pesanan Baru')
                ->icon('heroicon-m-plus')
                ->color('primary')
                ->url(fn (): string => OrderResource::getUrl('create')),

            Action::make('new_service')
                ->label('Servis Baru')
                ->icon('heroicon-m-wrench-screwdriver')
                ->color('gray')
                ->url(fn (): string => ServiceResource::getUrl('create')),

            Action::make('reports')
                ->label('Laporan')
                ->icon('heroicon-m-chart-bar')
                ->color('gray')
                ->url(fn (): string => Reports::getUrl()),
        ];
    }
}
