<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\CustomerResource;
use App\Filament\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section as InfoSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\TextEntry\TextEntrySize;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    public function getHeading(): string
    {
        return $this->record->code;
    }

    public function getSubheading(): ?string
    {
        return ($this->record->customer?->name ?? 'Pelanggan Umum')
            .' • '.OrderResource::typeLabel($this->record->type);
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            InfoSection::make()
                ->compact()
                ->schema([
                    TextEntry::make('status')
                        ->label('Status Pesanan')
                        ->badge()
                        ->size(TextEntrySize::Large)
                        ->color(fn (string $state): string => OrderResource::statusColor($state))
                        ->formatStateUsing(fn (string $state): string => OrderResource::statusLabel($state)),

                    TextEntry::make('total')
                        ->label('Total Pesanan')
                        ->money('IDR')
                        ->size(TextEntrySize::Large)
                        ->weight('bold')
                        ->color('success')
                        ->extraAttributes(['class' => 'tabular-nums whitespace-nowrap']),

                    TextEntry::make('invoice.code')
                        ->label('No. Invoice')
                        ->placeholder('Belum terbit')
                        ->badge()
                        ->color('warning')
                        ->copyable(),

                    TextEntry::make('created_at')
                        ->label('Tanggal Pesanan')
                        ->dateTime('d M Y, H:i')
                        ->icon('heroicon-m-calendar'),
                ])
                ->columns(['default' => 2, 'sm' => 2, 'lg' => 4]),

            Grid::make(['default' => 1, 'lg' => 12])->schema([
                Group::make([
                    InfoSection::make('Daftar Item Pesanan')
                        ->icon('heroicon-o-shopping-bag')
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
                                ->placeholder('Belum ada item dalam pesanan ini.'),
                        ]),

                    InfoSection::make('Pelanggan & Pengiriman')
                        ->icon('heroicon-o-truck')
                        ->schema([
                            TextEntry::make('customer.name')
                                ->label('Pelanggan')
                                ->default('Pelanggan Umum')
                                ->weight('semibold')
                                ->url(fn (Order $record): ?string => $record->customer ? CustomerResource::getUrl('view', ['record' => $record->customer]) : null)
                                ->color(fn (Order $record): ?string => $record->customer ? 'primary' : null),
                            TextEntry::make('customer.whatsapp')
                                ->label('WhatsApp')
                                ->icon('heroicon-m-phone')
                                ->placeholder('—')
                                ->copyable(),
                            TextEntry::make('shipping_name')
                                ->label('Nama Penerima')
                                ->placeholder('—'),
                            TextEntry::make('shipping_phone')
                                ->label('Telp Penerima')
                                ->placeholder('—')
                                ->copyable(),
                            TextEntry::make('shipping_address')
                                ->label('Alamat Pengiriman')
                                ->placeholder('Pickup di toko / tidak ada alamat')
                                ->columnSpanFull(),
                        ])
                        ->columns(['default' => 1, 'sm' => 2]),

                    InfoSection::make('Riwayat Status')
                        ->icon('heroicon-o-clock')
                        ->schema([
                            RepeatableEntry::make('statusHistory')
                                ->hiddenLabel()
                                ->schema([
                                    TextEntry::make('to_status')
                                        ->label('Status')
                                        ->badge()
                                        ->color(fn (string $state): string => OrderResource::statusColor($state))
                                        ->formatStateUsing(fn (string $state): string => OrderResource::statusLabel($state)),
                                    TextEntry::make('created_at')
                                        ->label('Waktu')
                                        ->dateTime('d M Y, H:i'),
                                    TextEntry::make('user.name')
                                        ->label('Oleh')
                                        ->placeholder('System'),
                                    TextEntry::make('notes')
                                        ->label('Catatan')
                                        ->placeholder('—'),
                                ])
                                ->columns(['default' => 2, 'sm' => 2, 'lg' => 4])
                                ->contained(true)
                                ->placeholder('Belum ada riwayat perubahan status.'),
                        ])
                        ->collapsible(),
                ])->columnSpan(['default' => 1, 'lg' => 8]),

                Group::make([
                    InfoSection::make('Ringkasan Pembayaran')
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
                            TextEntry::make('shipping_cost')
                                ->label('Biaya Kirim')
                                ->money('IDR')
                                ->inlineLabel()
                                ->extraAttributes(['class' => 'tabular-nums justify-end']),
                            TextEntry::make('total')
                                ->label('Total Tagihan')
                                ->money('IDR')
                                ->inlineLabel()
                                ->weight('bold')
                                ->size(TextEntrySize::Large)
                                ->color('success')
                                ->extraAttributes(['class' => 'tabular-nums justify-end']),
                        ])
                        ->columns(1),

                    InfoSection::make('Info Tambahan')
                        ->icon('heroicon-o-information-circle')
                        ->schema([
                            TextEntry::make('type')
                                ->label('Tipe Order')
                                ->badge()
                                ->formatStateUsing(fn (?string $state): string => OrderResource::typeLabel($state)),
                            TextEntry::make('channel')
                                ->label('Saluran')
                                ->badge()
                                ->color('gray')
                                ->formatStateUsing(fn (?string $state): string => match ($state) {
                                    'admin' => 'Admin POS',
                                    'website' => 'Website',
                                    'whatsapp' => 'WhatsApp',
                                    'offline' => 'Toko Fisik',
                                    default => ucfirst((string) $state),
                                }),
                            TextEntry::make('notes')
                                ->label('Catatan')
                                ->placeholder('Tidak ada catatan.')
                                ->columnSpanFull(),
                        ])
                        ->columns(['default' => 2, 'lg' => 2]),
                ])->columnSpan(['default' => 1, 'lg' => 4]),
            ]),
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('advance_status')
                ->label('Ubah Status')
                ->icon('heroicon-m-arrow-path')
                ->color('primary')
                ->form([
                    Select::make('to_status')
                        ->label('Status Baru')
                        ->options(collect(OrderService::statusFlow()[$this->getRecord()->status] ?? [])
                            ->mapWithKeys(fn (string $s): array => [$s => OrderResource::statusLabel($s)]))
                        ->required(),
                    Textarea::make('notes')->label('Catatan'),
                ])
                ->action(function (array $data): void {
                    try {
                        OrderService::setStatus($this->getRecord(), $data['to_status'], $data['notes'] ?? null, auth()->user());
                        Notification::make()->title('Status order diubah ke '.OrderResource::statusLabel($data['to_status']))->success()->send();
                    } catch (\DomainException $e) {
                        Notification::make()->title('Gagal')->body($e->getMessage())->danger()->send();
                    }
                })
                ->visible(fn (): bool => ! empty(OrderService::statusFlow()[$this->getRecord()->status])),

            EditAction::make()
                ->color('gray'),

            ActionGroup::make([
                Action::make('thermal_receipt')
                    ->label('Cetak Struk Thermal')
                    ->icon('heroicon-m-printer')
                    ->color('success')
                    ->url(fn () => route('admin.order.receipt', $this->getRecord()))
                    ->openUrlInNewTab(),

                Action::make('invoice_pdf')
                    ->label('Download Invoice PDF')
                    ->icon('heroicon-m-document-arrow-down')
                    ->color('gray')
                    ->visible(fn () => $this->getRecord()->invoice !== null)
                    ->url(fn () => route('admin.invoice.pdf', ['invoice' => $this->getRecord()->invoice]))
                    ->openUrlInNewTab(),
            ])
                ->label('Cetak')
                ->icon('heroicon-m-printer')
                ->color('success')
                ->button(),
        ];
    }
}
