<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuotationResource\Pages;
use App\Models\Product;
use App\Models\Quotation;
use App\Services\QuotationService;
use Filament\Forms\Components\DatePicker;
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
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class QuotationResource extends Resource
{
    protected static ?string $model = Quotation::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Sales';

    protected static ?string $navigationLabel = 'Penawaran';

    protected static ?string $modelLabel = 'Penawaran';

    protected static ?string $pluralModelLabel = 'Penawaran';

    protected static ?int $navigationSort = 2;

    public static function statusLabel(string $state): string
    {
        return match ($state) {
            'draft' => 'Draft',
            'sent' => 'Terkirim',
            'accepted' => 'Disetujui',
            'rejected' => 'Ditolak',
            'expired' => 'Kedaluwarsa',
            'converted' => 'Jadi Order',
            default => ucfirst($state),
        };
    }

    public static function statusColor(string $state): string
    {
        return match ($state) {
            'draft' => 'gray',
            'sent' => 'info',
            'accepted' => 'success',
            'rejected' => 'danger',
            'expired' => 'warning',
            'converted' => 'primary',
            default => 'gray',
        };
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(['default' => 1, 'lg' => 12])->schema([
                Group::make([
                    Section::make('Daftar Item Penawaran')
                        ->icon('heroicon-o-document-text')
                        ->description('Rincian produk atau jasa yang ditawarkan kepada pelanggan')
                        ->schema([
                            Repeater::make('items')
                                ->relationship('items')
                                ->hiddenLabel()
                                ->schema([
                                    Select::make('product_id')
                                        ->label('Pilih Produk (Katalog)')
                                        ->options(fn () => Product::query()->where('is_active', true)->pluck('name', 'id'))
                                        ->searchable()
                                        ->live()
                                        ->dehydrated()
                                        ->placeholder('Pilih dari katalog produk (opsional)...')
                                        ->afterStateUpdated(function (Get $get, Set $set, ?string $state): void {
                                            if ($state && ($product = Product::find($state))) {
                                                $set('name', $product->name);
                                                $set('price', $product->price);
                                                $set('item_type', 'product');
                                            }
                                        })
                                        ->columnSpan(['default' => 1, 'sm' => 2, 'md' => 6]),

                                    TextInput::make('name')
                                        ->label('Nama Item / Jasa')
                                        ->required()
                                        ->placeholder('Contoh: Paket Rakit PC Editing')
                                        ->columnSpan(['default' => 1, 'sm' => 2, 'md' => 6]),

                                    Select::make('item_type')
                                        ->label('Jenis Item')
                                        ->options([
                                            'product' => 'Produk Toko',
                                            'build' => 'Komponen Build',
                                            'service' => 'Layanan Servis',
                                            'labor' => 'Biaya Jasa',
                                            'custom' => 'Item Kustom',
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
                                        ->minValue(0)
                                        ->required()
                                        ->live(debounce: 350)
                                        ->columnSpan(['default' => 1, 'sm' => 2, 'md' => 5]),
                                ])
                                ->columns(['default' => 1, 'sm' => 2, 'md' => 12])
                                ->defaultItems(1)
                                ->addActionLabel('+ Tambah Item Penawaran')
                                ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                                    $qty = max(1, (int) ($data['quantity'] ?? 1));
                                    $price = max(0, (int) ($data['price'] ?? 0));
                                    $data['quantity'] = $qty;
                                    $data['price'] = $price;
                                    $data['total'] = $qty * $price;

                                    return $data;
                                })
                                ->mutateRelationshipDataBeforeSaveUsing(function (array $data): array {
                                    $qty = max(1, (int) ($data['quantity'] ?? 1));
                                    $price = max(0, (int) ($data['price'] ?? 0));
                                    $data['quantity'] = $qty;
                                    $data['price'] = $price;
                                    $data['total'] = $qty * $price;

                                    return $data;
                                })
                                ->collapsible()
                                ->reorderable(false),
                        ]),

                    Section::make('Catatan & Syarat Penawaran')
                        ->icon('heroicon-o-clipboard-document-list')
                        ->schema([
                            Textarea::make('notes')
                                ->label('Catatan Penawaran')
                                ->rows(2)
                                ->placeholder('Catatan untuk pelanggan atau spesifikasi singkat...'),
                            Textarea::make('terms')
                                ->label('Syarat & Ketentuan')
                                ->rows(2)
                                ->placeholder('Misal: Harga berlaku 14 hari, garansi resmi distributor...'),
                        ])
                        ->columns(['default' => 1, 'sm' => 2])
                        ->collapsible(),
                ])->columnSpan(['default' => 1, 'lg' => 8]),

                Group::make([
                    Section::make('Detail & Kalkulasi')
                        ->icon('heroicon-o-calculator')
                        ->schema([
                            Select::make('customer_id')
                                ->label('Pelanggan')
                                ->relationship('customer', 'name')
                                ->searchable()
                                ->preload()
                                ->placeholder('Pilih pelanggan...')
                                ->columnSpanFull(),

                            DatePicker::make('quotation_date')
                                ->label('Tanggal Penawaran')
                                ->default(today())
                                ->required()
                                ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 1]),

                            DatePicker::make('expired_date')
                                ->label('Berlaku Hingga')
                                ->default(fn () => today()->addDays(14))
                                ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 1]),

                            Select::make('status')
                                ->label('Status Penawaran')
                                ->options(collect(Quotation::STATUSES)->mapWithKeys(fn (string $s): array => [$s => static::statusLabel($s)]))
                                ->default('draft')
                                ->required()
                                ->columnSpanFull(),

                            TextInput::make('discount')
                                ->label('Potongan Diskon')
                                ->numeric()
                                ->prefix('Rp')
                                ->default(0)
                                ->minValue(0)
                                ->live(debounce: 350)
                                ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 1]),

                            TextInput::make('shipping')
                                ->label('Biaya Pengiriman')
                                ->numeric()
                                ->prefix('Rp')
                                ->default(0)
                                ->minValue(0)
                                ->live(debounce: 350)
                                ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 1]),

                            Placeholder::make('live_summary')
                                ->label('Estimasi Total Penawaran')
                                ->content(function (Get $get): HtmlString {
                                    $items = $get('items') ?? [];
                                    $subtotal = 0;
                                    foreach ($items as $item) {
                                        $subtotal += max(0, (int) ($item['quantity'] ?? 1)) * max(0, (int) ($item['price'] ?? 0));
                                    }
                                    $discount = max(0, (int) ($get('discount') ?? 0));
                                    $shipping = max(0, (int) ($get('shipping') ?? 0));
                                    $total = max(0, $subtotal - $discount + $shipping);

                                    return new HtmlString(
                                        '<div style="display:flex;flex-direction:column;gap:0.25rem;">'
                                        .'<div style="font-size:0.75rem;color:#64748b;">Subtotal: Rp '.number_format($subtotal, 0, ',', '.').'</div>'
                                        .'<div style="font-size:1.25rem;font-weight:700;color:#d97706;">Rp '.number_format($total, 0, ',', '.').'</div>'
                                        .'</div>'
                                    );
                                })
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
                    ->label('No. Penawaran')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold')
                    ->description(fn (Quotation $record): string => ($record->customer?->name ?? 'Pelanggan Umum').($record->expired_date ? ' • Exp '.$record->expired_date->format('d M Y') : '')),

                TextColumn::make('customer.name')
                    ->label('Pelanggan')
                    ->default('—')
                    ->searchable()
                    ->weight('medium')
                    ->visibleFrom('md'),

                TextColumn::make('total')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable()
                    ->weight('bold')
                    ->alignEnd()
                    ->visibleFrom('md'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => static::statusColor($state))
                    ->formatStateUsing(fn (string $state): string => static::statusLabel($state))
                    ->description(fn (Quotation $record): string => 'Rp '.number_format((int) $record->total, 0, ',', '.')),

                TextColumn::make('quotation_date')
                    ->label('Tgl Penawaran')
                    ->date('d M Y')
                    ->sortable()
                    ->visibleFrom('lg'),

                TextColumn::make('expired_date')
                    ->label('Berlaku Hingga')
                    ->date('d M Y')
                    ->placeholder('—')
                    ->visibleFrom('xl'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options(collect(Quotation::STATUSES)->mapWithKeys(fn (string $s): array => [$s => static::statusLabel($s)])),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    Action::make('mark_sent')
                        ->label('Tandai Terkirim')
                        ->icon('heroicon-o-paper-airplane')
                        ->color('info')
                        ->visible(fn (Quotation $record): bool => $record->status === 'draft')
                        ->action(function (Quotation $record): void {
                            QuotationService::markSent($record);
                            Notification::make()->title('Penawaran ditandai terkirim')->success()->send();
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuotations::route('/'),
            'create' => Pages\CreateQuotation::route('/create'),
            'view' => Pages\ViewQuotation::route('/{record}'),
        ];
    }
}
