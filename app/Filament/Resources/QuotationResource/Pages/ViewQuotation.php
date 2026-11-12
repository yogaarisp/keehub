<?php

namespace App\Filament\Resources\QuotationResource\Pages;

use App\Filament\Resources\CustomerResource;
use App\Filament\Resources\OrderResource;
use App\Filament\Resources\QuotationResource;
use App\Models\Quotation;
use App\Services\QuotationService;
use Filament\Actions\Action;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section as InfoSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\TextEntry\TextEntrySize;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewQuotation extends ViewRecord
{
    protected static string $resource = QuotationResource::class;

    public function getHeading(): string
    {
        return $this->record->code;
    }

    public function getSubheading(): ?string
    {
        return ($this->record->customer?->name ?? 'Pelanggan Umum')
            .' • Penawaran Harga';
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            InfoSection::make()
                ->compact()
                ->schema([
                    TextEntry::make('status')
                        ->label('Status Penawaran')
                        ->badge()
                        ->size(TextEntrySize::Large)
                        ->color(fn (string $state): string => QuotationResource::statusColor($state))
                        ->formatStateUsing(fn (string $state): string => QuotationResource::statusLabel($state)),

                    TextEntry::make('total')
                        ->label('Total Penawaran')
                        ->money('IDR')
                        ->size(TextEntrySize::Large)
                        ->weight('bold')
                        ->color('success')
                        ->extraAttributes(['class' => 'tabular-nums whitespace-nowrap']),

                    TextEntry::make('quotation_date')
                        ->label('Tanggal Penawaran')
                        ->date('d M Y')
                        ->icon('heroicon-m-calendar'),

                    TextEntry::make('expired_date')
                        ->label('Berlaku Hingga')
                        ->date('d M Y')
                        ->placeholder('—')
                        ->icon('heroicon-m-clock'),
                ])
                ->columns(['default' => 2, 'sm' => 2, 'lg' => 4]),

            Grid::make(['default' => 1, 'lg' => 12])->schema([
                Group::make([
                    InfoSection::make('Daftar Item Penawaran')
                        ->icon('heroicon-o-document-text')
                        ->schema([
                            RepeatableEntry::make('items')
                                ->hiddenLabel()
                                ->schema([
                                    TextEntry::make('name')
                                        ->label('Nama Item')
                                        ->weight('semibold')
                                        ->columnSpan(['default' => 2, 'sm' => 4, 'lg' => 5]),
                                    TextEntry::make('item_type')
                                        ->label('Kategori')
                                        ->badge()
                                        ->formatStateUsing(fn (string $state): string => match ($state) {
                                            'product' => 'Produk Toko',
                                            'build' => 'PC Build',
                                            'service' => 'Servis',
                                            'labor' => 'Jasa / Pasang',
                                            'customer_owned' => 'Milik Customer',
                                            default => ucfirst(str_replace('_', ' ', $state)),
                                        })
                                        ->color(fn (string $state): string => match ($state) {
                                            'customer_owned' => 'gray',
                                            'build' => 'info',
                                            'service', 'labor' => 'warning',
                                            default => 'primary',
                                        })
                                        ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 2]),
                                    TextEntry::make('price')
                                        ->label('Harga')
                                        ->money('IDR')
                                        ->extraAttributes(['class' => 'tabular-nums'])
                                        ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 2]),
                                    TextEntry::make('quantity')
                                        ->label('Qty')
                                        ->suffix('x')
                                        ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 1]),
                                    TextEntry::make('total')
                                        ->label('Subtotal')
                                        ->money('IDR')
                                        ->weight('bold')
                                        ->color('primary')
                                        ->extraAttributes(['class' => 'tabular-nums'])
                                        ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 2]),
                                ])
                                ->columns(['default' => 2, 'sm' => 4, 'lg' => 12])
                                ->contained(true)
                                ->placeholder('Belum ada item dalam penawaran ini.'),
                        ]),

                    InfoSection::make('Catatan & Syarat Ketentuan')
                        ->icon('heroicon-o-clipboard-document-list')
                        ->schema([
                            TextEntry::make('notes')
                                ->label('Catatan Penawaran')
                                ->placeholder('Tidak ada catatan.')
                                ->columnSpanFull(),
                            TextEntry::make('terms')
                                ->label('Syarat & Ketentuan')
                                ->placeholder('—')
                                ->columnSpanFull(),
                        ])
                        ->collapsible(),
                ])->columnSpan(['default' => 1, 'lg' => 8]),

                Group::make([
                    InfoSection::make('Rincian Harga')
                        ->icon('heroicon-o-banknotes')
                        ->schema([
                            TextEntry::make('subtotal')
                                ->label('Subtotal Item')
                                ->money('IDR')
                                ->inlineLabel()
                                ->extraAttributes(['class' => 'tabular-nums justify-end']),
                            TextEntry::make('discount')
                                ->label('Potongan Diskon')
                                ->money('IDR')
                                ->inlineLabel()
                                ->color(fn ($state): ?string => (int) $state > 0 ? 'danger' : null)
                                ->extraAttributes(['class' => 'tabular-nums justify-end']),
                            TextEntry::make('shipping')
                                ->label('Biaya Pengiriman')
                                ->money('IDR')
                                ->inlineLabel()
                                ->extraAttributes(['class' => 'tabular-nums justify-end']),
                            TextEntry::make('total')
                                ->label('Total Akhir')
                                ->money('IDR')
                                ->inlineLabel()
                                ->weight('bold')
                                ->size(TextEntrySize::Large)
                                ->color('success')
                                ->extraAttributes(['class' => 'tabular-nums justify-end']),
                        ])
                        ->columns(1),

                    InfoSection::make('Informasi Pelanggan')
                        ->icon('heroicon-o-user')
                        ->schema([
                            TextEntry::make('customer.name')
                                ->label('Nama Pelanggan')
                                ->default('Pelanggan Umum')
                                ->weight('semibold')
                                ->url(fn (Quotation $record): ?string => $record->customer ? CustomerResource::getUrl('view', ['record' => $record->customer]) : null)
                                ->color(fn (Quotation $record): ?string => $record->customer ? 'primary' : null),
                            TextEntry::make('customer.whatsapp')
                                ->label('WhatsApp')
                                ->icon('heroicon-m-phone')
                                ->placeholder('—')
                                ->copyable(),
                            TextEntry::make('order.code')
                                ->label('Order Terhubung')
                                ->placeholder('Belum dikonversi')
                                ->badge()
                                ->color('primary')
                                ->url(fn (Quotation $record): ?string => $record->order ? OrderResource::getUrl('view', ['record' => $record->order]) : null),
                        ])
                        ->columns(['default' => 1, 'sm' => 2, 'lg' => 1]),
                ])->columnSpan(['default' => 1, 'lg' => 4]),
            ]),
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('mark_sent')
                ->label('Kirim (Sent)')
                ->icon('heroicon-m-paper-airplane')
                ->visible(fn () => $this->getRecord()->status === 'draft')
                ->action(function () {
                    try {
                        QuotationService::markSent($this->getRecord());
                        Notification::make()->title('Quotation dikirim')->success()->send();
                    } catch (\DomainException $e) {
                        Notification::make()->title('Gagal')->body($e->getMessage())->danger()->send();
                    }
                }),

            Action::make('mark_accepted')
                ->label('Disetujui (Accepted)')
                ->icon('heroicon-m-check')
                ->color('success')
                ->visible(fn () => $this->getRecord()->status === 'sent')
                ->requiresConfirmation()
                ->action(fn () => $this->getRecord()->update(['status' => 'accepted'])),

            Action::make('convert')
                ->label('Konversi ke Order')
                ->icon('heroicon-m-arrow-right-circle')
                ->color('primary')
                ->visible(fn () => $this->getRecord()->status === 'accepted' && ! $this->getRecord()->order_id)
                ->requiresConfirmation()
                ->action(function () {
                    try {
                        $order = QuotationService::convertToOrder($this->getRecord());
                        Notification::make()->title("Order {$order->code} dibuat dari quotation")->success()->send();
                        $this->redirect(OrderResource::getUrl('view', ['record' => $order]));
                    } catch (\DomainException $e) {
                        Notification::make()->title('Gagal konversi')->body($e->getMessage())->danger()->send();
                    }
                }),
        ];
    }
}
