<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShipmentResource\Pages;
use App\Models\Shipment;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ShipmentResource extends Resource
{
    protected static ?string $model = Shipment::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationGroup = 'Sales';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('order_id')->relationship('order', 'code')->searchable()->preload()->required(),
            Checkbox::make('is_pickup')->label('Pickup at Store (tanpa resi)')->live(),
            Select::make('courier')->options(array_combine(Shipment::COURIERS, Shipment::COURIERS))
                ->hidden(fn ($get) => $get('is_pickup')),
            TextInput::make('tracking_number')->label('No. Resi')->hidden(fn ($get) => $get('is_pickup')),
            TextInput::make('shipping_cost')->numeric()->prefix('Rp'),
            DatePicker::make('shipped_at'),
            Select::make('status')->options(array_combine(Shipment::STATUSES, array_map(fn ($s) => str_replace('_', ' ', ucfirst($s)), Shipment::STATUSES)))->default('preparing'),
            Textarea::make('notes')->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order.code')->searchable(),
                TextColumn::make('courier')->placeholder('Pickup'),
                TextColumn::make('tracking_number')->label('Resi')->searchable()->copyable()->placeholder('—'),
                TextColumn::make('shipping_cost')->money('IDR'),
                TextColumn::make('status')->badge(),
                TextColumn::make('shipped_at')->date('d M Y'),
            ])
            ->actions([EditAction::make(), DeleteAction::make()])
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
