<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Sales';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Order')->schema([
                Select::make('customer_id')->relationship('customer', 'name')->searchable()->preload()
                    ->createOptionForm([
                        TextInput::make('name')->required(),
                        TextInput::make('whatsapp')->required()->tel(),
                        TextInput::make('email')->email(),
                    ]),
                Select::make('type')->options(array_combine(Order::TYPES, array_map(fn ($t) => ucfirst(str_replace('_', ' ', $t)), Order::TYPES)))->default('product'),
                Select::make('channel')->options(array_combine(Order::CHANNELS, array_map(ucfirst(...), Order::CHANNELS)))->default('admin'),
                Select::make('status')->options(array_combine(Order::STATUSES, array_map(ucfirst(...), Order::STATUSES)))->default('pending')->disabled(fn (string $operation) => $operation === 'create'),
                TextInput::make('discount')->numeric()->prefix('Rp')->default(0),
                TextInput::make('shipping_cost')->numeric()->prefix('Rp')->default(0),
                Textarea::make('notes'),
            ])->columns(2),

            Section::make('Items')->schema([
                Repeater::make('items')->relationship()->schema([
                    Select::make('product_id')->label('Produk toko')->options(fn () => Product::query()->where('is_active', true)->pluck('name', 'id'))
                        ->searchable()->live()->dehydrated()
                        ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                            if ($state && ($product = Product::find($state))) {
                                $set('name', $product->name);
                                $set('price', $product->price);
                            }
                        }),
                    TextInput::make('name')->required(),
                    Select::make('item_type')->options(array_combine(OrderItem::TYPES, array_map(fn ($t) => match ($t) {
                        'customer_owned' => 'CUSTOMER OWNED (tidak mengurangi stok)',
                        'product' => 'Product toko',
                        'build' => 'PC Build',
                        'service' => 'Service',
                        'labor' => 'Jasa/Labor',
                    }, OrderItem::TYPES)))->default('product'),
                    TextInput::make('quantity')->numeric()->minValue(1)->default(1),
                    TextInput::make('price')->numeric()->prefix('Rp'),
                ])->columns(5)->defaultItems(1)
                    ->deletable()
                    ->reorderable(false),
            ])->collapsible(),

            Section::make('Pengiriman')->schema([
                TextInput::make('shipping_name'),
                TextInput::make('shipping_phone')->tel(),
                Textarea::make('shipping_address')->rows(2),
            ])->columns(2)->collapsible(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')->searchable()->sortable(),
                TextColumn::make('customer.name')->default('—'),
                TextColumn::make('type')->badge(),
                TextColumn::make('total')->money('IDR')->sortable(),
                TextColumn::make('status')->badge()->color(fn (string $state) => match ($state) {
                    'pending' => 'warning',
                    'confirmed', 'processing' => 'info',
                    'ready', 'shipped' => 'primary',
                    'completed' => 'success',
                    'cancelled' => 'danger',
                }),
                TextColumn::make('created_at')->dateTime('d M Y H:i')->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->options(array_combine(Order::STATUSES, array_map(ucfirst(...), Order::STATUSES))),
            ])
            ->actions([EditAction::make()])
            ->defaultSort('created_at', 'desc')
            ->poll('60s');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
            'view' => Pages\ViewOrder::route('/{record}'),
        ];
    }
}
