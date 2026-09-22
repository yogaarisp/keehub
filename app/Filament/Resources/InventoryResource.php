<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventoryResource\Pages;
use App\Models\Inventory;
use App\Services\InventoryService;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;

class InventoryResource extends Resource
{
    protected static ?string $model = Inventory::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box';

    protected static ?string $navigationGroup = 'Inventory';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Stock';

    protected static ?string $slug = 'stock';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product.sku')->searchable(),
                TextColumn::make('product.name')->searchable()->limit(40),
                TextColumn::make('current_stock')->label('Stok')->badge()
                    ->color(fn ($state, $record) => ($state ?? 0) <= 0 ? 'danger' : (($state ?? 0) <= ($record->min_stock ?? 0) ? 'warning' : 'success')),
                TextColumn::make('min_stock')->label('Minimum'),
            ])
            ->filters([
                Filter::make('low_stock')->query(fn ($query) => $query->whereColumn('current_stock', '<=', 'min_stock'))->label('Low stock'),
            ])
            ->actions([
                Action::make('stock_in')->label('Stock In')->icon('heroicon-m-arrow-down-tray')
                    ->form([
                        TextInput::make('quantity')->numeric()->minValue(1)->required(),
                        Select::make('user_id')->hidden()->default(auth()->id()),
                        Textarea::make('notes'),
                    ])
                    ->action(function ($record, array $data) {
                        $product = $record->product;
                        InventoryService::move($product, 'in', (int) $data['quantity'], 'manual', null, $data['notes'] ?? null, auth()->id());
                        Notification::make()->title('Stock In tercatat')->success()->send();
                    }),
                Action::make('stock_out')->label('Stock Out')->icon('heroicon-m-arrow-up-tray')->color('warning')
                    ->form([
                        TextInput::make('quantity')->numeric()->minValue(1)->required(),
                        Textarea::make('notes'),
                    ])
                    ->action(function ($record, array $data) {
                        try {
                            InventoryService::move($record->product, 'out', (int) $data['quantity'], 'manual', null, $data['notes'] ?? null, auth()->id());
                            Notification::make()->title('Stock Out tercatat')->success()->send();
                        } catch (\DomainException $e) {
                            Notification::make()->title('Gagal')->body($e->getMessage())->danger()->send();
                        }
                    }),
                Action::make('adjust')->label('Adjustment')->icon('heroicon-m-adjustments-horizontal')->color('gray')
                    ->form([
                        TextInput::make('real_stock')->label('Stok fisik hasil opname')->numeric()->minValue(0)->required(),
                        Textarea::make('notes'),
                    ])
                    ->requiresConfirmation()
                    ->action(function ($record, array $data) {
                        $delta = (int) $data['real_stock'] - $record->current_stock;
                        if ($delta !== 0) {
                            InventoryService::move($record->product, 'adjustment', $delta, 'opname', null, $data['notes'] ?? 'Stock opname', auth()->id());
                        }
                        Notification::make()->title('Adjustment tercatat')->success()->send();
                    }),
            ])
            ->defaultSort('product_id');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInventory::route('/'),
            'movements' => Pages\StockMovements::route('/movements'),
        ];
    }
}
