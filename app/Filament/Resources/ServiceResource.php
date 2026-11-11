<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Product;
use App\Models\Service;
use App\Models\Setting;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Set;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?string $navigationGroup = 'Service';

    protected static ?string $navigationLabel = 'Servis';

    protected static ?string $modelLabel = 'Servis';

    protected static ?string $pluralModelLabel = 'Servis';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(['default' => 1, 'lg' => 12])->schema([
                Group::make([
                    Section::make('Detail Unit PC & Diagnosa')
                        ->icon('heroicon-o-computer-desktop')
                        ->description('Model perangkat, spesifikasi, keluhan klien, dan catatan diagnosa teknisi')
                        ->schema([
                            TextInput::make('device_name')
                                ->label('Nama / Model Unit PC')
                                ->placeholder('Contoh: PC Workstation Render / PC Kantor Dell')
                                ->required()
                                ->columnSpanFull(),

                            Select::make('service_type')
                                ->label('Jenis Layanan')
                                ->options(Service::TYPES)
                                ->required()
                                ->columnSpan(['default' => 1, 'sm' => 1]),

                            TextInput::make('serial_number')
                                ->label('No. Serial / No. Asset')
                                ->placeholder('Contoh: SN-88293 / ASSET-04')
                                ->columnSpan(['default' => 1, 'sm' => 1]),

                            TextInput::make('completeness')
                                ->label('Kelengkapan Unit')
                                ->placeholder('Contoh: Unit PC, Kabel Power, Dongle')
                                ->columnSpan(['default' => 2, 'sm' => 1]),

                            TextInput::make('device_specs')
                                ->label('Spesifikasi Singkat PC')
                                ->placeholder('Contoh: Ryzen 9 7900X, RAM 64GB, RTX 4080, PSU 850W')
                                ->columnSpan(['default' => 2, 'sm' => 1]),

                            Textarea::make('problem_description')
                                ->label('Keluhan Klien / Problem Description')
                                ->rows(3)
                                ->columnSpan(['default' => 2, 'sm' => 1]),

                            Textarea::make('diagnosis')
                                ->label('Hasil Diagnosa & Solusi Teknis')
                                ->rows(3)
                                ->columnSpan(['default' => 2, 'sm' => 1]),

                            Textarea::make('notes')
                                ->label('Catatan Tambahan / Internal')
                                ->rows(2)
                                ->columnSpanFull(),
                        ])
                        ->columns(['default' => 2, 'sm' => 2]),

                    Section::make('Detail Barang & Jasa (Sparepart & Labor)')
                        ->icon('heroicon-o-wrench-screwdriver')
                        ->description('Rincian sparepart yang diganti dan jasa teknisi')
                        ->schema([
                            Repeater::make('items')
                                ->hiddenLabel()
                                ->relationship('items')
                                ->schema([
                                    Select::make('product_id')
                                        ->label('Pilih Part dari Katalog Toko (Opsional)')
                                        ->options(fn () => Product::query()->where('is_active', true)->pluck('name', 'id'))
                                        ->searchable()
                                        ->preload()
                                        ->placeholder('Pilih dari katalog toko untuk auto-fill...')
                                        ->afterStateUpdated(function (Get $get, Set $set, ?string $state): void {
                                            if ($state && ($product = Product::find($state))) {
                                                $set('name', $product->name);
                                                $set('price', $product->price);
                                                $set('item_type', 'product');
                                                $set('part_source', 'keehub');
                                            }
                                        })
                                        ->live()
                                        ->columnSpan(['default' => 2, 'sm' => 2, 'md' => 12]),

                                    TextInput::make('name')
                                        ->label('Nama Item / Jasa')
                                        ->required()
                                        ->placeholder('Contoh: Thermal Paste Arctic MX-6 / Jasa Deep Cleaning')
                                        ->columnSpan(['default' => 2, 'sm' => 2, 'md' => 6]),

                                    Select::make('item_type')
                                        ->label('Jenis Item')
                                        ->options([
                                            'product' => 'Sparepart / Barang',
                                            'labor' => 'Jasa / Labor',
                                        ])
                                        ->default('product')
                                        ->required()
                                        ->live()
                                        ->columnSpan(['default' => 1, 'sm' => 1, 'md' => 3]),

                                    Select::make('part_source')
                                        ->label('Sumber Part')
                                        ->options([
                                            'keehub' => 'Dari KeeHub',
                                            'vendor' => 'Dari Vendor',
                                        ])
                                        ->default('keehub')
                                        ->required()
                                        ->live()
                                        ->helperText(fn (Get $get): ?string => $get('part_source') === 'vendor' ? 'Dicatat ke Work Order, Rp 0 di Invoice klien.' : null)
                                        ->columnSpan(['default' => 1, 'sm' => 1, 'md' => 3]),

                                    TextInput::make('quantity')
                                        ->label('Qty')
                                        ->numeric()
                                        ->default(1)
                                        ->minValue(1)
                                        ->required()
                                        ->live(debounce: 350)
                                        ->columnSpan(['default' => 1, 'sm' => 1, 'md' => 2]),

                                    TextInput::make('price')
                                        ->label('Harga Satuan')
                                        ->numeric()
                                        ->prefix('Rp')
                                        ->default(0)
                                        ->required()
                                        ->live(debounce: 350)
                                        ->columnSpan(['default' => 1, 'sm' => 1, 'md' => 4]),

                                    TextInput::make('warranty_info')
                                        ->label('Garansi')
                                        ->placeholder('Contoh: 1 Bulan / 1 Tahun')
                                        ->columnSpan(['default' => 1, 'sm' => 1, 'md' => 3]),

                                    TextInput::make('description')
                                        ->label('Keterangan / Serial Part')
                                        ->placeholder('SN / Catatan teknis')
                                        ->columnSpan(['default' => 1, 'sm' => 1, 'md' => 3]),
                                ])
                                ->columns(['default' => 2, 'sm' => 2, 'md' => 12])
                                ->live()
                                ->defaultItems(0)
                                ->addActionLabel('+ Tambah Item / Jasa')
                                ->itemLabel(fn (array $state): ?string => filled($state['name'] ?? null)
                                    ? ($state['name'].' ('.($state['quantity'] ?? 1).'x'.(isset($state['price']) ? ' @ Rp '.number_format((int) $state['price'], 0, ',', '.') : '').' • '.(($state['part_source'] ?? '') === 'vendor' ? 'Vendor' : 'KeeHub').')')
                                    : null
                                )
                                ->collapsible()
                                ->collapsed(false)
                                ->reorderable(false),
                        ]),
                ])->columnSpan(['default' => 1, 'lg' => 8]),

                Group::make([
                    Section::make('Ringkasan Biaya (Live)')
                        ->icon('heroicon-o-calculator')
                        ->schema([
                            Placeholder::make('live_invoice_total')
                                ->label('Grand Total Invoice Klien')
                                ->content(function (Get $get): HtmlString {
                                    $totals = static::calculateFormTotals($get('items') ?? []);

                                    return new HtmlString('<span style="font-size: 1.25rem; font-weight: 700; color: #059669; font-variant-numeric: tabular-nums;">Rp '.number_format($totals['invoice'], 0, ',', '.').'</span>');
                                })
                                ->helperText('Hanya menghitung Part KeeHub + Jasa')
                                ->columnSpanFull(),

                            Placeholder::make('live_work_order_total')
                                ->label('Total Work Order (Riil)')
                                ->content(function (Get $get): string {
                                    $totals = static::calculateFormTotals($get('items') ?? []);

                                    return 'Rp '.number_format($totals['work_order'], 0, ',', '.');
                                })
                                ->columnSpan(['default' => 1, 'sm' => 1]),

                            Placeholder::make('live_vendor_total')
                                ->label('Part dari Vendor')
                                ->content(function (Get $get): string {
                                    $totals = static::calculateFormTotals($get('items') ?? []);

                                    return 'Rp '.number_format($totals['vendor'], 0, ',', '.');
                                })
                                ->columnSpan(['default' => 1, 'sm' => 1]),
                        ])
                        ->columns(['default' => 2, 'sm' => 2]),

                    Section::make('Status & Jadwal')
                        ->icon('heroicon-o-clock')
                        ->schema([
                            Select::make('status')
                                ->label('Status Servis')
                                ->options(collect(Service::STATUSES)->mapWithKeys(fn (string $s): array => [$s => Pages\ViewService::statusLabel($s)]))
                                ->default('received')
                                ->required()
                                ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 2]),

                            DatePicker::make('due_date')
                                ->label('Target Selesai')
                                ->native(false)
                                ->displayFormat('d M Y')
                                ->closeOnDateSelection()
                                ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 2]),
                        ])
                        ->columns(['default' => 2, 'sm' => 2]),

                    Section::make('Klien & Penugasan')
                        ->icon('heroicon-o-user')
                        ->schema([
                            Select::make('customer_id')
                                ->label('Klien / Pelanggan')
                                ->relationship('customer', 'name')
                                ->searchable()
                                ->preload()
                                ->createOptionForm([
                                    TextInput::make('name')->label('Nama Lengkap')->required(),
                                    TextInput::make('whatsapp')->label('No. WhatsApp')->required()->tel(),
                                    TextInput::make('email')->email(),
                                ])
                                ->columnSpanFull(),

                            TextInput::make('company_name')
                                ->label('Perusahaan / B2B')
                                ->placeholder('Contoh: PT Teknologi Maju')
                                ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 2]),

                            Select::make('source')
                                ->label('Sumber Masuk')
                                ->options([
                                    'walk_in' => 'Walk-in',
                                    'whatsapp' => 'WhatsApp',
                                    'admin' => 'Admin B2B',
                                    'website' => 'Website',
                                ])
                                ->default('admin')
                                ->required()
                                ->columnSpan(['default' => 1, 'sm' => 1, 'lg' => 2]),

                            Select::make('technician_id')
                                ->label('Teknisi Penanggung Jawab')
                                ->options(fn () => User::query()->whereIn('role', ['owner', 'staff'])->pluck('name', 'id'))
                                ->searchable()
                                ->preload()
                                ->columnSpanFull(),
                        ])
                        ->columns(['default' => 2, 'sm' => 2]),
                ])->columnSpan(['default' => 1, 'lg' => 4]),
            ])->columnSpanFull(),
        ]);
    }

    /**
     * @param  array<string, array<string, mixed>>  $items
     * @return array{invoice: int, work_order: int, vendor: int}
     */
    public static function calculateFormTotals(array $items): array
    {
        $invoice = 0;
        $vendor = 0;

        foreach ($items as $item) {
            if (! is_array($item)) {
                continue;
            }
            $qty = max(0, (int) ($item['quantity'] ?? 1));
            $price = max(0, (int) ($item['price'] ?? 0));
            $lineTotal = $qty * $price;

            if (($item['part_source'] ?? 'keehub') === 'vendor') {
                $vendor += $lineTotal;
            } else {
                $invoice += $lineTotal;
            }
        }

        return [
            'invoice' => $invoice,
            'work_order' => $invoice + $vendor,
            'vendor' => $vendor,
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(fn (Service $record): string => ServiceResource::getUrl('view', ['record' => $record]))
            ->columns([
                TextColumn::make('code')
                    ->label('No. Servis')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold')
                    ->description(fn (Service $record): string => ($record->customer?->name ?? 'Klien Umum').($record->device_name ? ' • '.$record->device_name : '').($record->created_at ? ' • '.$record->created_at->format('d/m/Y') : ''))
                    ->wrap(),

                TextColumn::make('customer.name')
                    ->label('Pelanggan / Klien')
                    ->default('—')
                    ->searchable()
                    ->weight('medium')
                    ->description(fn (Service $record): ?string => $record->company_name
                        ? ($record->company_name.($record->customer?->whatsapp ? ' • '.$record->customer->whatsapp : ''))
                        : ($record->customer?->whatsapp ?: null)
                    )
                    ->visibleFrom('md')
                    ->wrap(),

                TextColumn::make('device_name')
                    ->label('Unit PC')
                    ->placeholder('—')
                    ->limit(24)
                    ->searchable()
                    ->description(fn (Service $record): ?string => $record->service_type ? (Service::TYPES[$record->service_type] ?? $record->service_type) : null)
                    ->visibleFrom('lg'),

                TextColumn::make('status')
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
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'received' => 'Masuk',
                        'checking' => 'Pengecekan',
                        'waiting_approval' => 'Approval',
                        'processing' => 'Dikerjakan',
                        'testing' => 'QC',
                        'ready' => 'Siap Ambil',
                        'completed' => 'Selesai',
                        'cancelled' => 'Batal',
                        default => ucfirst(str_replace('_', ' ', $state)),
                    })
                    ->description(fn (Service $record): ?string => 'Rp '.number_format($record->total_cost, 0, ',', '.')),

                TextColumn::make('total_cost')
                    ->label('Tagihan')
                    ->money('IDR')
                    ->sortable()
                    ->weight('bold')
                    ->alignEnd()
                    ->description(fn (Service $record): ?string => Service::TYPES[$record->service_type] ?? null)
                    ->visibleFrom('md'),

                TextColumn::make('service_type')
                    ->label('Layanan')
                    ->badge()
                    ->formatStateUsing(fn ($state) => Service::TYPES[$state] ?? $state)
                    ->visibleFrom('xl')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('invoice_number')
                    ->label('No. Invoice')
                    ->searchable()
                    ->placeholder('—')
                    ->visibleFrom('xl')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('company_name')
                    ->label('Perusahaan B2B')
                    ->placeholder('—')
                    ->searchable()
                    ->visibleFrom('xl')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('technician.name')
                    ->label('Teknisi')
                    ->placeholder('—')
                    ->visibleFrom('xl')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Tgl Masuk')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->visibleFrom('xl')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options(collect(Service::STATUSES)->mapWithKeys(fn ($s) => [$s => match ($s) {
                        'received' => 'Masuk',
                        'checking' => 'Pengecekan',
                        'waiting_approval' => 'Approval',
                        'processing' => 'Dikerjakan',
                        'testing' => 'Quality Check',
                        'ready' => 'Siap Ambil',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                        default => ucfirst(str_replace('_', ' ', $s)),
                    }])),
                SelectFilter::make('service_type')
                    ->label('Jenis Layanan')
                    ->options(Service::TYPES),
            ])
            ->actions([
                Action::make('send_invoice_wa')
                    ->label('Kirim WA')
                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                    ->color('success')
                    ->tooltip('Kirim invoice via WhatsApp ke pelanggan')
                    ->url(fn (Service $record): string => static::buildInvoiceWaUrl($record), shouldOpenInNewTab: true),
                ActionGroup::make([
                    ViewAction::make(),
                    Action::make('send_invoice_wa_menu')
                        ->label('Kirim Invoice ke WA')
                        ->icon('heroicon-o-chat-bubble-left-ellipsis')
                        ->color('success')
                        ->url(fn (Service $record): string => static::buildInvoiceWaUrl($record), shouldOpenInNewTab: true),
                    Action::make('thermal_receipt')
                        ->label('Cetak Struk Thermal')
                        ->icon('heroicon-o-printer')
                        ->color('success')
                        ->url(fn (Service $record) => route('admin.service.receipt', $record))
                        ->openUrlInNewTab(),
                    Action::make('work_order_pdf')
                        ->label('Cetak Work Order (PDF)')
                        ->icon('heroicon-o-document-text')
                        ->color('info')
                        ->url(fn (Service $record) => route('admin.service.work-order.pdf', $record))
                        ->openUrlInNewTab(),
                    Action::make('invoice_pdf')
                        ->label('Cetak Invoice (PDF)')
                        ->icon('heroicon-o-banknotes')
                        ->color('warning')
                        ->url(fn (Service $record) => route('admin.service.invoice.pdf', $record))
                        ->openUrlInNewTab(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('60s');
    }

    public static function buildInvoiceWaMessage(Service $service): string
    {
        $service->loadMissing(['customer', 'technician', 'items']);

        $storeName = Setting::get('store_name', 'KeeHub');
        $customerName = $service->customer?->name ?? 'Pelanggan';
        $invoiceNo = $service->invoice_number ?: $service->code;
        $serviceCode = $service->code;
        $deviceName = $service->device_name ?: 'Unit PC';
        $serviceType = Service::TYPES[$service->service_type] ?? $service->service_type;

        $statusLabels = [
            'received' => 'Masuk / Diterima',
            'checking' => 'Pengecekan Teknis',
            'waiting_approval' => 'Menunggu Persetujuan',
            'processing' => 'Sedang Dikerjakan',
            'testing' => 'QC Test / Pengujian',
            'ready' => 'Siap Diambil',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];
        $statusText = $statusLabels[$service->status] ?? ucfirst(str_replace('_', ' ', (string) $service->status));

        $msg = '🧾 *INVOICE SERVIS PC — '.strtoupper($storeName)."*\n";
        $msg .= "----------------------------------------\n";
        $msg .= "Halo Kak *{$customerName}*,\n";
        $msg .= "Berikut adalah rincian invoice untuk servis unit perangkat Anda:\n\n";

        $msg .= "📄 *No. Invoice:* {$invoiceNo}\n";
        $msg .= "🔖 *No. Servis:* {$serviceCode}\n";
        $msg .= "🖥️ *Perangkat:* {$deviceName}\n";
        $msg .= "🛠️ *Layanan:* {$serviceType}\n";
        $msg .= "📊 *Status:* {$statusText}\n";

        if ($service->items->isNotEmpty()) {
            $msg .= "\n*Rincian Suku Cadang & Jasa:*\n";
            $idx = 1;
            foreach ($service->items as $item) {
                if ($item->part_source === 'vendor') {
                    $priceText = 'Part Vendor (Garansi)';
                } else {
                    $priceText = 'Rp '.number_format($item->total, 0, ',', '.');
                }
                $msg .= "{$idx}. {$item->name} ({$item->quantity}x) : {$priceText}\n";
                $idx++;
            }
        }

        $totalTagihan = number_format($service->invoiceTotal(), 0, ',', '.');
        $msg .= "\n💰 *TOTAL TAGIHAN: Rp {$totalTagihan}*\n";
        $msg .= "----------------------------------------\n";

        $bankName = Setting::get('bank_name');
        $bankNumber = Setting::get('bank_account_number');
        $bankHolder = Setting::get('bank_account_holder');

        if ($bankName && $bankNumber) {
            $msg .= "💳 *Informasi Pembayaran Transfer:*\n";
            $msg .= "Bank: {$bankName}\n";
            $msg .= "No. Rekening: *{$bankNumber}*\n";
            if ($bankHolder) {
                $msg .= "Atas Nama: {$bankHolder}\n";
            }
            $msg .= "\n";
        }

        $publicPdfUrl = route('service.public.invoice.pdf', $service);
        $trackUrl = url('/service?q='.$service->code);

        $msg .= "📥 *Download Invoice Resmi (PDF):*\n{$publicPdfUrl}\n\n";
        $msg .= "🔍 *Pantau Progres Servis Online:*\n{$trackUrl}\n\n";
        $msg .= "Terima kasih telah mempercayakan servis perangkat Anda kepada *{$storeName}*.\n";
        $msg .= 'Jika ada pertanyaan, silakan langsung balas pesan ini.';

        return $msg;
    }

    public static function buildInvoiceWaUrl(Service $record): string
    {
        $phone = $record->customer?->whatsapp ?? '';
        $cleaned = preg_replace('/[^0-9]/', '', $phone) ?? '';

        if (str_starts_with($cleaned, '0')) {
            $cleaned = '62'.substr($cleaned, 1);
        }

        $message = static::buildInvoiceWaMessage($record);
        $encoded = rawurlencode($message);

        if ($cleaned) {
            return "https://wa.me/{$cleaned}?text={$encoded}";
        }

        return "https://wa.me/?text={$encoded}";
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
            'view' => Pages\ViewService::route('/{record}'),
        ];
    }
}
