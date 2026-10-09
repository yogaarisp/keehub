<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Filament\Resources\ServiceResource;
use App\Models\Service;
use App\Services\ServiceService;
use Filament\Actions\Action;
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

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            InfoSection::make('Informasi Layanan & Klien B2B')->schema([
                TextEntry::make('code')->label('No. Servis')->badge()->color('primary'),
                TextEntry::make('invoice_number')->label('No. Invoice')->placeholder('—')->badge()->color('warning'),
                TextEntry::make('customer.name')->default('—')->label('Nama Klien'),
                TextEntry::make('company_name')->label('Perusahaan / B2B')->placeholder('—'),
                TextEntry::make('customer.whatsapp')->label('WhatsApp'),
                TextEntry::make('source')->label('Sumber Masuk')->badge(),
                TextEntry::make('technician.name')->default('—')->label('Teknisi'),
                TextEntry::make('status')->badge()->color(fn (string $state) => match ($state) {
                    'received' => 'gray',
                    'checking' => 'warning',
                    'waiting_approval' => 'info',
                    'processing', 'testing' => 'primary',
                    'ready', 'completed' => 'success',
                    'cancelled' => 'danger',
                    default => 'gray',
                }),
                TextEntry::make('due_date')->label('Target Selesai')->date('d M Y')->placeholder('—'),
            ])->columns(3),

            InfoSection::make('Detail Unit PC / Perangkat')->schema([
                TextEntry::make('device_name')->label('Nama / Tipe PC')->placeholder('—'),
                TextEntry::make('serial_number')->label('Serial Number / Asset')->placeholder('—'),
                TextEntry::make('service_type')->label('Layanan')->formatStateUsing(fn ($state) => Service::TYPES[$state] ?? $state)->badge(),
                TextEntry::make('completeness')->label('Kelengkapan Unit')->placeholder('—'),
                TextEntry::make('device_specs')->label('Spesifikasi Unit')->placeholder('—')->columnSpan(2),
                TextEntry::make('problem_description')->label('Keluhan Klien')->columnSpanFull(),
                TextEntry::make('diagnosis')->label('Diagnosa & Tindakan Teknisi')->columnSpanFull(),
            ])->columns(3),

            InfoSection::make('Rincian Suku Cadang & Jasa')->schema([
                RepeatableEntry::make('items')->schema([
                    TextEntry::make('name')->label('Nama Item / Jasa'),
                    TextEntry::make('item_type')->label('Tipe')
                        ->badge()
                        ->color(fn (string $state) => $state === 'labor' ? 'gray' : 'primary'),
                    TextEntry::make('part_source')->label('Sumber Part')
                        ->badge()
                        ->formatStateUsing(fn ($state) => $state === 'vendor' ? 'Dari Vendor' : 'Dari KeeHub')
                        ->color(fn ($state) => $state === 'vendor' ? 'warning' : 'info'),
                    TextEntry::make('quantity')->label('Qty'),
                    TextEntry::make('price')->label('Harga Asli')->money('IDR'),
                    TextEntry::make('total')->label('Subtotal Riil')->money('IDR'),
                    TextEntry::make('warranty_info')->label('Garansi')->placeholder('—'),
                ])->columns(7)->contained(false),
            ]),

            InfoSection::make('Ringkasan Biaya')->schema([
                TextEntry::make('work_order_total')
                    ->label('Total Pekerjaan (Work Order / Riil)')
                    ->state(fn (Service $record) => 'Rp '.number_format($record->workOrderTotal(), 0, ',', '.'))
                    ->helperText('Termasuk seluruh part KeeHub, Vendor, dan Jasa'),
                TextEntry::make('vendor_parts_total')
                    ->label('Nilai Part Dari Vendor')
                    ->state(fn (Service $record) => 'Rp '.number_format($record->vendorPartsTotal(), 0, ',', '.'))
                    ->helperText('Rp 0 pada invoice tagihan klien'),
                TextEntry::make('invoice_total')
                    ->label('Grand Total Tagihan (Invoice Klien)')
                    ->state(fn (Service $record) => 'Rp '.number_format($record->invoiceTotal(), 0, ',', '.'))
                    ->badge()
                    ->color('success')
                    ->helperText('Hanya menghitung Part KeeHub + Jasa'),
            ])->columns(3),

            InfoSection::make('Riwayat Perubahan Status')->schema([
                RepeatableEntry::make('statusHistory')->schema([
                    TextEntry::make('from_status')->placeholder('—'),
                    TextEntry::make('to_status')->badge(),
                    TextEntry::make('user.name')->placeholder('system'),
                    TextEntry::make('created_at')->dateTime('d M Y H:i'),
                    TextEntry::make('notes')->placeholder('—'),
                ])->columns(5)->contained(false),
            ]),
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),

            Action::make('work_order_pdf')
                ->label('Cetak Work Order (PDF)')
                ->icon('heroicon-o-document-text')
                ->color('info')
                ->url(fn () => route('admin.service.work-order.pdf', $this->getRecord()))
                ->openUrlInNewTab(),

            Action::make('invoice_pdf')
                ->label('Cetak Invoice (PDF)')
                ->icon('heroicon-o-banknotes')
                ->color('warning')
                ->url(fn () => route('admin.service.invoice.pdf', $this->getRecord()))
                ->openUrlInNewTab(),

            Action::make('advance_status')
                ->label('Ubah Status')
                ->icon('heroicon-m-arrow-path')
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
        ];
    }
}
