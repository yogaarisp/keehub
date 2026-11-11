<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Models\Customer;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section as InfoSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Sales';

    protected static ?string $navigationLabel = 'Pelanggan';

    protected static ?string $modelLabel = 'Pelanggan';

    protected static ?string $pluralModelLabel = 'Pelanggan';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Informasi Kontak Pelanggan')->schema([
                TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->placeholder('Contoh: Budi Santoso')
                    ->required()
                    ->maxLength(255),

                TextInput::make('whatsapp')
                    ->label('No. WhatsApp')
                    ->placeholder('Contoh: 08123456789')
                    ->required()
                    ->tel()
                    ->maxLength(25)
                    ->helperText('Gunakan format 08xx atau 62xx untuk integrasi chat'),

                TextInput::make('email')
                    ->label('Alamat Email')
                    ->placeholder('Contoh: budi@gmail.com')
                    ->email()
                    ->maxLength(255),

                Select::make('user_id')
                    ->label('Tautkan ke Akun User Web')
                    ->relationship('user', 'email')
                    ->searchable()
                    ->preload()
                    ->placeholder('Opsional (akun login customer)'),

                Textarea::make('notes')
                    ->label('Catatan Pelanggan / Internal')
                    ->placeholder('Catatan preferensi rakitan, info perusahaan B2B, atau riwayat khusus...')
                    ->rows(2)
                    ->columnSpanFull(),
            ])->columns(['default' => 1, 'sm' => 2]),

            Section::make('Daftar Alamat Pengiriman')->schema([
                Repeater::make('addresses')
                    ->relationship('addresses')
                    ->hiddenLabel()
                    ->schema([
                        TextInput::make('label')
                            ->label('Label Alamat')
                            ->placeholder('Contoh: Rumah / Kantor / Gudang'),

                        TextInput::make('recipient_name')
                            ->label('Nama Penerima')
                            ->required()
                            ->placeholder('Nama penerima paket'),

                        TextInput::make('phone')
                            ->label('No. Telepon / HP')
                            ->required()
                            ->tel()
                            ->placeholder('08xxxxxxxxxx'),

                        TextInput::make('city')
                            ->label('Kota / Kabupaten')
                            ->required()
                            ->placeholder('Contoh: Surabaya'),

                        TextInput::make('province')
                            ->label('Provinsi')
                            ->required()
                            ->placeholder('Contoh: Jawa Timur'),

                        TextInput::make('postal_code')
                            ->label('Kode Pos')
                            ->placeholder('Contoh: 60111'),

                        Textarea::make('address')
                            ->label('Alamat Lengkap (Jalan, RT/RW, No. Rumah)')
                            ->required()
                            ->rows(2)
                            ->columnSpanFull(),

                        Toggle::make('is_default')
                            ->label('Jadikan Alamat Utama')
                            ->default(false)
                            ->columnSpanFull(),
                    ])
                    ->columns(['default' => 1, 'sm' => 2, 'md' => 3])
                    ->defaultItems(0)
                    ->addActionLabel('+ Tambah Alamat Pengiriman')
                    ->itemLabel(fn (array $state): ?string => filled($state['recipient_name'] ?? null)
                        ? (($state['label'] ? '['.$state['label'].'] ' : '').$state['recipient_name'].' ('.($state['city'] ?? '').')')
                        : 'Alamat Pengiriman Baru'
                    )
                    ->collapsible()
                    ->cloneable()
                    ->collapsed(false)
                    ->deletable()
                    ->reorderable(false),
            ])
                ->collapsible()
                ->collapsed(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->withCount(['orders', 'services'])->withSum('orders', 'total'))
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Pelanggan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (Customer $record): string => $record->whatsapp.' • Rp '.number_format((int) ($record->orders_sum_total ?? 0), 0, ',', '.')),

                TextColumn::make('whatsapp')
                    ->label('No. WhatsApp')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-phone')
                    ->color('success')
                    ->weight('medium')
                    ->description(fn (Customer $record): ?string => $record->addresses->first()?->city ? 'Alamat: '.$record->addresses->first()->city : null)
                    ->url(
                        fn (Customer $record): string => 'https://wa.me/'.static::formatWaNumber($record->whatsapp),
                        shouldOpenInNewTab: true
                    )
                    ->visibleFrom('md'),

                TextColumn::make('orders_sum_total')
                    ->label('Total Transaksi')
                    ->state(fn (Customer $record): int => (int) ($record->orders_sum_total ?? 0))
                    ->money('IDR')
                    ->sortable()
                    ->weight('bold')
                    ->alignEnd()
                    ->description(fn (Customer $record): string => ($record->orders_count ?? 0).' pesanan')
                    ->visibleFrom('md'),

                TextColumn::make('orders_count')
                    ->label('Pesanan')
                    ->counts('orders')
                    ->badge()
                    ->color('info')
                    ->sortable()
                    ->alignCenter()
                    ->visibleFrom('md'),

                TextColumn::make('services_count')
                    ->label('Servis')
                    ->counts('services')
                    ->badge()
                    ->color('warning')
                    ->sortable()
                    ->alignCenter()
                    ->visibleFrom('md'),

                TextColumn::make('created_at')
                    ->label('Terdaftar')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->visibleFrom('lg')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('activity')
                    ->label('Filter Aktivitas')
                    ->options([
                        'has_orders' => 'Pernah Order Produk',
                        'has_services' => 'Pernah Servis Keyboard',
                        'no_transactions' => 'Belum Ada Transaksi',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return match ($data['value'] ?? null) {
                            'has_orders' => $query->has('orders'),
                            'has_services' => $query->has('services'),
                            'no_transactions' => $query->doesntHave('orders')->doesntHave('services'),
                            default => $query,
                        };
                    }),
            ])
            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make()
                        ->modalHeading('Ubah Data Pelanggan')
                        ->modalSubmitActionLabel('Simpan Perubahan')
                        ->modalCancelAction(false)
                        ->modalWidth(MaxWidth::ThreeExtraLarge),
                    Action::make('chat_wa')
                        ->label('Chat WhatsApp')
                        ->icon('heroicon-o-chat-bubble-left-ellipsis')
                        ->color('success')
                        ->url(
                            fn (Customer $record): string => 'https://wa.me/'.static::formatWaNumber($record->whatsapp),
                            shouldOpenInNewTab: true
                        ),
                    DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('60s');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            InfoSection::make('Profil Pelanggan')->schema([
                TextEntry::make('name')
                    ->label('Nama Lengkap')
                    ->weight('bold')
                    ->columnSpan(['default' => 1, 'sm' => 1]),

                TextEntry::make('whatsapp')
                    ->label('No. WhatsApp')
                    ->badge()
                    ->color('success')
                    ->copyable()
                    ->url(
                        fn (Customer $record): string => 'https://wa.me/'.static::formatWaNumber($record->whatsapp),
                        shouldOpenInNewTab: true
                    )
                    ->columnSpan(['default' => 1, 'sm' => 1]),

                TextEntry::make('email')
                    ->label('Email')
                    ->default('-')
                    ->columnSpan(['default' => 1, 'sm' => 1]),

                TextEntry::make('created_at')
                    ->label('Terdaftar Sejak')
                    ->dateTime('d F Y, H:i')
                    ->columnSpan(['default' => 1, 'sm' => 1]),

                TextEntry::make('notes')
                    ->label('Catatan Khusus')
                    ->default('-')
                    ->columnSpanFull(),
            ])->columns(['default' => 1, 'sm' => 2]),

            InfoSection::make('Daftar Alamat Pengiriman')->schema([
                RepeatableEntry::make('addresses')->schema([
                    TextEntry::make('label')
                        ->label('Label')
                        ->badge()
                        ->default('Alamat'),

                    TextEntry::make('recipient_name')
                        ->label('Penerima'),

                    TextEntry::make('phone')
                        ->label('No. HP'),

                    TextEntry::make('full_address')
                        ->label('Alamat Lengkap')
                        ->state(fn ($record) => $record->address.', '.$record->city.', '.$record->province.' '.$record->postal_code)
                        ->columnSpanFull(),
                ])->columns(['default' => 1, 'sm' => 3]),
            ]),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'view' => Pages\ViewCustomer::route('/{record}'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }

    public static function formatWaNumber(string $phone): string
    {
        $cleaned = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($cleaned, '0')) {
            return '62'.substr($cleaned, 1);
        }
        if (str_starts_with($cleaned, '8')) {
            return '62'.$cleaned;
        }

        return $cleaned;
    }
}
