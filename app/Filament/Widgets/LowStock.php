<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\InventoryResource;
use App\Filament\Resources\ProductResource;
use App\Models\Inventory;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class LowStock extends TableWidget
{
    protected static ?string $heading = 'Peringatan Stok Menipis';

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = [
        'default' => 'full',
        'lg' => 5,
    ];

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Inventory::query()
                    ->with('product')
                    ->whereColumn('current_stock', '<=', 'min_stock')
                    ->orderBy('current_stock')
                    ->limit(6)
            )
            ->paginated(false)
            ->headerActions([
                Action::make('manage_stock')
                    ->label('Kelola Stok')
                    ->url(InventoryResource::getUrl('index'))
                    ->color('gray')
                    ->size('xs'),
            ])
            ->columns([
                TextColumn::make('product.name')
                    ->label('Produk')
                    ->limit(32)
                    ->description(fn (Inventory $record): ?string => $record->product?->sku),

                TextColumn::make('current_stock')
                    ->label('Stok')
                    ->badge()
                    ->color(fn ($state): string => ((int) $state) <= 0 ? 'danger' : 'warning')
                    ->alignEnd(),

                TextColumn::make('min_stock')
                    ->label('Min')
                    ->color('gray')
                    ->alignEnd(),
            ])
            ->recordUrl(fn (Inventory $record): ?string => $record->product_id ? ProductResource::getUrl('edit', ['record' => $record->product_id]) : null)
            ->emptyStateHeading('Semua stok aman')
            ->emptyStateDescription('Tidak ada produk di bawah batas minimum.')
            ->emptyStateIcon('heroicon-o-check-circle');
    }
}
