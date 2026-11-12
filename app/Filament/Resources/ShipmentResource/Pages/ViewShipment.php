<?php

namespace App\Filament\Resources\ShipmentResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Filament\Resources\ShipmentResource;
use App\Models\Shipment;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\Section as InfoSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\TextEntry\TextEntrySize;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewShipment extends ViewRecord
{
    protected static string $resource = ShipmentResource::class;

    public function getHeading(): string
    {
        return $this->record->order?->code ?? 'Pengiriman #'.$this->record->id;
    }

    public function getSubheading(): ?string
    {
        return ($this->record->is_pickup ? 'Pickup di Toko' : ($this->record->courier ?: 'Kurir'))
            .($this->record->tracking_number ? ' • '.$this->record->tracking_number : '');
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            InfoSection::make()
                ->compact()
                ->schema([
                    TextEntry::make('status')
                        ->label('Status Pengiriman')
                        ->badge()
                        ->size(TextEntrySize::Large)
                        ->color(fn (string $state): string => ShipmentResource::statusColor($state))
                        ->formatStateUsing(fn (string $state): string => ShipmentResource::statusLabel($state)),

                    TextEntry::make('shipping_cost')
                        ->label('Biaya Ongkir')
                        ->money('IDR')
                        ->size(TextEntrySize::Large)
                        ->weight('bold')
                        ->color('success')
                        ->extraAttributes(['class' => 'tabular-nums whitespace-nowrap']),

                    TextEntry::make('courier')
                        ->label('Kurir / Ekspedisi')
                        ->placeholder('Pickup di Toko')
                        ->badge()
                        ->color('info'),

                    TextEntry::make('shipped_at')
                        ->label('Tanggal Kirim')
                        ->date('d M Y')
                        ->placeholder('Belum dikirim')
                        ->icon('heroicon-m-calendar'),
                ])
                ->columns(['default' => 2, 'sm' => 2, 'lg' => 4]),

            Grid::make(['default' => 1, 'lg' => 12])->schema([
                Group::make([
                    InfoSection::make('Informasi Pengiriman & Penerima')
                        ->icon('heroicon-o-truck')
                        ->schema([
                            TextEntry::make('order.code')
                                ->label('No. Pesanan')
                                ->badge()
                                ->color('primary')
                                ->url(fn (Shipment $record): ?string => $record->order ? OrderResource::getUrl('view', ['record' => $record->order]) : null),
                            TextEntry::make('tracking_number')
                                ->label('No. Resi')
                                ->placeholder('—')
                                ->copyable(),
                            TextEntry::make('order.shipping_name')
                                ->label('Nama Penerima')
                                ->placeholder('—'),
                            TextEntry::make('order.shipping_phone')
                                ->label('Telp Penerima')
                                ->icon('heroicon-m-phone')
                                ->placeholder('—')
                                ->copyable(),
                            TextEntry::make('order.shipping_address')
                                ->label('Alamat Pengiriman')
                                ->placeholder('Pickup di toko / tidak ada alamat')
                                ->columnSpanFull(),
                            TextEntry::make('notes')
                                ->label('Catatan Pengiriman')
                                ->placeholder('Tidak ada catatan.')
                                ->columnSpanFull(),
                        ])
                        ->columns(['default' => 1, 'sm' => 2]),
                ])->columnSpan(['default' => 1, 'lg' => 8]),

                Group::make([
                    InfoSection::make('Ringkasan Pengiriman')
                        ->icon('heroicon-o-clipboard-document-check')
                        ->schema([
                            TextEntry::make('is_pickup')
                                ->label('Pickup di Toko')
                                ->badge()
                                ->formatStateUsing(fn (bool $state): string => $state ? 'Ya' : 'Tidak')
                                ->color(fn (bool $state): string => $state ? 'info' : 'gray')
                                ->inlineLabel(),
                            TextEntry::make('courier')
                                ->label('Kurir')
                                ->placeholder('Pickup')
                                ->inlineLabel(),
                            TextEntry::make('shipping_cost')
                                ->label('Biaya Ongkir')
                                ->money('IDR')
                                ->inlineLabel()
                                ->weight('bold')
                                ->color('success')
                                ->extraAttributes(['class' => 'tabular-nums justify-end']),
                            TextEntry::make('created_at')
                                ->label('Dibuat Pada')
                                ->dateTime('d M Y, H:i')
                                ->inlineLabel(),
                        ])
                        ->columns(1),
                ])->columnSpan(['default' => 1, 'lg' => 4]),
            ]),
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}

