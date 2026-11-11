<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Models\Invoice;
use App\Models\Payment;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Sales';

    protected static ?string $navigationLabel = 'Pembayaran';

    protected static ?string $modelLabel = 'Pembayaran';

    protected static ?string $pluralModelLabel = 'Pembayaran';

    protected static ?int $navigationSort = 3;

    public static function canCreate(): bool
    {
        return true;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Catat Pembayaran')
                ->icon('heroicon-o-banknotes')
                ->schema([
                    Select::make('invoice_id')
                        ->label('Invoice')
                        ->relationship('invoice', 'code')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->getOptionLabelFromRecordUsing(fn (Invoice $record) => "{$record->code} — sisa Rp".number_format($record->remainingAmount(), 0, ',', '.'))
                        ->columnSpanFull(),
                    Select::make('method')
                        ->label('Metode Pembayaran')
                        ->options(array_combine(Payment::METHODS, array_map(ucfirst(...), Payment::METHODS)))
                        ->default('transfer')
                        ->required(),
                    TextInput::make('amount')
                        ->label('Nominal Bayar')
                        ->numeric()
                        ->prefix('Rp')
                        ->required()
                        ->minValue(1),
                    DatePicker::make('paid_at')
                        ->label('Tanggal Bayar')
                        ->default(today())
                        ->required(),
                    TextInput::make('reference')
                        ->label('Referensi (No. Transfer/Bukti)'),
                    TextInput::make('notes')
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
                TextColumn::make('code')
                    ->label('No. Pembayaran')
                    ->searchable()
                    ->weight('bold')
                    ->description(fn (Payment $record): string => ($record->invoice?->code ?? '—').' • Rp '.number_format((int) $record->amount, 0, ',', '.')),
                TextColumn::make('invoice.code')->label('Invoice')->visibleFrom('md'),
                TextColumn::make('method')->label('Metode')->badge(),
                TextColumn::make('amount')->label('Nominal')->money('IDR')->sortable()->alignEnd()->visibleFrom('md'),
                TextColumn::make('paid_at')->label('Tanggal')->date('d M Y')->sortable()->visibleFrom('lg'),
                TextColumn::make('user.name')->label('Dicatat oleh')->visibleFrom('xl'),
            ])
            ->actions([
                ActionGroup::make([
                    DeleteAction::make()
                        ->requiresConfirmation()
                        ->visible(fn ($record) => $record->invoice?->status !== 'void'),
                ]),
            ])
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
