<?php

namespace App\Filament\Widgets;

use App\Models\Inventory;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class LowStock extends TableWidget
{
    protected static ?string $heading = 'Low Stock';

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Inventory::query()
                    ->with('product')
                    ->whereColumn('current_stock', '<=', 'min_stock')
                    ->orderBy('current_stock')
                    ->limit(8)
            )
            ->paginated(false)
            ->columns([
                TextColumn::make('product.name')->limit(40),
                TextColumn::make('current_stock'),
                TextColumn::make('min_stock')->label('Min'),
            ]);
    }
}
