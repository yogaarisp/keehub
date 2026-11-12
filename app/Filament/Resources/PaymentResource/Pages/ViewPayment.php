<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Filament\Resources\PaymentResource;
use App\Models\Payment;
use Filament\Actions\DeleteAction;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\Section as InfoSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\TextEntry\TextEntrySize;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewPayment extends ViewRecord
{
    protected static string $resource = PaymentResource::class;

    public function getHeading(): string
    {
        return $this->record->code;
    }

    public function getSubheading(): ?string
    {
        return ($this->record->invoice?->code ?? 'Tanpa Invoice')
            .' • '.PaymentResource::methodLabel((string) $this->record->method);
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            InfoSection::make()
                ->compact()
                ->schema([
                    TextEntry::make('method')
                        ->label('Metode Pembayaran')
                        ->badge()
                        ->size(TextEntrySize::Large)
                        ->color(fn (string $state): string => PaymentResource::methodColor($state))
                        ->formatStateUsing(fn (string $state): string => PaymentResource::methodLabel($state)),

                    TextEntry::make('amount')
                        ->label('Nominal Bayar')
                        ->money('IDR')
                        ->size(TextEntrySize::Large)
                        ->weight('bold')
                        ->color('success')
                        ->extraAttributes(['class' => 'tabular-nums whitespace-nowrap']),

                    TextEntry::make('invoice.code')
                        ->label('No. Invoice')
                        ->placeholder('—')
                        ->badge()
                        ->color('warning')
                        ->copyable(),

                    TextEntry::make('paid_at')
                        ->label('Tanggal Bayar')
                        ->date('d M Y')
                        ->icon('heroicon-m-calendar'),
                ])
                ->columns(['default' => 2, 'sm' => 2, 'lg' => 4]),

            Grid::make(['default' => 1, 'lg' => 12])->schema([
                Group::make([
                    InfoSection::make('Detail Pembayaran')
                        ->icon('heroicon-o-banknotes')
                        ->schema([
                            TextEntry::make('code')
                                ->label('No. Pembayaran')
                                ->weight('semibold')
                                ->copyable(),
                            TextEntry::make('reference')
                                ->label('Referensi / Bukti')
                                ->placeholder('—')
                                ->copyable(),
                            TextEntry::make('user.name')
                                ->label('Dicatat Oleh')
                                ->placeholder('System'),
                            TextEntry::make('created_at')
                                ->label('Waktu Input')
                                ->dateTime('d M Y, H:i'),
                            TextEntry::make('notes')
                                ->label('Catatan')
                                ->placeholder('Tidak ada catatan.')
                                ->columnSpanFull(),
                        ])
                        ->columns(['default' => 1, 'sm' => 2]),
                ])->columnSpan(['default' => 1, 'lg' => 8]),

                Group::make([
                    InfoSection::make('Ringkasan Invoice')
                        ->icon('heroicon-o-document-text')
                        ->schema([
                            TextEntry::make('invoice.order.code')
                                ->label('No. Pesanan')
                                ->placeholder('—')
                                ->badge()
                                ->color('primary')
                                ->inlineLabel()
                                ->url(fn (Payment $record): ?string => $record->invoice?->order ? OrderResource::getUrl('view', ['record' => $record->invoice->order]) : null),
                            TextEntry::make('invoice.total')
                                ->label('Total Tagihan')
                                ->money('IDR')
                                ->inlineLabel()
                                ->extraAttributes(['class' => 'tabular-nums justify-end']),
                            TextEntry::make('invoice.paid_amount')
                                ->label('Total Terbayar')
                                ->money('IDR')
                                ->inlineLabel()
                                ->weight('bold')
                                ->color('success')
                                ->extraAttributes(['class' => 'tabular-nums justify-end']),
                        ])
                        ->columns(1),
                ])->columnSpan(['default' => 1, 'lg' => 4]),
            ]),
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->requiresConfirmation()
                ->visible(fn (): bool => $this->getRecord()->invoice?->status !== 'void'),
        ];
    }
}

