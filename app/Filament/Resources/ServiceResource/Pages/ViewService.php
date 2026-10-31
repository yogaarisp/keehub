<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Filament\Resources\ServiceResource;
use App\Models\Service;
use App\Services\ServiceService;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section as InfoSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewService extends ViewRecord
{
    protected static string $resource = ServiceResource::class;

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
            InfoSection::make('Informasi Layanan & Klien B2B')
                ->description('Data klien, penanggung jawab teknisi, dan status pengerjaan')
                ->schema([
                    TextEntry::make('code')
                        ->label('No. Servis')
                        ->badge()
                        ->color('primary')
                        ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 1]),

                    TextEntry::make('status')
                        ->label('Status Servis')
                        ->badge()
                        ->color(fn (string $state) => match ($state) {
                            'received' => 'gray',
                            'checking' => 'warning',
                            'waiting_approval' => 'info',
                            'processing', 'testing' => 'primary',
                            'ready', 'completed' => 'success',
                            'cancelled' => 'danger',
                            default => 'gray',
                        })
                        ->formatStateUsing(fn (string $state) => match ($state) {
                            'received' => 'Masuk',
                            'checking' => 'Pengecekan',
                            'waiting_approval' => 'Approval',
                            'processing' => 'Dikerjakan',
                            'testing' => 'QC Test',
                            'ready' => 'Siap Ambil',
                            'completed' => 'Selesai',
                            'cancelled' => 'Dibatalkan',
                            default => ucfirst(str_replace('_', ' ', $state)),
                        })
                        ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 1]),

                    TextEntry::make('invoice_number')
                        ->label('No. Invoice')
                        ->placeholder('—')
                        ->badge()
                        ->color('warning')
                        ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 1]),

                    TextEntry::make('source')
                        ->label('Sumber Masuk')
                        ->badge()
                        ->formatStateUsing(fn (string $state) => match ($state) {
                            'walk_in' => 'Walk-in',
                            'whatsapp' => 'WhatsApp',
                            'admin' => 'Admin B2B',
                            'website' => 'Website',
                            default => ucfirst($state),
                        })
                        ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 1]),

                    TextEntry::make('customer.name')
                        ->default('—')
                        ->label('Nama Klien')
                        ->weight('bold')
                        ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 1]),

                    TextEntry::make('customer.whatsapp')
                        ->label('No. WhatsApp')
                        ->placeholder('—')
                        ->copyable()
                        ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 1]),

                    TextEntry::make('company_name')
                        ->label('Perusahaan / B2B')
                        ->placeholder('—')
                        ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 1]),

                    TextEntry::make('technician.name')
                        ->default('—')
                        ->label('Teknisi')
                        ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 1]),

                    TextEntry::make('due_date')
                        ->label('Target Selesai')
                        ->date('d M Y')
                        ->placeholder('—')
                        ->columnSpan(['default' => 2, 'sm' => 2, 'lg' => 1]),
                ])->columns(['default' => 2, 'sm' => 2, 'lg' => 3]),

            InfoSection::make('Detail Unit PC / Perangkat')
                ->description('Spesifikasi teknis, nomor seri, dan keluhan dari pelanggan')
                ->schema([
                    TextEntry::make('device_name')
                        ->label('Nama / Tipe PC')
                        ->weight('bold')
                        ->placeholder('—')
                        ->columnSpan(['default' => 2, 'sm' => 1, 'lg' => 1]),

                    TextEntry::make('serial_number')
                        ->label('Serial Number / Asset')
                        ->placeholder('—')
                        ->copyable()
                        ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 1]),

                    TextEntry::make('service_type')
                        ->label('Layanan')
                        ->formatStateUsing(fn ($state) => Service::TYPES[$state] ?? $state)
                        ->badge()
                        ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 1]),

                    TextEntry::make('completeness')
                        ->label('Kelengkapan Unit')
                        ->placeholder('—')
                        ->columnSpan(['default' => 2, 'sm' => 1, 'lg' => 1]),

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
                        ->placeholder('—')
                        ->columnSpanFull(),
                ])->columns(['default' => 2, 'sm' => 2, 'lg' => 3]),

            InfoSection::make('Rincian Suku Cadang & Jasa')
                ->description('Daftar sparepart dan jasa teknisi pada unit ini')
                ->schema([
                    RepeatableEntry::make('items')->schema([
                        TextEntry::make('name')
                            ->label('Nama Item / Jasa')
                            ->weight('bold')
                            ->columnSpan(['default' => 2, 'sm' => 2, 'lg' => 2]),

                        TextEntry::make('item_type')
                            ->label('Tipe')
                            ->badge()
                            ->color(fn (string $state) => $state === 'labor' ? 'gray' : 'primary')
                            ->formatStateUsing(fn (string $state) => $state === 'labor' ? 'Jasa' : 'Sparepart')
                            ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 1]),

                        TextEntry::make('part_source')
                            ->label('Sumber')
                            ->badge()
                            ->formatStateUsing(fn ($state) => $state === 'vendor' ? 'Dari Vendor' : 'Dari KeeHub')
                            ->color(fn ($state) => $state === 'vendor' ? 'warning' : 'info')
                            ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 1]),

                        TextEntry::make('quantity')
                            ->label('Qty')
                            ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 1]),

                        TextEntry::make('price')
                            ->label('Harga Satuan')
                            ->money('IDR')
                            ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 1]),

                        TextEntry::make('total')
                            ->label('Subtotal Riil')
                            ->money('IDR')
                            ->weight('bold')
                            ->color('primary')
                            ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 1]),

                        TextEntry::make('warranty_info')
                            ->label('Garansi')
                            ->placeholder('—')
                            ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 1]),
                    ])->columns(['default' => 2, 'sm' => 2, 'lg' => 8])->contained(true),
                ]),

            InfoSection::make('Ringkasan Biaya')
                ->description('Total biaya yang ditagihkan ke klien dan catatan modal kerja')
                ->schema([
                    TextEntry::make('invoice_total')
                        ->label('Grand Total Tagihan (Invoice Klien)')
                        ->state(fn (Service $record) => 'Rp '.number_format($record->invoiceTotal(), 0, ',', '.'))
                        ->badge()
                        ->color('success')
                        ->helperText('Hanya menghitung Part KeeHub + Jasa')
                        ->columnSpan(['default' => 2, 'sm' => 1, 'lg' => 1]),

                    TextEntry::make('work_order_total')
                        ->label('Total Riil (Work Order)')
                        ->state(fn (Service $record) => 'Rp '.number_format($record->workOrderTotal(), 0, ',', '.'))
                        ->helperText('Termasuk part Vendor & Jasa')
                        ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 1]),

                    TextEntry::make('vendor_parts_total')
                        ->label('Part dari Vendor')
                        ->state(fn (Service $record) => 'Rp '.number_format($record->vendorPartsTotal(), 0, ',', '.'))
                        ->helperText('Rp 0 pada invoice')
                        ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 1]),
                ])->columns(['default' => 2, 'sm' => 3, 'lg' => 3]),

            InfoSection::make('Riwayat Perubahan Status')
                ->description('Catatan log perubahan status dan user pembaru')
                ->schema([
                    RepeatableEntry::make('statusHistory')->schema([
                        TextEntry::make('to_status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state) => match ($state) {
                                'received' => 'gray',
                                'checking' => 'warning',
                                'waiting_approval' => 'info',
                                'processing', 'testing' => 'primary',
                                'ready', 'completed' => 'success',
                                'cancelled' => 'danger',
                                default => 'gray',
                            })
                            ->columnSpan(['default' => 1, 'sm' => 1]),

                        TextEntry::make('created_at')
                            ->label('Waktu')
                            ->dateTime('d M Y H:i')
                            ->columnSpan(['default' => 1, 'sm' => 1]),

                        TextEntry::make('user.name')
                            ->label('Diperbarui Oleh')
                            ->placeholder('Sistem')
                            ->columnSpan(['default' => 2, 'sm' => 1]),

                        TextEntry::make('notes')
                            ->label('Catatan')
                            ->placeholder('—')
                            ->columnSpanFull(),
                    ])->columns(['default' => 2, 'sm' => 3, 'lg' => 3])->contained(true),
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
                    Select::make('to_status')->label('Status baru')
                        ->options(collect(ServiceService::statusFlow()[$this->getRecord()->status] ?? [])
                            ->mapWithKeys(fn ($s) => [$s => str_replace('_', ' ', ucfirst($s))]))
                        ->required(),
                    Textarea::make('notes'),
                ])
                ->action(function (array $data) {
                    try {
                        ServiceService::setStatus($this->getRecord(), $data['to_status'], $data['notes'] ?? null, auth()->user());
                        Notification::make()->title('Status service diubah')->success()->send();
                    } catch (\DomainException $e) {
                        Notification::make()->title('Gagal')->body($e->getMessage())->danger()->send();
                    }
                })
                ->visible(fn () => ! empty(ServiceService::statusFlow()[$this->getRecord()->status])),

            ActionGroup::make([
                Action::make('thermal_receipt')
                    ->label('Cetak Struk Thermal')
                    ->icon('heroicon-o-printer')
                    ->url(fn () => route('admin.service.receipt', $this->getRecord()))
                    ->openUrlInNewTab(),

                Action::make('work_order_pdf')
                    ->label('Cetak Work Order (PDF)')
                    ->icon('heroicon-o-document-text')
                    ->url(fn () => route('admin.service.work-order.pdf', $this->getRecord()))
                    ->openUrlInNewTab(),

                Action::make('invoice_pdf')
                    ->label('Cetak Invoice (PDF)')
                    ->icon('heroicon-o-banknotes')
                    ->url(fn () => route('admin.service.invoice.pdf', $this->getRecord()))
                    ->openUrlInNewTab(),
            ])
                ->label('Cetak Dokumen')
                ->icon('heroicon-o-printer')
                ->color('gray'),

            EditAction::make(),
        ];
    }
}
