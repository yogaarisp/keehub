<?php

namespace App\Filament\Resources\InventoryResource\Pages;

use App\Filament\Resources\InventoryResource;
use App\Models\StockMovement;
use Filament\Actions\Action;
use Filament\Resources\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class StockMovements extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = InventoryResource::class;

    protected static string $view = 'filament.resources.inventory-resource.pages.stock-movements';

    public function table(Table $table): Table
    {
        return $table
            ->query(StockMovement::query()->with('product', 'user')->orderByDesc('created_at'))
            ->columns([
                TextColumn::make('created_at')->dateTime('d M Y H:i')->sortable(),
                TextColumn::make('product.name')->limit(35),
                TextColumn::make('type')->badge()->color(fn (string $state) => match ($state) {
                    'in' => 'success',
                    'out' => 'danger',
                    'reversal' => 'warning',
                    default => 'gray',
                }),
                TextColumn::make('quantity'),
                TextColumn::make('stock_before'),
                TextColumn::make('stock_after'),
                TextColumn::make('reference_type')->limit(25)->placeholder('—'),
                TextColumn::make('reference_id')->placeholder('—'),
                TextColumn::make('user.name')->placeholder('system'),
                TextColumn::make('notes')->limit(30)->placeholder('—'),
            ])
            ->filters([
                SelectFilter::make('type')->options(array_combine(StockMovement::TYPES, array_map(ucfirst(...), StockMovement::TYPES))),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')->label('Kembali')->url(static::getResource()::getUrl('index')),
        ];
    }
}
