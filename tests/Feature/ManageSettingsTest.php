<?php

namespace Tests\Feature;

use App\Filament\Pages\ManageSettings;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ManageSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_manage_settings_page_can_be_rendered(): void
    {
        $owner = User::factory()->create(['role' => 'owner']);

        $response = $this->actingAs($owner)->get(route('filament.admin.pages.manage-settings'));

        $response->assertSuccessful();
        $response->assertSee('Pengaturan Toko');
        $response->assertSee('Printer &amp; Struk Kasir', false);
    }

    public function test_owner_can_update_printer_settings(): void
    {
        $owner = User::factory()->create(['role' => 'owner']);

        Livewire::actingAs($owner)
            ->test(ManageSettings::class)
            ->set('data.printer_connection_type', 'bluetooth')
            ->set('data.printer_name', 'RPP02N Bluetooth POS')
            ->set('data.printer_paper_size', '58mm')
            ->set('data.printer_device_name', 'RPP02N-BLE')
            ->set('data.printer_print_logo', true)
            ->set('data.printer_auto_cut', true)
            ->set('data.printer_open_cash_drawer', true)
            ->set('data.printer_copies', '2')
            ->set('data.printer_header_text', 'Cabang Utama')
            ->set('data.printer_footer_text', 'Terima kasih telah berbelanja!')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertSame('bluetooth', Setting::get('printer_connection_type'));
        $this->assertSame('RPP02N Bluetooth POS', Setting::get('printer_name'));
        $this->assertSame('58mm', Setting::get('printer_paper_size'));
        $this->assertSame('RPP02N-BLE', Setting::get('printer_device_name'));
        $this->assertSame('1', Setting::get('printer_print_logo'));
        $this->assertSame('1', Setting::get('printer_auto_cut'));
        $this->assertSame('1', Setting::get('printer_open_cash_drawer'));
        $this->assertSame('2', Setting::get('printer_copies'));
        $this->assertSame('Cabang Utama', Setting::get('printer_header_text'));
        $this->assertSame('Terima kasih telah berbelanja!', Setting::get('printer_footer_text'));
    }

    public function test_owner_can_update_courier_api_settings(): void
    {
        $owner = User::factory()->create(['role' => 'owner']);

        Livewire::actingAs($owner)
            ->test(ManageSettings::class)
            ->set('data.courier_api_enabled', true)
            ->set('data.courier_api_provider', 'biteship')
            ->set('data.courier_api_key', 'biteship_test_key_123456')
            ->set('data.courier_origin_city', 'Kota Yogyakarta')
            ->set('data.courier_origin_subdistrict', 'Gondokusuman')
            ->set('data.courier_available_list', ['jne', 'sicepat'])
            ->set('data.courier_coming_soon_note', 'Sedang dalam pengujian kurir.')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertSame('1', Setting::get('courier_api_enabled'));
        $this->assertSame('biteship', Setting::get('courier_api_provider'));
        $this->assertSame('biteship_test_key_123456', Setting::get('courier_api_key'));
        $this->assertSame('Kota Yogyakarta', Setting::get('courier_origin_city'));
        $this->assertSame('Gondokusuman', Setting::get('courier_origin_subdistrict'));
        $this->assertSame(json_encode(['jne', 'sicepat']), Setting::get('courier_available_list'));
        $this->assertSame('Sedang dalam pengujian kurir.', Setting::get('courier_coming_soon_note'));
    }

    public function test_owner_can_update_invoice_header_and_footer_settings(): void
    {
        $owner = User::factory()->create(['role' => 'owner']);

        Livewire::actingAs($owner)
            ->test(ManageSettings::class)
            ->set('data.invoice_header_brand', 'KEETECH STORE')
            ->set('data.invoice_header_tagline', 'Solusi Komputer & Service Profesional')
            ->set('data.invoice_header_contact', "Jl. Malioboro No. 12\nWhatsApp: 08123456789")
            ->set('data.invoice_payment_instructions', "BCA: 987654321 a/n Yoga AP")
            ->set('data.invoice_signature_name', 'Keetech Management')
            ->set('data.service_invoice_footer', 'Terima kasih telah mempercayakan servis komputer kepada kami.')
            ->call('save')
            ->assertHasNoErrors();

        $this->assertSame('KEETECH STORE', Setting::get('invoice_header_brand'));
        $this->assertSame('Solusi Komputer & Service Profesional', Setting::get('invoice_header_tagline'));
        $this->assertSame("Jl. Malioboro No. 12\nWhatsApp: 08123456789", Setting::get('invoice_header_contact'));
        $this->assertSame("BCA: 987654321 a/n Yoga AP", Setting::get('invoice_payment_instructions'));
        $this->assertSame('Keetech Management', Setting::get('invoice_signature_name'));
        $this->assertSame('Terima kasih telah mempercayakan servis komputer kepada kami.', Setting::get('service_invoice_footer'));
    }
}
