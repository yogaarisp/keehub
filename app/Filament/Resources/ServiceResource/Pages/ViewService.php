<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Filament\Resources\CustomerResource;
use App\Filament\Resources\ServiceResource;
use App\Models\Service;
use App\Services\ServiceService;
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

class ViewService extends ViewRecord
{
    protected static string $resource = ServiceResource::class;

    public static function statusLabel(string $state): string
    {
        return match ($state) {
            'received' => 'Masuk',
            'checking' => 'Pengecekan',
            'waiting_approval' => 'Approval',
            'processing' => 'Dikerjakan',
            'testing' => 'QC Test',
            'ready' => 'Siap Ambil',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => ucfirst(str_replace('_', ' ', $state)),
        };
    }

    public static function statusColor(string $state): string
    {
        return match ($state) {
            'received' => 'gray',
            'checking' => 'warning',
            'waiting_approval' => 'info',
            'processing', 'testing' => 'primary',
            'ready', 'completed' => 'success',
            'cancelled' => 'danger',
            default => 'gray',
        };
    }

    public function getHeading(): string
    {
        return $this->record->code;
    }

    public function getSubheading(): ?string
    {
        return ($this->record->customer?->name ?? 'Klien Umum')
            .($this->record->device_name ? ' • '.$this->record->device_name : '');
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            InfoSection::make()
                ->schema([
                    TextEntry::make('status')
                        ->label('Status Servis')
                        ->badge()
                        ->size(TextEntrySize::Large)
                        ->color(fn (string $state): string => static::statusColor($state))
                        ->formatStateUsing(fn (string $state): string => static::statusLabel($state))
                        ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 1]),

                    TextEntry::make('invoice_number')
                        ->label('No. Invoice')
                        ->placeholder('Belum terbit')
                        ->badge()
                        ->color('warning')
                        ->copyable()
                        ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 1]),

                    TextEntry::make('invoice_total_top')
                        ->label('Tagihan Klien (Invoice)')
                        ->state(fn (Service $record): string => 'Rp '.number_format($record->invoiceTotal(), 0, ',', '.'))
                        ->size(TextEntrySize::Large)
                        ->weight('bold')
                        ->color('success')
                        ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 1]),

                    TextEntry::make('due_date')
                        ->label('Target Selesai')
                        ->date('d M Y')
                        ->placeholder('Belum dijadwalkan')
                        ->icon('heroicon-m-calendar')
                        ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 1]),
                ])
                ->columns(['default' => 2, 'sm' => 2, 'lg' => 4]),

            Grid::make(['default' => 1, 'lg' => 12])
                ->schema([
                    Group::make([
                        InfoSection::make('Detail Unit PC & Diagnosa')
                            ->icon('heroicon-o-computer-desktop')
                            ->description('Spesifikasi unit, kelengkapan, keluhan pelanggan, serta hasil diagnosa teknisi')
                            ->schema([
                                TextEntry::make('device_name')
                                    ->label('Nama / Tipe PC')
                                    ->weight('semibold')
                                    ->placeholder('—')
                                    ->columnSpan(['default' => 2, 'sm' => 1]),

                                TextEntry::make('service_type')
                                    ->label('Jenis Layanan')
                                    ->formatStateUsing(fn ($state): string => Service::TYPES[$state] ?? (string) $state)
                                    ->badge()
                                    ->color('info')
                                    ->columnSpan(['default' => 1, 'sm' => 1]),

                                TextEntry::make('serial_number')
                                    ->label('Serial Number / Asset')
                                    ->placeholder('—')
                                    ->copyable()
                                    ->columnSpan(['default' => 1, 'sm' => 1]),

                                TextEntry::make('completeness')
                                    ->label('Kelengkapan Unit')
                                    ->placeholder('—')
                                    ->columnSpan(['default' => 2, 'sm' => 1]),

                                TextEntry::make('device_specs')
                                    ->label('Spesifikasi Unit')
                                    ->placeholder('—')
                                    ->columnSpanFull(),

                                TextEntry::make('problem_description')
                                    ->label('Keluhan Klien')
                                    ->placeholder('—')
                                    ->columnSpanFull(),

                                TextEntry::make('diagnosis')
                                    ->label('Diagnosa & Tindakan Teknisi')
                                    ->placeholder('Belum ada diagnosa')
                                    ->columnSpanFull(),

                                TextEntry::make('notes')
                                    ->label('Catatan Internal')
                                    ->placeholder('—')
                                    ->columnSpanFull(),
                            ])
                            ->columns(['default' => 2, 'sm' => 2]),

                        InfoSection::make('Rincian Suku Cadang & Jasa')
                            ->icon('heroicon-o-wrench-screwdriver')
                            ->description('Daftar sparepart dan jasa pengerjaan pada unit ini')
                            ->schema([
                                RepeatableEntry::make('items')
                                    ->hiddenLabel()
                                    ->schema([
                                        TextEntry::make('name')
                                            ->label('Nama Item / Jasa')
                                            ->weight('semibold')
                                            ->columnSpan(['default' => 2, 'sm' => 4, 'lg' => 3]),

                                        TextEntry::make('item_type')
                                            ->label('Tipe')
                                            ->badge()
                                            ->color(fn (string $state): string => $state === 'labor' ? 'gray' : 'primary')
                                            ->formatStateUsing(fn (string $state): string => $state === 'labor' ? 'Jasa' : 'Sparepart')
                                            ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 1]),

                                        TextEntry::make('part_source')
                                            ->label('Sumber')
                                            ->badge()
                                            ->formatStateUsing(fn ($state): string => $state === 'vendor' ? 'Vendor' : 'KeeHub')
                                            ->color(fn ($state): string => $state === 'vendor' ? 'warning' : 'info')
                                            ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 1]),

                                        TextEntry::make('warranty_info')
                                            ->label('Garansi')
                                            ->placeholder('—')
                                            ->columnSpan(['default' => 1, 'sm' => 2, 'lg' => 1]),

                                        TextEntry::make('quantity')
                                            ->label('Qty')
                                            ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 2]),

                                        TextEntry::make('price')
                                            ->label('Harga Satuan')
                                            ->money('IDR')
                                            ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 2]),

                                        TextEntry::make('total')
                                            ->label('Subtotal')
                                            ->money('IDR')
                                            ->weight('bold')
                                            ->color('primary')
                                            ->columnSpan(['default' => 1, 'sm' => 2, 'lg' => 2]),
                                    ])
                                    ->columns(['default' => 2, 'sm' => 4, 'lg' => 6])
                                    ->contained(true)
                                    ->placeholder('Belum ada suku cadang atau jasa ditambahkan.'),
                            ]),
                    ])->columnSpan(['default' => 1, 'lg' => 8]),

                    Group::make([
                        InfoSection::make('Klien & Penugasan')
                            ->icon('heroicon-o-user')
                            ->schema([
                                TextEntry::make('customer.name')
                                    ->default('—')
                                    ->label('Nama Klien')
                                    ->weight('semibold')
                                    ->color('primary')
                                    ->url(fn (Service $record): ?string => $record->customer_id
                                        ? CustomerResource::getUrl('view', ['record' => $record->customer_id])
                                        : null)
                                    ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 2]),

                                TextEntry::make('customer.whatsapp')
                                    ->label('No. WhatsApp')
                                    ->placeholder('—')
                                    ->icon('heroicon-m-phone')
                                    ->color('success')
                                    ->url(
                                        fn (Service $record): ?string => $record->customer?->whatsapp
                                            ? 'https://wa.me/'.CustomerResource::formatWaNumber($record->customer->whatsapp)
                                            : null,
                                        shouldOpenInNewTab: true
                                    )
                                    ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 2]),

                                TextEntry::make('company_name')
                                    ->label('Perusahaan / B2B')
                                    ->placeholder('—')
                                    ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 2]),

                                TextEntry::make('technician.name')
                                    ->default('Belum ditugaskan')
                                    ->label('Teknisi')
                                    ->badge()
                                    ->color('gray')
                                    ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 1]),

                                TextEntry::make('source')
                                    ->label('Sumber')
                                    ->badge()
                                    ->formatStateUsing(fn (string $state): string => match ($state) {
                                        'walk_in' => 'Walk-in',
                                        'whatsapp' => 'WhatsApp',
                                        'admin' => 'Admin B2B',
                                        'website' => 'Website',
                                        default => ucfirst($state),
                                    })
                                    ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 1]),
                            ])
                            ->columns(['default' => 2, 'sm' => 2, 'lg' => 2]),

                        InfoSection::make('Ringkasan Biaya')
                            ->icon('heroicon-o-calculator')
                            ->schema([
                                TextEntry::make('invoice_total')
                                    ->label('Grand Total Invoice Klien')
                                    ->state(fn (Service $record): string => 'Rp '.number_format($record->invoiceTotal(), 0, ',', '.'))
                                    ->size(TextEntrySize::Large)
                                    ->weight('bold')
                                    ->color('success')
                                    ->helperText('Hanya menghitung Part KeeHub + Jasa')
                                    ->columnSpanFull(),

                                TextEntry::make('work_order_total')
                                    ->label('Total Riil (Work Order)')
                                    ->state(fn (Service $record): string => 'Rp '.number_format($record->workOrderTotal(), 0, ',', '.'))
                                    ->helperText('Termasuk part Vendor & Jasa')
                                    ->columnSpan(['default' => 1, 'sm' => 1]),

                                TextEntry::make('vendor_parts_total')
                                    ->label('Part dari Vendor')
                                    ->state(fn (Service $record): string => 'Rp '.number_format($record->vendorPartsTotal(), 0, ',', '.'))
                                    ->helperText('Rp 0 pada invoice')
                                    ->columnSpan(['default' => 1, 'sm' => 1]),
                            ])
                            ->columns(['default' => 2, 'sm' => 2]),

                        InfoSection::make('Riwayat Status')
                            ->icon('heroicon-o-clock')
                            ->collapsible()
                            ->schema([
                                RepeatableEntry::make('statusHistory')
                                    ->hiddenLabel()
                                    ->schema([
                                        TextEntry::make('to_status')
                                            ->label('Status')
                                            ->badge()
                                            ->color(fn (string $state): string => static::statusColor($state))
                                            ->formatStateUsing(fn (string $state): string => static::statusLabel($state))
                                            ->columnSpan(1),

                                        TextEntry::make('created_at')
                                            ->label('Waktu')
                                            ->dateTime('d M Y H:i')
                                            ->columnSpan(1),

                                        TextEntry::make('user.name')
                                            ->label('Oleh')
                                            ->placeholder('Sistem')
                                            ->columnSpanFull(),

                                        TextEntry::make('notes')
                                            ->label('Catatan')
                                            ->placeholder('—')
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2)
                                    ->contained(true)
                                    ->placeholder('Belum ada riwayat perubahan status.'),
                            ]),
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
                        ->options(collect(ServiceService::statusFlow()[$this->getRecord()->status] ?? [])
                            ->mapWithKeys(fn (string $s): array => [$s => static::statusLabel($s)]))
                        ->required(),
                    Textarea::make('notes')
                        ->label('Catatan Perubahan Status')
                        ->rows(3),
                ])
                ->action(function (array $data): void {
                    try {
                        ServiceService::setStatus($this->getRecord(), $data['to_status'], $data['notes'] ?? null, auth()->user());
                        Notification::make()->title('Status service diubah')->success()->send();
                    } catch (\DomainException $e) {
                        Notification::make()->title('Gagal')->body($e->getMessage())->danger()->send();
                    }
                })
                ->visible(fn (): bool => ! empty(ServiceService::statusFlow()[$this->getRecord()->status])),

            Action::make('send_invoice_wa')
                ->label('Kirim WA')
                ->icon('heroicon-o-chat-bubble-left-ellipsis')
                ->color('success')
                ->url(fn (): string => ServiceResource::buildInvoiceWaUrl($this->getRecord()), shouldOpenInNewTab: true),

            ActionGroup::make([
                Action::make('thermal_receipt')
                    ->label('Cetak Struk Thermal')
                    ->icon('heroicon-o-printer')
                    ->url(fn (): string => route('admin.service.receipt', $this->getRecord()))
                    ->openUrlInNewTab(),

                Action::make('work_order_pdf')
                    ->label('Cetak Work Order (PDF)')
                    ->icon('heroicon-o-document-text')
                    ->url(fn (): string => route('admin.service.work-order.pdf', $this->getRecord()))
                    ->openUrlInNewTab(),

                Action::make('invoice_pdf')
                    ->label('Cetak Invoice (PDF)')
                    ->icon('heroicon-o-banknotes')
                    ->url(fn (): string => route('admin.service.invoice.pdf', $this->getRecord()))
                    ->openUrlInNewTab(),
            ])
                ->label('Cetak')
                ->icon('heroicon-o-printer')
                ->color('gray'),

            EditAction::make(),
        ];
    }
}
