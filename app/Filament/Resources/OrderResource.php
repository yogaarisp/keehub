<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use App\Models\Product;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Sales';

    protected static ?string $navigationLabel = 'Pesanan';

    protected static ?string $modelLabel = 'Pesanan';

    protected static ?string $pluralModelLabel = 'Pesanan';

    protected static ?int $navigationSort = 1;

    public static function statusLabel(string $state): string
    {
        return match ($state) {
            'pending' => 'Menunggu',
            'confirmed' => 'Dikonfirmasi',
            'processing' => 'Diproses',
            'ready' => 'Siap Ambil',
            'shipped' => 'Dikirim',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => ucfirst($state),
        };
    }

    public static function statusColor(string $state): string
    {
        return match ($state) {
            'pending' => 'warning',
            'confirmed', 'processing' => 'info',
            'ready', 'shipped' => 'primary',
            'completed' => 'success',
            'cancelled' => 'danger',
            default => 'gray',
        };
    }

    public static function typeLabel(?string $state): string
    {
        return match ($state) {
            'product' => 'Produk Fisik',
            'pc_build' => 'PC Build',
            'service' => 'Layanan Servis',
            'product_service' => 'Produk & Servis',
            default => ucfirst(str_replace('_', ' ', (string) $state)),
        };
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(['default' => 1, 'lg' => 12])->schema([
                Group::make([
                    Section::make('Daftar Produk & Layanan (Items)')
                        ->icon('heroicon-o-shopping-bag')
                        ->description('Pilih produk dari katalog atau masukkan item jasa manual')
                        ->schema([
                            Repeater::make('items')
                                ->relationship()
                                ->hiddenLabel()
                                ->schema([
                                    Select::make('product_id')
                                        ->label('Pilih Produk (Katalog)')
                                        ->options(fn () => Product::query()->where('is_active', true)->pluck('name', 'id'))
                                        ->searchable()
                                        ->live()
                                        ->dehydrated()
                                        ->placeholder('Pilih dari katalog produk toko (opsional)...')
                                        ->afterStateUpdated(function (Get $get, Set $set, ?string $state): void {
                                            if ($state && ($product = Product::find($state))) {
                                                $set('name', $product->name);
                                                $set('price', $product->price);
                                            }
                                        })
                                        ->columnSpan(['default' => 1, 'sm' => 2, 'md' => 6]),

                                    TextInput::make('name')
                                        ->label('Nama Item / Jasa')
                                        ->required()
                                        ->placeholder('Contoh: Keyboard Mechanical RGB')
                                        ->columnSpan(['default' => 1, 'sm' => 2, 'md' => 6]),

                                    Select::make('item_type')
                                        ->label('Kategori Item')
                                        ->options([
                                            'product' => 'Produk Toko',
                                            'build' => 'Komponen PC Build',
                                            'service' => 'Layanan Servis',
                                            'labor' => 'Biaya Jasa / Pasang',
                                            'customer_owned' => 'Customer Owned (Milik User)',
                                        ])
                                        ->default('product')
                                        ->required()
                                        ->columnSpan(['default' => 1, 'sm' => 1, 'md' => 4]),

                                    TextInput::make('quantity')
                                        ->label('Qty')
                                        ->numeric()
                                        ->minValue(1)
                                        ->default(1)
                                        ->required()
                                        ->live(debounce: 350)
                                        ->columnSpan(['default' => 1, 'sm' => 1, 'md' => 3]),

                                    TextInput::make('price')
                                        ->label('Harga Satuan')
                                        ->numeric()
                                        ->prefix('Rp')
                                        ->default(0)
                                        ->required()
                                        ->live(debounce: 350)
                                        ->columnSpan(['default' => 1, 'sm' => 2, 'md' => 5]),
                                ])
                                ->columns(['default' => 1, 'sm' => 2, 'md' => 12])
                                ->defaultItems(1)
                                ->addActionLabel('+ Tambah Item Pesanan')
                                ->itemLabel(fn (array $state): string => filled($state['name'] ?? null)
                                    ? ($state['name'].' ('.($state['quantity'] ?? 1).'x'.(isset($state['price']) ? ' @ Rp '.number_format((int) $state['price'], 0, ',', '.') : '').')')
                                    : 'Item Pesanan Baru'
                                )
                                ->collapsible()
                                ->cloneable()
                                ->collapsed(false)
                                ->deletable()
                                ->reorderable(false),
                        ]),

                    Section::make('Informasi Pelanggan & Pengiriman')
                        ->icon('heroicon-o-truck')
                        ->description('Data pelanggan dan alamat tujuan pengiriman')
                        ->schema([
                            Select::make('customer_id')
                                ->label('Pelanggan')
                                ->relationship('customer', 'name')
                                ->searchable()
                                ->preload()
                                ->placeholder('Pilih pelanggan atau biarkan kosong (Pelanggan Umum)')
                                ->createOptionForm([
                                    TextInput::make('name')->label('Nama Lengkap')->required(),
                                    TextInput::make('whatsapp')->label('No. WhatsApp')->required()->tel(),
                                    TextInput::make('email')->label('Email')->email(),
                                ])
                                ->columnSpanFull(),

                            TextInput::make('shipping_name')
                                ->label('Nama Penerima')
                                ->placeholder('Contoh: Hendra Wijaya')
                                ->columnSpan(['default' => 1, 'sm' => 1]),

                            TextInput::make('shipping_phone')
                                ->label('No. Telepon / WhatsApp')
                                ->tel()
                                ->placeholder('0812-xxxx-xxxx')
                                ->columnSpan(['default' => 1, 'sm' => 1]),

                            Textarea::make('shipping_address')
                                ->label('Alamat Lengkap Pengiriman')
                                ->placeholder('Alamat tujuan pengiriman...')
                                ->rows(2)
                                ->columnSpanFull(),
                        ])
                        ->columns(['default' => 1, 'sm' => 2])
                        ->collapsible(),
                ])->columnSpan(['default' => 1, 'lg' => 8]),

                Group::make([
                    Section::make('Status & Ringkasan Order')
                        ->icon('heroicon-o-calculator')
                        ->schema([
                            Select::make('type')
                                ->label('Tipe Pesanan')
                                ->options([
                                    'product' => 'Produk Fisik',
                                    'pc_build' => 'Perakitan PC',
                                    'service' => 'Layanan Servis',
                                    'product_service' => 'Produk & Servis',
                                ])
                                ->default('product')
                                ->required()
                                ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 2]),

                            Select::make('channel')
                                ->label('Saluran Transaksi')
                                ->options([
                                    'admin' => 'Admin POS / Manual',
                                    'website' => 'Website Online',
                                    'whatsapp' => 'WhatsApp Order',
                                    'offline' => 'Walk-in / Toko Fisik',
                                ])
                                ->default('admin')
                                ->required()
                                ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 2]),

                            Select::make('status')
                                ->label('Status Pesanan')
                                ->options(collect(Order::STATUSES)->mapWithKeys(fn (string $s): array => [$s => static::statusLabel($s)]))
                                ->default('pending')
                                ->hidden(fn (string $operation): bool => $operation === 'create')
                                ->columnSpanFull(),

                            TextInput::make('discount')
                                ->label('Potongan Diskon')
                                ->numeric()
                                ->prefix('Rp')
                                ->default(0)
                                ->minValue(0)
                                ->live(debounce: 350)
                                ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 1]),

                            TextInput::make('shipping_cost')
                                ->label('Biaya Ongkir')
                                ->numeric()
                                ->prefix('Rp')
                                ->default(0)
                                ->minValue(0)
                                ->live(debounce: 350)
                                ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 1]),

                            Placeholder::make('live_summary')
                                ->label('Estimasi Total Order')
                                ->content(function (Get $get): HtmlString {
                                    $items = $get('items') ?? [];
                                    $subtotal = 0;
                                    foreach ($items as $item) {
                                        $subtotal += max(0, (int) ($item['quantity'] ?? 1)) * max(0, (int) ($item['price'] ?? 0));
                                    }
                                    $discount = max(0, (int) ($get('discount') ?? 0));
                                    $shipping = max(0, (int) ($get('shipping_cost') ?? 0));
                                    $total = max(0, $subtotal - $discount + $shipping);

                                    return new HtmlString(
                                        '<div style="display:flex;flex-direction:column;gap:0.25rem;">'
                                        .'<div style="font-size:0.75rem;color:#64748b;">Subtotal: Rp '.number_format($subtotal, 0, ',', '.').'</div>'
                                        .'<div style="font-size:1.25rem;font-weight:700;color:#d97706;">Rp '.number_format($total, 0, ',', '.').'</div>'
                                        .'</div>'
                                    );
                                })
                                ->columnSpanFull(),

                            Textarea::make('notes')
                                ->label('Catatan Pesanan (Opsional)')
                                ->placeholder('Catatan khusus pelanggan atau instruksi internal...')
                                ->rows(3)
                                ->columnSpanFull(),
                        ])
                        ->columns(['default' => 1, 'sm' => 2, 'lg' => 2]),
                ])->columnSpan(['default' => 1, 'lg' => 4]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('No. Pesanan')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold')
                    ->description(fn (Order $record): string => ($record->customer?->name ?? 'Pelanggan Umum').($record->created_at ? ' • '.$record->created_at->format('d M Y') : '')),

                TextColumn::make('customer.name')
                    ->label('Pelanggan')
                    ->default('Pelanggan Umum')
                    ->searchable()
                    ->weight('medium')
                    ->description(fn (Order $record): ?string => $record->customer?->whatsapp)
                    ->visibleFrom('md'),

                TextColumn::make('total')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable()
                    ->weight('bold')
                    ->alignEnd()
                    ->description(fn (Order $record): string => static::typeLabel($record->type))
                    ->visibleFrom('md'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => static::statusColor($state))
                    ->formatStateUsing(fn (string $state): string => static::statusLabel($state))
                    ->description(fn (Order $record): string => 'Rp '.number_format((int) $record->total, 0, ',', '.')),

                TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => static::typeLabel($state))
                    ->color(fn (?string $state): string => match ($state) {
                        'product' => 'info',
                        'pc_build' => 'primary',
                        'service' => 'warning',
                        'product_service' => 'success',
                        default => 'gray',
                    })
                    ->visibleFrom('lg'),

                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->visibleFrom('xl')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options(collect(Order::STATUSES)->mapWithKeys(fn (string $s): array => [$s => static::statusLabel($s)])),
                SelectFilter::make('type')
                    ->label('Tipe Pesanan')
                    ->options(collect(Order::TYPES)->mapWithKeys(fn (string $t): array => [$t => static::typeLabel($t)])),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    Action::make('thermal_receipt')
                        ->label('Cetak Struk Thermal')
                        ->icon('heroicon-o-printer')
                        ->color('success')
                        ->url(fn (Order $record): string => route('admin.order.receipt', $record))
                        ->openUrlInNewTab(),
                ]),
            ])
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
