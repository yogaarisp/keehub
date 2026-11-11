<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShipmentResource\Pages;
use App\Models\Shipment;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ShipmentResource extends Resource
{
    protected static ?string $model = Shipment::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationGroup = 'Sales';

    protected static ?string $navigationLabel = 'Pengiriman';

    protected static ?string $modelLabel = 'Pengiriman';

    protected static ?string $pluralModelLabel = 'Pengiriman';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Detail Pengiriman')
                ->icon('heroicon-o-truck')
                ->schema([
                    Select::make('order_id')
                        ->label('Pesanan')
                        ->relationship('order', 'code')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Select::make('status')
                        ->label('Status Pengiriman')
                        ->options(array_combine(Shipment::STATUSES, array_map(fn ($s) => str_replace('_', ' ', ucfirst($s)), Shipment::STATUSES)))
                        ->default('preparing'),
                    Checkbox::make('is_pickup')
                        ->label('Pickup at Store (tanpa resi)')
                        ->live()
                        ->columnSpanFull(),
                    Select::make('courier')
                        ->label('Kurir / Ekspedisi')
                        ->options(array_combine(Shipment::COURIERS, Shipment::COURIERS))
                        ->hidden(fn ($get) => $get('is_pickup')),
                    TextInput::make('tracking_number')
                        ->label('No. Resi')
                        ->hidden(fn ($get) => $get('is_pickup')),
                    TextInput::make('shipping_cost')
                        ->label('Biaya Ongkir')
                        ->numeric()
                        ->prefix('Rp'),
                    DatePicker::make('shipped_at')
                        ->label('Tanggal Kirim'),
                    Textarea::make('notes')
                        ->label('Catatan')
                        ->columnSpanFull(),
                ])
                ->columns(['default' => 1, 'sm' => 2]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order.code')
                    ->label('No. Pesanan')
                    ->searchable()
                    ->weight('bold')
                    ->description(fn (Shipment $record): string => ($record->courier ?: 'Pickup').($record->tracking_number ? ' • '.$record->tracking_number : '')),
                TextColumn::make('courier')->label('Kurir')->placeholder('Pickup')->visibleFrom('md'),
                TextColumn::make('tracking_number')->label('Resi')->searchable()->copyable()->placeholder('—')->visibleFrom('lg'),
                TextColumn::make('shipping_cost')->label('Ongkir')->money('IDR')->alignEnd()->visibleFrom('md'),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->description(fn (Shipment $record): string => 'Rp '.number_format((int) ($record->shipping_cost ?? 0), 0, ',', '.')),
                TextColumn::make('shipped_at')->label('Tgl Kirim')->date('d M Y')->visibleFrom('lg'),
            ])
            ->actions([
                ActionGroup::make([
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
        ];
    }
}
