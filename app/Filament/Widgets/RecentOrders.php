<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\OrderResource;
use App\Models\Order;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class RecentOrders extends TableWidget
{
    protected static ?string $heading = 'Recent Orders';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()->with('customer')->orderByDesc('created_at')->limit(8)
            )
            ->paginated(false)
            ->columns([
                TextColumn::make('code'),
                TextColumn::make('customer.name')->default('—'),
                TextColumn::make('total')->money('IDR'),
                TextColumn::make('status')->badge(),
                TextColumn::make('created_at')->dateTime('d M Y H:i'),
            ])
            ->recordUrl(fn ($record) => OrderResourceEditUrl::for($record));
    }
}

class OrderResourceEditUrl
{
    public static function for($record): string
    {
        return OrderResource::getUrl('view', ['record' => $record]);
    }
}
