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
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
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
                    ->maxLength(255)
                    ->columnSpan(['default' => 1, 'sm' => 1]),

                TextInput::make('whatsapp')
                    ->label('No. WhatsApp')
                    ->placeholder('Contoh: 08123456789')
                    ->required()
                    ->tel()
                    ->maxLength(25)
                    ->helperText('Gunakan format 08xx atau 62xx untuk integrasi chat')
                    ->columnSpan(['default' => 1, 'sm' => 1]),

                TextInput::make('email')
                    ->label('Alamat Email')
                    ->placeholder('Contoh: budi@gmail.com')
                    ->email()
                    ->maxLength(255)
                    ->columnSpan(['default' => 1, 'sm' => 1]),

                Select::make('user_id')
                    ->label('Tautkan ke Akun User Web')
                    ->relationship('user', 'email')
                    ->searchable()
                    ->preload()
                    ->placeholder('Opsional (akun login customer)')
                    ->columnSpan(['default' => 1, 'sm' => 1]),

                Textarea::make('notes')
                    ->label('Catatan Pelanggan / Internal')
                    ->placeholder('Catatan preferensi rakitan, info perusahaan B2B, atau riwayat khusus')
                    ->rows(3)
                    ->columnSpanFull(),
            ])->columns(['default' => 1, 'sm' => 2]),

            Section::make('Daftar Alamat Pengiriman')->schema([
                Repeater::make('addresses')
                    ->relationship('addresses')
                    ->schema([
                        TextInput::make('label')
                            ->label('Label Alamat')
                            ->placeholder('Contoh: Rumah / Kantor / Gudang')
                            ->columnSpan(['default' => 1, 'sm' => 1]),

                        TextInput::make('recipient_name')
                            ->label('Nama Penerima')
                            ->required()
                            ->placeholder('Nama penerima paket')
                            ->columnSpan(['default' => 1, 'sm' => 1]),

                        TextInput::make('phone')
                            ->label('No. Telepon / HP')
                            ->required()
                            ->tel()
                            ->placeholder('08xxxxxxxxxx')
                            ->columnSpan(['default' => 1, 'sm' => 1]),

                        TextInput::make('city')
                            ->label('Kota / Kabupaten')
                            ->required()
                            ->placeholder('Contoh: Surabaya')
                            ->columnSpan(['default' => 1, 'sm' => 1]),

                        TextInput::make('province')
                            ->label('Provinsi')
                            ->required()
                            ->placeholder('Contoh: Jawa Timur')
                            ->columnSpan(['default' => 1, 'sm' => 1]),

                        TextInput::make('postal_code')
                            ->label('Kode Pos')
                            ->placeholder('Contoh: 60111')
                            ->columnSpan(['default' => 1, 'sm' => 1]),

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
                    ->columns(['default' => 1, 'sm' => 2])
                    ->defaultItems(0)
                    ->addActionLabel('+ Tambah Alamat Pengiriman')
                    ->itemLabel(fn (array $state): ?string => filled($state['recipient_name'] ?? null)
                        ? (($state['label'] ? '['.$state['label'].'] ' : '').$state['recipient_name'].' ('.($state['city'] ?? '').')')
                        : null
                    )
                    ->collapsible()
                    ->collapsed(false),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Pelanggan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (Customer $record): ?string => $record->email ?: null),

                TextColumn::make('whatsapp')
                    ->label('WhatsApp')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-phone')
                    ->color('success')
                    ->url(
                        fn (Customer $record): string => 'https://wa.me/'.static::formatWaNumber($record->whatsapp),
                        shouldOpenInNewTab: true
                    ),

                TextColumn::make('orders_count')
                    ->counts('orders')
                    ->label('Pesanan')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                TextColumn::make('services_count')
                    ->counts('services')
                    ->label('Servis')
                    ->badge()
                    ->color('warning')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Terdaftar')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('has_orders')
                    ->label('Pernah Order')
                    ->query(fn (Builder $query): Builder => $query->has('orders')),

                Filter::make('has_services')
                    ->label('Pernah Servis')
                    ->query(fn (Builder $query): Builder => $query->has('services')),
            ])
            ->actions([
                Action::make('chat_wa')
                    ->label('Chat WA')
                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                    ->color('success')
                    ->url(
                        fn (Customer $record): string => 'https://wa.me/'.static::formatWaNumber($record->whatsapp),
                        shouldOpenInNewTab: true
                    ),
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
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
                    ->placeholder('—')
                    ->columnSpan(['default' => 1, 'sm' => 1]),

                TextEntry::make('user.name')
                    ->label('Akun User Web')
                    ->placeholder('Belum terhubung ke akun web')
                    ->columnSpan(['default' => 1, 'sm' => 1]),

                TextEntry::make('notes')
                    ->label('Catatan Khusus')
                    ->placeholder('—')
                    ->columnSpanFull(),
            ])->columns(['default' => 1, 'sm' => 2]),

            InfoSection::make('Statistik Aktivitas')->schema([
                TextEntry::make('orders_count')
                    ->state(fn (Customer $record): int => $record->orders()->count())
                    ->label('Total Transaksi Pesanan')
                    ->badge()
                    ->color('info')
                    ->columnSpan(['default' => 1, 'sm' => 1]),

                TextEntry::make('services_count')
                    ->state(fn (Customer $record): int => $record->services()->count())
                    ->label('Total Unit Servis')
                    ->badge()
                    ->color('warning')
                    ->columnSpan(['default' => 1, 'sm' => 1]),
            ])->columns(['default' => 1, 'sm' => 2]),

            InfoSection::make('Daftar Alamat Pengiriman Tersimpan')->schema([
                RepeatableEntry::make('addresses')
                    ->schema([
                        TextEntry::make('label')
                            ->label('Label')
                            ->badge()
                            ->color('gray')
                            ->columnSpan(['default' => 1, 'sm' => 1]),

                        TextEntry::make('recipient_name')
                            ->label('Penerima')
                            ->weight('bold')
                            ->columnSpan(['default' => 1, 'sm' => 1]),

                        TextEntry::make('phone')
                            ->label('Telepon')
                            ->columnSpan(['default' => 1, 'sm' => 1]),

                        TextEntry::make('city')
                            ->label('Kota & Provinsi')
                            ->formatStateUsing(fn ($record) => ($record->city ?? '').', '.($record->province ?? '').($record->postal_code ? ' '.$record->postal_code : ''))
                            ->columnSpan(['default' => 1, 'sm' => 1]),

                        TextEntry::make('address')
                            ->label('Alamat')
                            ->columnSpanFull(),
                    ])
                    ->columns(['default' => 1, 'sm' => 2])
                    ->placeholder('Belum ada alamat tersimpan'),
            ]),
        ]);
    }

    public static function formatWaNumber(string $phone): string
    {
        $cleaned = preg_replace('/[^0-9]/', '', $phone) ?? '';

        if (str_starts_with($cleaned, '0')) {
            return '62'.substr($cleaned, 1);
        }

        return $cleaned;
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
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
}
