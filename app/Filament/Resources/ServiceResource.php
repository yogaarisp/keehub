<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?string $navigationGroup = 'Service';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Informasi Klien & B2B')->schema([
                Select::make('customer_id')
                    ->label('Klien / Pelanggan')
                    ->relationship('customer', 'name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('name')->label('Nama Lengkap')->required(),
                        TextInput::make('whatsapp')->label('No. WhatsApp')->required()->tel(),
                        TextInput::make('email')->email(),
                    ]),
                TextInput::make('company_name')
                    ->label('Nama Perusahaan / Klien B2B')
                    ->placeholder('Contoh: PT Teknologi Maju / Studio Animasi'),
                Select::make('source')->label('Sumber Masuk')->options([
                    'walk_in' => 'Walk-in (Datang Langsung)',
                    'whatsapp' => 'WhatsApp',
                    'admin' => 'Admin B2B / Kontrak',
                    'website' => 'Website Tracker',
                ])->default('admin')->required(),
                Select::make('technician_id')
                    ->label('Teknisi Penanggung Jawab')
                    ->options(fn () => User::query()->whereIn('role', ['owner', 'staff'])->pluck('name', 'id'))
                    ->searchable()
                    ->preload(),
            ])->columns(2),

            Section::make('Detail Unit PC / Perangkat')->schema([
                TextInput::make('device_name')
                    ->label('Nama / Model Unit PC')
                    ->placeholder('Contoh: PC Workstation Render / PC Kantor Dell')
                    ->required(),
                TextInput::make('serial_number')
                    ->label('No. Serial / No. Asset')
                    ->placeholder('Contoh: SN-88293 / ASSET-B2B-04'),
                Select::make('service_type')
                    ->label('Jenis Layanan')
                    ->options(Service::TYPES)
                    ->required(),
                TextInput::make('completeness')
                    ->label('Kelengkapan Unit')
                    ->placeholder('Contoh: Unit PC, Kabel Power, Dongle Wi-Fi'),
                TextInput::make('device_specs')
                    ->label('Spesifikasi Singkat PC')
                    ->placeholder('Contoh: Ryzen 9 7900X, RAM 64GB, RTX 4080, PSU 850W')
                    ->columnSpanFull(),
            ])->columns(2),

            Section::make('Status & Diagnosa Pekerjaan')->schema([
                Select::make('status')
                    ->options(collect(Service::STATUSES)->mapWithKeys(fn ($s) => [$s => str_replace('_', ' ', ucfirst($s))]))
                    ->default('received')
                    ->required(),
                DatePicker::make('due_date')
                    ->label('Target Selesai / Estimasi'),
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
            ])->columns(2),

            Section::make('Detail Barang & Jasa (Sparepart & Labor)')->schema([
                Repeater::make('items')
                    ->relationship('items')
                    ->schema([
                        Select::make('item_type')
                            ->label('Jenis')
                            ->options([
                                'product' => 'Sparepart / Barang',
                                'labor' => 'Jasa / Labor',
                            ])
                            ->default('product')
                            ->required()
                            ->live(),

                        TextInput::make('name')
                            ->label('Nama Item / Jasa')
                            ->required(),

                        Select::make('part_source')
                            ->label('Sumber Part')
                            ->options([
                                'keehub' => 'Dari KeeHub',
                                'vendor' => 'Dari Vendor',
                            ])
                            ->default('keehub')
                            ->required()
                            ->live()
                            ->helperText(fn (Get $get) => $get('part_source') === 'vendor' ? 'Harga asli dicatat untuk Work Order, otomatis Rp 0 pada Invoice tagihan klien.' : null),

                        TextInput::make('quantity')
                            ->label('Qty')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->required()
                            ->live(),

                        TextInput::make('price')
                            ->label('Harga Satuan')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0)
                            ->required()
                            ->live(),

                        TextInput::make('warranty_info')
                            ->label('Garansi')
                            ->placeholder('Contoh: 1 Tahun'),

                        TextInput::make('description')
                            ->label('Keterangan / Serial Part')
                            ->placeholder('SN / Catatan teknis'),
                    ])
                    ->columns(3)
                    ->defaultItems(0)
                    ->addActionLabel('+ Tambah Item / Jasa')
                    ->collapsible()
                    ->reorderable(false),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')->label('No. Servis')->searchable()->sortable(),
                TextColumn::make('invoice_number')->label('No. Invoice')->searchable()->placeholder('—'),
                TextColumn::make('customer.name')->label('Pelanggan')->default('—')->searchable(),
                TextColumn::make('company_name')->label('Perusahaan')->placeholder('—')->searchable(),
                TextColumn::make('device_name')->label('Unit PC')->placeholder('—')->limit(24)->searchable(),
                TextColumn::make('service_type')->label('Layanan')->badge()->formatStateUsing(fn ($state) => Service::TYPES[$state] ?? $state),
                TextColumn::make('technician.name')->label('Teknisi')->placeholder('—'),
                TextColumn::make('status')->badge()->color(fn (string $state) => match ($state) {
                    'received' => 'gray',
                    'checking' => 'warning',
                    'waiting_approval' => 'info',
                    'processing', 'testing' => 'primary',
                    'ready', 'completed' => 'success',
                    'cancelled' => 'danger',
                    default => 'gray',
                }),
                TextColumn::make('total_cost')->label('Total Tagihan')->money('IDR')->sortable(),
                TextColumn::make('created_at')->label('Tgl Masuk')->dateTime('d M Y H:i')->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')->options(array_combine(Service::STATUSES, array_map(fn ($s) => str_replace('_', ' ', ucfirst($s)), Service::STATUSES))),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
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
