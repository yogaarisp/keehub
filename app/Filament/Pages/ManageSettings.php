<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\View as ViewComponent;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.pages.manage-settings';

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'System';

    protected static ?string $title = 'Pengaturan Toko';

    protected static ?string $navigationLabel = 'Pengaturan';

    protected static ?int $navigationSort = 2;

    public array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'store_logo' => Setting::get('store_logo'),
            'store_favicon' => Setting::get('store_favicon'),
            'store_name' => Setting::get('store_name', 'KeeHub'),
            'store_tagline' => Setting::get('store_tagline', 'Build Your PC. Your Way.'),
            'store_description' => Setting::get('store_description', ''),
            'store_address' => Setting::get('store_address', ''),
            'store_email' => Setting::get('store_email', ''),
            'whatsapp_number' => Setting::get('whatsapp_number', ''),
            'instagram_url' => Setting::get('instagram_url', ''),
            'tiktok_url' => Setting::get('tiktok_url', ''),
            'shipping_cost' => Setting::get('shipping_cost', '15000'),
            'operating_hours' => Setting::get('operating_hours', 'Senin - Sabtu: 10:00 - 20:00 WIB'),
            'bank_name' => Setting::get('bank_name', ''),
            'bank_account_number' => Setting::get('bank_account_number', ''),
            'bank_account_holder' => Setting::get('bank_account_holder', ''),
            'invoice_footer_notes' => Setting::get('invoice_footer_notes', ''),
            'service_warranty_terms' => Setting::get('service_warranty_terms', ''),
            'printer_connection_type' => Setting::get('printer_connection_type', 'browser'),
            'printer_name' => Setting::get('printer_name', 'Thermal Receipt Printer 58mm'),
            'printer_paper_size' => Setting::get('printer_paper_size', '58mm'),
            'printer_device_name' => Setting::get('printer_device_name', ''),
            'printer_ip_address' => Setting::get('printer_ip_address', '192.168.1.200'),
            'printer_port' => Setting::get('printer_port', '9100'),
            'printer_print_logo' => (bool) Setting::get('printer_print_logo', '1'),
            'printer_auto_cut' => (bool) Setting::get('printer_auto_cut', '1'),
            'printer_open_cash_drawer' => (bool) Setting::get('printer_open_cash_drawer', '0'),
            'printer_copies' => Setting::get('printer_copies', '1'),
            'printer_header_text' => Setting::get('printer_header_text', ''),
            'printer_footer_text' => Setting::get('printer_footer_text', 'Terima kasih telah berbelanja di KeeHub!'),
        ]);
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->role === 'owner';
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([
                Tabs::make('Pengaturan')
                    ->tabs([
                        Tab::make('Identitas & Branding')
                            ->icon('heroicon-o-paint-brush')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 2])->schema([
                                    FileUpload::make('store_logo')
                                        ->label('Logo Utama Toko')
                                        ->image()
                                        ->disk('public')
                                        ->directory('settings')
                                        ->visibility('public')
                                        ->maxSize(2048)
                                        ->helperText('Ditampilkan di Header Website, Sidebar Admin, dan Nota. Rekomendasi PNG transparan rasio 1:1, maks 2MB.'),

                                    FileUpload::make('store_favicon')
                                        ->label('Favicon Tab Browser')
                                        ->image()
                                        ->disk('public')
                                        ->directory('settings')
                                        ->visibility('public')
                                        ->maxSize(1024)
                                        ->helperText('Ikon kecil untuk tab browser. Rekomendasi rasio 1:1 (PNG/ICO), maks 1MB.'),
                                ]),

                                Grid::make(['default' => 1, 'md' => 2])->schema([
                                    TextInput::make('store_name')
                                        ->label('Nama Toko')
                                        ->required()
                                        ->maxLength(50)
                                        ->placeholder('KeeHub'),

                                    TextInput::make('store_tagline')
                                        ->label('Tagline / Slogan')
                                        ->maxLength(100)
                                        ->placeholder('Build Your PC. Your Way.'),
                                ]),

                                Textarea::make('store_description')
                                    ->label('Deskripsi Singkat Toko')
                                    ->rows(3)
                                    ->placeholder('Pusat perakitan PC, modifikasi dan servis keyboard mekanik terpercaya.')
                                    ->helperText('Deskripsi untuk profil toko dan optimasi mesin pencari (SEO).'),
                            ]),

                        Tab::make('Kontak & Media Sosial')
                            ->icon('heroicon-o-chat-bubble-left-right')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 2])->schema([
                                    TextInput::make('whatsapp_number')
                                        ->label('Nomor WhatsApp Resmi')
                                        ->prefix('+62')
                                        ->helperText('Masukkan angka saja tanpa spasi, contoh: 81234567890')
                                        ->maxLength(20),

                                    TextInput::make('store_email')
                                        ->label('Email Toko / Customer Support')
                                        ->email()
                                        ->placeholder('support@keetech.my.id'),
                                ]),

                                Grid::make(['default' => 1, 'md' => 2])->schema([
                                    TextInput::make('instagram_url')
                                        ->label('Instagram URL')
                                        ->url()
                                        ->placeholder('https://instagram.com/keehub')
                                        ->maxLength(255),

                                    TextInput::make('tiktok_url')
                                        ->label('TikTok URL')
                                        ->url()
                                        ->placeholder('https://tiktok.com/@keehub')
                                        ->maxLength(255),
                                ]),

                                Textarea::make('store_address')
                                    ->label('Alamat Toko Fisik / Workshop')
                                    ->rows(3)
                                    ->placeholder('Jl. Contoh No. 123, Kota, Provinsi'),
                            ]),

                        Tab::make('Operasional & Pembayaran')
                            ->icon('heroicon-o-banknotes')
                            ->schema([
                                Grid::make(['default' => 1, 'md' => 2])->schema([
                                    TextInput::make('shipping_cost')
                                        ->label('Biaya Ongkir Standar Flat (Rp)')
                                        ->numeric()
                                        ->minValue(0)
                                        ->prefix('Rp')
                                        ->placeholder('15000')
                                        ->helperText('Tarif dasar pengiriman paket belanja ke pelanggan.'),

                                    TextInput::make('operating_hours')
                                        ->label('Jam Operasional Toko')
                                        ->placeholder('Senin - Sabtu: 10:00 - 20:00 WIB')
                                        ->maxLength(100),
                                ]),

                                Section::make('Informasi Rekening Pembayaran (Manual Transfer)')
                                    ->description('Informasi rekening yang ditampilkan kepada pelanggan saat memilih pembayaran transfer bank.')
                                    ->schema([
                                        Grid::make(['default' => 1, 'md' => 3])->schema([
                                            TextInput::make('bank_name')
                                                ->label('Nama Bank')
                                                ->placeholder('BCA / Mandiri / BNI'),

                                            TextInput::make('bank_account_number')
                                                ->label('Nomor Rekening')
                                                ->placeholder('1234567890'),

                                            TextInput::make('bank_account_holder')
                                                ->label('Atas Nama Rekening')
                                                ->placeholder('KeeHub Official'),
                                        ]),
                                    ])
                                    ->collapsible(),
                            ]),

                        Tab::make('Nota & Ketentuan Servis')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Textarea::make('invoice_footer_notes')
                                    ->label('Catatan Kaki Nota / Invoice')
                                    ->rows(3)
                                    ->placeholder('Terima kasih telah berbelanja di KeeHub! Barang yang sudah dibeli dapat ditukar jika terdapat cacat pabrik dalam 2x24 jam.')
                                    ->helperText('Pesan yang tercetak di bagian bawah nota pesanan dan struk belanja.'),

                                Textarea::make('service_warranty_terms')
                                    ->label('Syarat & Ketentuan Garansi Servis')
                                    ->rows(4)
                                    ->placeholder('Garansi servis berlaku selama 14 hari terhitung sejak tanggal unit selesai dikerjakan. Tidak mencakup kerusakan akibat cairan atau kelalaian pengguna.')
                                    ->helperText('Ketentuan garansi pengerjaan reparasi / servis keyboard & PC.'),
                            ]),

                        Tab::make('Printer & Struk Kasir')
                            ->icon('heroicon-o-printer')
                            ->schema([
                                Grid::make(['default' => 1, 'lg' => 12])->schema([
                                    // Kolom Kiri: Form Pengaturan (7 cols di desktop)
                                    Grid::make(1)->columnSpan(['default' => 12, 'lg' => 7])->schema([
                                        Section::make('Koneksi & Perangkat Printer')
                                            ->description('Pilih cara komputer kasir atau tablet terhubung ke printer struk.')
                                            ->schema([
                                                Grid::make(['default' => 1, 'md' => 2])->schema([
                                                    Select::make('printer_connection_type')
                                                        ->label('Tipe Sambungan')
                                                        ->options([
                                                            'browser' => 'Sistem Driver / Browser (Rekomendasi)',
                                                            'bluetooth' => 'Bluetooth POS (Mobile / Portable)',
                                                            'usb' => 'Direct USB (Kabel / OTG)',
                                                            'network' => 'Jaringan LAN / WiFi (IP Raw 9100)',
                                                        ])
                                                        ->live()
                                                        ->required(),

                                                    Select::make('printer_paper_size')
                                                        ->label('Ukuran Roll Kertas')
                                                        ->options([
                                                            '58mm' => '58mm (Kertas Mini Kasir / Mobile)',
                                                            '80mm' => '80mm (Kertas Standar Kasir Besar)',
                                                        ])
                                                        ->live()
                                                        ->required(),
                                                ]),

                                                Grid::make(['default' => 1, 'md' => 2])->schema([
                                                    TextInput::make('printer_name')
                                                        ->label('Nama / Label Printer')
                                                        ->placeholder('Contoh: Thermal POS 58mm')
                                                        ->required()
                                                        ->maxLength(60),

                                                    TextInput::make('printer_device_name')
                                                        ->label('Nama Perangkat Bluetooth / USB')
                                                        ->placeholder('Contoh: RPP02N / Panda POS')
                                                        ->visible(fn (Get $get) => in_array($get('printer_connection_type'), ['bluetooth', 'usb'])),

                                                    TextInput::make('printer_ip_address')
                                                        ->label('Alamat IP Printer')
                                                        ->placeholder('192.168.1.200')
                                                        ->visible(fn (Get $get) => $get('printer_connection_type') === 'network')
                                                        ->required(fn (Get $get) => $get('printer_connection_type') === 'network'),

                                                    TextInput::make('printer_port')
                                                        ->label('Port Socket (Default: 9100)')
                                                        ->placeholder('9100')
                                                        ->numeric()
                                                        ->visible(fn (Get $get) => $get('printer_connection_type') === 'network'),
                                                ]),
                                            ]),

                                        Section::make('Format Struk Kasir')
                                            ->description('Sesuaikan logo, pemotong kertas, dan pesan struk belanja.')
                                            ->schema([
                                                Grid::make(['default' => 1, 'md' => 3])->schema([
                                                    Toggle::make('printer_print_logo')
                                                        ->label('Cetak Logo Toko')
                                                        ->default(true),

                                                    Toggle::make('printer_auto_cut')
                                                        ->label('Auto Cut Kertas')
                                                        ->default(true),

                                                    Toggle::make('printer_open_cash_drawer')
                                                        ->label('Buka Laci Uang')
                                                        ->default(false),
                                                ]),

                                                Grid::make(['default' => 1, 'md' => 2])->schema([
                                                    Select::make('printer_copies')
                                                        ->label('Jumlah Salinan Cetak')
                                                        ->options([
                                                            '1' => '1 Salinan (Untuk Pelanggan)',
                                                            '2' => '2 Salinan (Pelanggan + Arsip)',
                                                        ])
                                                        ->default('1'),

                                                    Textarea::make('printer_header_text')
                                                        ->label('Catatan Header (Opsional)')
                                                        ->rows(2)
                                                        ->placeholder("Spesialis Custom Keyboard & PC\nCabang Sleman, DI Yogyakarta"),
                                                ]),

                                                Textarea::make('printer_footer_text')
                                                    ->label('Pesan Kaki Struk (Footer)')
                                                    ->rows(2)
                                                    ->placeholder("Terima kasih telah berbelanja di KeeHub!\nBarang yang sudah dibeli bergaransi resmi toko."),
                                            ]),
                                    ]),

                                    // Kolom Kanan: Live Preview & Quick Test Print (5 cols di desktop)
                                    Grid::make(1)->columnSpan(['default' => 12, 'lg' => 5])->schema([
                                        ViewComponent::make('filament.components.printer-test-preview'),
                                    ]),
                                ]),
                            ]),
                    ])
                    ->persistTabInQueryString(),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            if ($key === 'whatsapp_number' && $value) {
                $value = preg_replace('/\D/', '', (string) $value);
            }
            if (is_bool($value)) {
                $value = $value ? '1' : '0';
            }
            Setting::put($key, is_null($value) ? '' : (string) $value);
        }

        Notification::make()
            ->title('Pengaturan Berhasil Disimpan')
            ->body('Seluruh perubahan identitas toko, operasional, dan printer telah diperbarui.')
            ->success()
            ->send();
    }
}
