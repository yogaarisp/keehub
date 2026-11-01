<?php

namespace Tests\Feature;

use App\Filament\Resources\CustomerResource;
use App\Filament\Resources\CustomerResource\Pages\CreateCustomer;
use App\Filament\Resources\CustomerResource\Pages\EditCustomer;
use App\Filament\Resources\CustomerResource\Pages\ListCustomers;
use App\Filament\Resources\CustomerResource\Pages\ViewCustomer;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CustomerResourceTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'owner']);
    }

    public function test_can_render_customer_list_page(): void
    {
        $customers = Customer::factory()->count(3)->create();

        $this->actingAs($this->admin)
            ->get(CustomerResource::getUrl('index'))
            ->assertOk();

        Livewire::actingAs($this->admin)
            ->test(ListCustomers::class)
            ->assertCanSeeTableRecords($customers);
    }

    public function test_can_create_customer(): void
    {
        Livewire::actingAs($this->admin)
            ->test(CreateCustomer::class)
            ->fillForm([
                'name' => 'Pelanggan Baru Testing',
                'whatsapp' => '081299998888',
                'email' => 'testing@example.com',
                'notes' => 'Catatan pelanggan VIP',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('customers', [
            'name' => 'Pelanggan Baru Testing',
            'whatsapp' => '081299998888',
            'email' => 'testing@example.com',
        ]);
    }

    public function test_can_update_customer_data(): void
    {
        $customer = Customer::factory()->create([
            'name' => 'Nama Lama',
            'whatsapp' => '08111111111',
            'email' => 'lama@example.com',
        ]);

        $this->actingAs($this->admin)
            ->get(CustomerResource::getUrl('edit', ['record' => $customer]))
            ->assertOk();

        Livewire::actingAs($this->admin)
            ->test(EditCustomer::class, ['record' => $customer->getRouteKey()])
            ->fillForm([
                'name' => 'Nama Diperbarui',
                'whatsapp' => '08222222222',
                'email' => 'baru@example.com',
                'notes' => 'Sudah diverifikasi via telepon',
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'name' => 'Nama Diperbarui',
            'whatsapp' => '08222222222',
            'email' => 'baru@example.com',
            'notes' => 'Sudah diverifikasi via telepon',
        ]);
    }

    public function test_can_render_view_customer_page(): void
    {
        $customer = Customer::factory()->create([
            'name' => 'Pelanggan View',
            'whatsapp' => '08133333333',
        ]);

        $this->actingAs($this->admin)
            ->get(CustomerResource::getUrl('view', ['record' => $customer]))
            ->assertOk();

        Livewire::actingAs($this->admin)
            ->test(ViewCustomer::class, ['record' => $customer->getRouteKey()])
            ->assertSuccessful();
    }
}
