<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Product;
use App\Models\Service;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
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
            Section::make('Informasi Klien & B2B')
                ->description('Identitas pelanggan, nomor kontak WhatsApp, dan penugasan teknisi')
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
                        ->label('Nama Perusahaan / B2B')
                        ->placeholder('Contoh: PT Teknologi Maju')
                        ->columnSpan(['default' => 1, 'sm' => 1]),

                    Select::make('source')->label('Sumber Masuk')->options([
                        'walk_in' => 'Walk-in',
                        'whatsapp' => 'WhatsApp',
                        'admin' => 'Admin B2B',
                        'website' => 'Website',
                    ])->default('admin')->required()
                        ->columnSpan(['default' => 1, 'sm' => 1]),

                    Select::make('technician_id')
                        ->label('Teknisi Penanggung Jawab')
                        ->options(fn () => User::query()->whereIn('role', ['owner', 'staff'])->pluck('name', 'id'))
                        ->searchable()
                        ->preload()
                        ->columnSpanFull(),
                ])->columns(['default' => 2, 'sm' => 2]),

            Section::make('Detail Unit PC / Perangkat')
                ->description('Model perangkat, spesifikasi singkat, dan keluhan pelanggan')
                ->schema([
                    TextInput::make('device_name')
                        ->label('Nama / Model Unit PC')
                        ->placeholder('Contoh: PC Workstation Render / PC Kantor Dell')
                        ->required()
                        ->columnSpanFull(),

                    TextInput::make('serial_number')
                        ->label('No. Serial / No. Asset')
                        ->placeholder('Contoh: SN-88293 / ASSET-04')
                        ->columnSpan(['default' => 1, 'sm' => 1]),

                    Select::make('service_type')
                        ->label('Jenis Layanan')
                        ->options(Service::TYPES)
                        ->required()
                        ->columnSpan(['default' => 1, 'sm' => 1]),

                    TextInput::make('completeness')
                        ->label('Kelengkapan Unit')
                        ->placeholder('Contoh: Unit PC, Kabel Power, Dongle')
                        ->columnSpanFull(),

                    TextInput::make('device_specs')
                        ->label('Spesifikasi Singkat PC')
                        ->placeholder('Contoh: Ryzen 9 7900X, RAM 64GB, RTX 4080, PSU 850W')
                        ->columnSpanFull(),
                ])->columns(['default' => 2, 'sm' => 2]),

            Section::make('Status & Diagnosa Pekerjaan')
                ->description('Status progres pengerjaan dan catatan teknisi')
                ->schema([
                    Select::make('status')
                        ->label('Status Servis')
                        ->options(collect(Service::STATUSES)->mapWithKeys(fn ($s) => [$s => match ($s) {
                            'received' => 'Masuk',
                            'checking' => 'Pengecekan',
                            'waiting_approval' => 'Approval',
                            'processing' => 'Dikerjakan',
                            'testing' => 'QC Test',
                            'ready' => 'Siap Ambil',
                            'completed' => 'Selesai',
                            'cancelled' => 'Dibatalkan',
                            default => ucfirst(str_replace('_', ' ', $s)),
                        }]))
                        ->default('received')
                        ->required()
                        ->columnSpan(['default' => 1, 'sm' => 1]),

                    DatePicker::make('due_date')
                        ->label('Target Selesai')
                        ->columnSpan(['default' => 1, 'sm' => 1]),

                    Textarea::make('problem_description')
                        ->label('Keluhan Klien / Problem Description')
                        ->rows(3)
                        ->columnSpanFull(),

                    Textarea::make('diagnosis')
                        ->label('Hasil Diagnosa & Solusi Teknis')
                        ->rows(3)
                        ->columnSpanFull(),

                    Textarea::make('notes')
                        ->label('Catatan Tambahan / Internal')
                        ->rows(2)
                        ->columnSpanFull(),
                ])->columns(['default' => 2, 'sm' => 2]),

            Section::make('Detail Barang & Jasa (Sparepart & Labor)')
                ->description('Rincian sparepart yang diganti dan jasa teknisi')
                ->schema([
                    Repeater::make('items')
                        ->relationship('items')
                        ->schema([
                            Select::make('product_id')
                                ->label('Pilih Part dari Katalog Toko (Opsional)')
                                ->options(fn () => Product::query()->where('is_active', true)->pluck('name', 'id'))
                                ->searchable()
                                ->preload()
                                ->placeholder('Pilih dari katalog toko untuk auto-fill...')
                                ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
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
                                ->helperText(fn (Get $get) => $get('part_source') === 'vendor' ? 'Harga dicatat untuk Work Order, Rp 0 pada Invoice klien.' : null)
                                ->columnSpan(['default' => 1, 'sm' => 1, 'md' => 3]),

                            TextInput::make('quantity')
                                ->label('Qty')
                                ->numeric()
                                ->default(1)
                                ->minValue(1)
                                ->required()
                                ->live()
                                ->columnSpan(['default' => 1, 'sm' => 1, 'md' => 3]),

                            TextInput::make('price')
                                ->label('Harga Satuan')
                                ->numeric()
                                ->prefix('Rp')
                                ->default(0)
                                ->required()
                                ->live()
                                ->columnSpan(['default' => 1, 'sm' => 1, 'md' => 3]),

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
                        ->defaultItems(0)
                        ->addActionLabel('+ Tambah Item / Jasa')
                        ->itemLabel(fn (array $state): ?string => filled($state['name'] ?? null)
                            ? ($state['name'].' ('.($state['quantity'] ?? 1).'x'.(isset($state['price']) ? ' @ Rp '.number_format($state['price'], 0, ',', '.') : '').' • '.(($state['part_source'] ?? '') === 'vendor' ? 'Vendor' : 'KeeHub').')')
                            : null
                        )
                        ->collapsible()
                        ->collapsed(false)
                        ->reorderable(false),
                ]),
        ]);
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
                ActionGroup::make([
                    ViewAction::make(),
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
