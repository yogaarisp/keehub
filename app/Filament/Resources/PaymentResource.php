<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Models\Invoice;
use App\Models\Payment;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Sales';

    protected static ?int $navigationSort = 4;

    public static function canCreate(): bool
    {
        return true;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('invoice_id')->label('Invoice')->relationship('invoice', 'code')
                ->searchable()->preload()->required()
                ->getOptionLabelFromRecordUsing(fn (Invoice $record) => "{$record->code} — sisa Rp".number_format($record->remainingAmount(), 0, ',', '.')),
            Select::make('method')->options(array_combine(Payment::METHODS, array_map(ucfirst(...), Payment::METHODS)))->default('transfer')->required(),
            TextInput::make('amount')->numeric()->prefix('Rp')->required()->minValue(1),
            DatePicker::make('paid_at')->default(today())->required(),
            TextInput::make('reference')->label('Referensi (no. transfer/dsb)'),
            TextInput::make('notes'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')->searchable(),
                TextColumn::make('invoice.code')->label('Invoice'),
                TextColumn::make('method')->badge(),
                TextColumn::make('amount')->money('IDR')->sortable(),
                TextColumn::make('paid_at')->date('d M Y')->sortable(),
                TextColumn::make('user.name')->label('Dicatat oleh'),
            ])
            ->actions([DeleteAction::make()
                ->requiresConfirmation()
                ->visible(fn ($record) => $record->invoice->status !== 'void')])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
        ];
    }
}
