<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.pages.manage-settings';

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $title = 'Pengaturan';

    protected static ?string $navigationLabel = 'Pengaturan';

    protected static ?int $navigationSort = 5;

    public array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'store_name' => Setting::get('store_name', 'KeeHub'),
            'store_tagline' => Setting::get('store_tagline', ''),
            'store_address' => Setting::get('store_address', ''),
            'whatsapp_number' => Setting::get('whatsapp_number', ''),
            'instagram_url' => Setting::get('instagram_url', ''),
            'tiktok_url' => Setting::get('tiktok_url', ''),
            'shipping_cost' => Setting::get('shipping_cost', '15000'),
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
                TextInput::make('store_name')->label('Nama Toko')->required()->maxLength(50),
                TextInput::make('store_tagline')->label('Tagline')->maxLength(100),
                Textarea::make('store_address')->label('Alamat Toko')->rows(3),
                TextInput::make('whatsapp_number')->label('Nomor WhatsApp')->prefix('+')->maxLength(20),
                TextInput::make('instagram_url')->label('Instagram URL')->url()->maxLength(255),
                TextInput::make('tiktok_url')->label('TikTok URL')->url()->maxLength(255),
                TextInput::make('shipping_cost')->label('Biaya Ongkir (Rp)')->numeric()->minValue(0),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        Setting::put('store_name', $data['store_name']);
        Setting::put('store_tagline', $data['store_tagline']);
        Setting::put('store_address', $data['store_address']);
        Setting::put('whatsapp_number', preg_replace('/\D/', '', (string) $data['whatsapp_number']));
        Setting::put('instagram_url', $data['instagram_url']);
        Setting::put('tiktok_url', $data['tiktok_url']);
        Setting::put('shipping_cost', (string) (int) $data['shipping_cost']);

        Notification::make()
            ->title('Pengaturan berhasil disimpan.')
            ->success()
            ->send();
    }
}
