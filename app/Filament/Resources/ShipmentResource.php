<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShipmentResource\Pages;
use App\Models\Order;
use App\Models\Shipment;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class ShipmentResource extends Resource
{
    protected static ?string $model = Shipment::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationGroup = 'Sales';

    protected static ?string $navigationLabel = 'Pengiriman';

    protected static ?string $modelLabel = 'Pengiriman';

    protected static ?string $pluralModelLabel = 'Pengiriman';

    protected static ?int $navigationSort = 4;

    public static function statusLabel(string $state): string
    {
        return match ($state) {
            'preparing' => 'Disiapkan',
            'shipped' => 'Dikirim',
            'in_transit' => 'Dalam Perjalanan',
            'delivered' => 'Terkirim',
            'pickup' => 'Ambil di Toko',
            default => str_replace('_', ' ', ucfirst($state)),
        };
    }

    public static function statusColor(string $state): string
    {
        return match ($state) {
            'preparing' => 'warning',
            'shipped' => 'info',
            'in_transit' => 'primary',
            'delivered' => 'success',
            'pickup' => 'gray',
            default => 'gray',
        };
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(['default' => 1, 'lg' => 12])->schema([
                Group::make([
                    Section::make('Detail Pesanan & Tujuan Pengiriman')
                        ->icon('heroicon-o-truck')
                        ->description('Pilih pesanan pelanggan dan masukkan ekspedisi atau opsi pickup toko')
                        ->schema([
                            Select::make('order_id')
                                ->label('Pilih Pesanan')
                                ->relationship('order', 'code')
                                ->searchable()
                                ->preload()
                                ->required()
                                ->live()
                                ->getOptionLabelFromRecordUsing(fn (Order $record): string => "{$record->code} — ".($record->customer?->name ?? 'Pelanggan Umum').' (Rp '.number_format($record->total, 0, ',', '.').')')
                                ->columnSpanFull(),

                            Checkbox::make('is_pickup')
                                ->label('Pickup at Store (Pelanggan ambil langsung di toko fisik — tanpa resi kurir)')
                                ->live()
                                ->columnSpanFull(),

                            Select::make('courier')
                                ->label('Kurir / Ekspedisi')
                                ->options(array_combine(Shipment::COURIERS, Shipment::COURIERS))
                                ->hidden(fn (Get $get): bool => (bool) $get('is_pickup'))
                                ->required(fn (Get $get): bool => ! (bool) $get('is_pickup'))
                                ->columnSpan(['default' => 1, 'sm' => 1]),

                            TextInput::make('tracking_number')
                                ->label('No. Resi Pengiriman')
                                ->placeholder('Contoh: JP9812941204 / Resi Kurir')
                                ->hidden(fn (Get $get): bool => (bool) $get('is_pickup'))
                                ->columnSpan(['default' => 1, 'sm' => 1]),

                            Textarea::make('notes')
                                ->label('Catatan Pengiriman (Opsional)')
                                ->placeholder('Instruksi khusus pengiriman atau keterangan paket...')
                                ->rows(3)
                                ->columnSpanFull(),
                        ])
                        ->columns(['default' => 1, 'sm' => 2]),
                ])->columnSpan(['default' => 1, 'lg' => 8]),

                Group::make([
                    Section::make('Status & Biaya Kirim')
                        ->icon('heroicon-o-calculator')
                        ->schema([
                            Select::make('status')
                                ->label('Status Pengiriman')
                                ->options(collect(Shipment::STATUSES)->mapWithKeys(fn (string $s): array => [$s => static::statusLabel($s)]))
                                ->default('preparing')
                                ->required()
                                ->columnSpanFull(),

                            DatePicker::make('shipped_at')
                                ->label('Tanggal Kirim')
                                ->default(today())
                                ->columnSpanFull(),

                            TextInput::make('shipping_cost')
                                ->label('Biaya Ongkir')
                                ->numeric()
                                ->prefix('Rp')
                                ->default(0)
                                ->minValue(0)
                                ->live(debounce: 350)
                                ->columnSpanFull(),

                            Placeholder::make('order_summary')
                                ->label('Informasi Penerima')
                                ->content(function (Get $get): HtmlString {
                                    $orderId = $get('order_id');
                                    if (! $orderId || ! ($order = Order::find($orderId))) {
                                        return new HtmlString(
                                            '<div style="font-size:0.8rem;color:#64748b;font-style:italic;">'
                                            .'Pilih pesanan di samping untuk melihat data penerima & alamat.'
                                            .'</div>'
                                        );
                                    }

                                    $recipient = $order->shipping_name ?: ($order->customer?->name ?? 'Pelanggan Umum');
                                    $phone = $order->shipping_phone ?: ($order->customer?->whatsapp ?? '-');
                                    $address = $order->shipping_address ?: 'Pickup di Toko / Alamat belum diisi';

                                    return new HtmlString(
                                        '<div style="display:flex;flex-direction:column;gap:0.35rem;font-size:0.8rem;">'
                                        .'<div style="color:#64748b;">Penerima: <strong style="color:#0f172a;">'.$recipient.'</strong></div>'
                                        .'<div style="color:#64748b;">Telepon / WA: <strong style="color:#0f172a;">'.$phone.'</strong></div>'
                                        .'<div style="border-top:1px dashed #cbd5e1;margin-top:0.25rem;padding-top:0.25rem;"></div>'
                                        .'<div style="color:#64748b;">Alamat Tujuan:</div>'
                                        .'<div style="color:#334155;line-height:1.35;word-break:break-word;">'.nl2br(e($address)).'</div>'
                                        .'</div>'
                                    );
                                })
                                ->columnSpanFull(),
                        ])
                        ->columns(1),
                ])->columnSpan(['default' => 1, 'lg' => 4]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order.code')
                    ->label('No. Pesanan')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold')
                    ->description(fn (Shipment $record): string => ($record->is_pickup ? 'Pickup di Toko' : ($record->courier ?: 'Kurir')).($record->tracking_number ? ' • '.$record->tracking_number : '')),
                TextColumn::make('courier')
                    ->label('Kurir')
                    ->placeholder('Pickup')
                    ->visibleFrom('md'),
                TextColumn::make('tracking_number')
                    ->label('Resi')
                    ->searchable()
                    ->copyable()
                    ->placeholder('—')
                    ->visibleFrom('lg'),
                TextColumn::make('shipping_cost')
                    ->label('Ongkir')
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
                    ->description(fn (Shipment $record): string => 'Rp '.number_format((int) ($record->shipping_cost ?? 0), 0, ',', '.')),
                TextColumn::make('shipped_at')
                    ->label('Tgl Kirim')
                    ->date('d M Y')
                    ->sortable()
                    ->visibleFrom('lg'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status Pengiriman')
                    ->options(collect(Shipment::STATUSES)->mapWithKeys(fn (string $s): array => [$s => static::statusLabel($s)])),
                SelectFilter::make('courier')
                    ->label('Kurir')
                    ->options(array_combine(Shipment::COURIERS, Shipment::COURIERS)),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShipments::route('/'),
            'create' => Pages\CreateShipment::route('/create'),
            'edit' => Pages\EditShipment::route('/{record}/edit'),
            'view' => Pages\ViewShipment::route('/{record}'),
        ];
    }
}
