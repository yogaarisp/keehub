<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class RecentOrders extends TableWidget
{
    protected static ?string $heading = 'Pesanan Terbaru';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = [
        'default' => 'full',
        'lg' => 7,
    ];

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()->with('customer')->orderByDesc('created_at')->limit(6)
            )
            ->paginated(false)
            ->headerActions([
                Action::make('all_orders')
                    ->label('Lihat Semua')
                    ->url(OrderResource::getUrl('index'))
                    ->color('gray')
                    ->size('xs'),
            ])
            ->columns([
                TextColumn::make('code')
                    ->label('Kode')
                    ->weight('semibold')
                    ->description(fn (Order $record): string => ($record->customer?->name ?? 'Umum').' • '.$record->created_at->format('d M H:i'))
                    ->searchable(false),

                TextColumn::make('customer.name')
                    ->label('Pelanggan')
                    ->default('—')
                    ->visibleFrom('md'),

                TextColumn::make('total')
                    ->label('Total')
                    ->formatStateUsing(fn ($state): string => 'Rp '.number_format((int) $state, 0, ',', '.'))
                    ->weight('semibold')
                    ->alignEnd(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed', 'processing' => 'info',
                        'ready', 'shipped', 'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Menunggu',
                        'confirmed' => 'Dikonfirmasi',
                        'processing' => 'Diproses',
                        'ready' => 'Siap Ambil',
                        'shipped' => 'Dikirim',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                        default => ucfirst($state),
                    }),
            ])
            ->recordUrl(fn (Order $record): string => OrderResource::getUrl('view', ['record' => $record]))
            ->emptyStateHeading('Belum ada pesanan')
            ->emptyStateIcon('heroicon-o-shopping-bag');
    }
}
