<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Models\Invoice;
use App\Models\Payment;
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
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Sales';

    protected static ?string $navigationLabel = 'Pembayaran';

    protected static ?string $modelLabel = 'Pembayaran';

    protected static ?string $pluralModelLabel = 'Pembayaran';

    protected static ?int $navigationSort = 3;

    public static function methodLabel(string $state): string
    {
        return match ($state) {
            'cash' => 'Tunai',
            'transfer' => 'Transfer Bank',
            'qris' => 'QRIS',
            'ewallet' => 'E-Wallet',
            'debit' => 'Kartu Debit',
            'credit' => 'Kartu Kredit',
            'other' => 'Lainnya',
            default => ucfirst($state),
        };
    }

    public static function methodColor(string $state): string
    {
        return match ($state) {
            'cash' => 'success',
            'transfer' => 'info',
            'qris' => 'primary',
            'ewallet' => 'warning',
            default => 'gray',
        };
    }

    public static function canCreate(): bool
    {
        return true;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(['default' => 1, 'lg' => 12])->schema([
                Group::make([
                    Section::make('Informasi Pembayaran & Bukti')
                        ->icon('heroicon-o-banknotes')
                        ->description('Pilih invoice yang ditagihkan dan masukkan metode serta bukti bayar')
                        ->schema([
                            Select::make('invoice_id')
                                ->label('Pilih Invoice')
                                ->relationship('invoice', 'code')
                                ->searchable()
                                ->preload()
                                ->required()
                                ->live()
                                ->getOptionLabelFromRecordUsing(fn (Invoice $record): string => "{$record->code} — ".($record->order?->customer?->name ?? 'Pelanggan Umum').' (Sisa: Rp '.number_format($record->remainingAmount(), 0, ',', '.').')')
                                ->afterStateUpdated(function (Get $get, Set $set, ?string $state): void {
                                    if ($state && ($inv = Invoice::find($state))) {
                                        $set('amount', $inv->remainingAmount());
                                    }
                                })
                                ->columnSpanFull(),

                            Select::make('method')
                                ->label('Metode Pembayaran')
                                ->options(collect(Payment::METHODS)->mapWithKeys(fn (string $m): array => [$m => static::methodLabel($m)]))
                                ->default('transfer')
                                ->required()
                                ->columnSpan(['default' => 1, 'sm' => 1]),

                            TextInput::make('reference')
                                ->label('No. Referensi / Bukti Transfer')
                                ->placeholder('Contoh: TRF-BCA-981023 / ID Transaksi')
                                ->columnSpan(['default' => 1, 'sm' => 1]),

                            Textarea::make('notes')
                                ->label('Catatan Pembayaran (Opsional)')
                                ->placeholder('Keterangan pembayaran, nama pemilik rekening pengirim, dll...')
                                ->rows(3)
                                ->columnSpanFull(),
                        ])
                        ->columns(['default' => 1, 'sm' => 2]),
                ])->columnSpan(['default' => 1, 'lg' => 8]),

                Group::make([
                    Section::make('Nominal & Waktu Bayar')
                        ->icon('heroicon-o-calculator')
                        ->schema([
                            DatePicker::make('paid_at')
                                ->label('Tanggal Bayar')
                                ->default(today())
                                ->required()
                                ->columnSpanFull(),

                            TextInput::make('amount')
                                ->label('Nominal yang Dibayar')
                                ->numeric()
                                ->prefix('Rp')
                                ->required()
                                ->minValue(1)
                                ->live(debounce: 350)
                                ->columnSpanFull(),

                            Placeholder::make('invoice_summary')
                                ->label('Ringkasan Invoice')
                                ->content(function (Get $get): HtmlString {
                                    $invoiceId = $get('invoice_id');
                                    if (! $invoiceId || ! ($invoice = Invoice::find($invoiceId))) {
                                        return new HtmlString(
                                            '<div style="font-size:0.8rem;color:#64748b;font-style:italic;">'
                                            .'Pilih invoice di samping untuk melihat rincian sisa tagihan.'
                                            .'</div>'
                                        );
                                    }

                                    $total = $invoice->total;
                                    $paid = $invoice->paid_amount;
                                    $remaining = $invoice->remainingAmount();
                                    $orderCode = $invoice->order?->code ?? '-';
                                    $custName = $invoice->order?->customer?->name ?? 'Pelanggan Umum';

                                    return new HtmlString(
                                        '<div style="display:flex;flex-direction:column;gap:0.35rem;font-size:0.8rem;">'
                                        .'<div style="color:#64748b;">No. Pesanan: <strong style="color:#0f172a;">'.$orderCode.'</strong></div>'
                                        .'<div style="color:#64748b;">Pelanggan: <strong style="color:#0f172a;">'.$custName.'</strong></div>'
                                        .'<div style="border-top:1px dashed #cbd5e1;margin-top:0.25rem;padding-top:0.25rem;"></div>'
                                        .'<div style="display:flex;justify-content:space-between;color:#64748b;"><span>Total Tagihan:</span><span style="font-weight:600;">Rp '.number_format($total, 0, ',', '.').'</span></div>'
                                        .'<div style="display:flex;justify-content:space-between;color:#059669;"><span>Sudah Dibayar:</span><span style="font-weight:600;">Rp '.number_format($paid, 0, ',', '.').'</span></div>'
                                        .'<div style="display:flex;justify-content:space-between;color:#d97706;font-size:0.95rem;font-weight:700;margin-top:0.25rem;"><span>Sisa Tagihan:</span><span>Rp '.number_format($remaining, 0, ',', '.').'</span></div>'
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
                TextColumn::make('code')
                    ->label('No. Pembayaran')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold')
                    ->description(fn (Payment $record): string => ($record->invoice?->code ?? '—').($record->paid_at ? ' • '.$record->paid_at->format('d M Y') : '')),
                TextColumn::make('invoice.code')
                    ->label('Invoice')
                    ->badge()
                    ->color('warning')
                    ->copyable()
                    ->searchable()
                    ->visibleFrom('md'),
                TextColumn::make('method')
                    ->label('Metode')
                    ->badge()
                    ->color(fn (string $state): string => static::methodColor($state))
                    ->formatStateUsing(fn (string $state): string => static::methodLabel($state))
                    ->description(fn (Payment $record): string => 'Rp '.number_format((int) $record->amount, 0, ',', '.')),
                TextColumn::make('amount')
                    ->label('Nominal')
                    ->money('IDR')
                    ->sortable()
                    ->weight('bold')
                    ->alignEnd()
                    ->visibleFrom('md'),
                TextColumn::make('paid_at')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable()
                    ->visibleFrom('lg'),
                TextColumn::make('user.name')
                    ->label('Dicatat oleh')
                    ->placeholder('System')
                    ->visibleFrom('xl'),
            ])
            ->filters([
                SelectFilter::make('method')
                    ->label('Metode Pembayaran')
                    ->options(collect(Payment::METHODS)->mapWithKeys(fn (string $m): array => [$m => static::methodLabel($m)])),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
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
            'view' => Pages\ViewPayment::route('/{record}'),
        ];
    }
}
