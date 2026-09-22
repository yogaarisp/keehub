<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminInvoiceTest extends TestCase
{
    use RefreshDatabase;

    private function seedInvoice(): Invoice
    {
        $customer = Customer::factory()->create();

        $order = Order::query()->create([
            'code' => 'ORD-'.now()->format('Ymd').'-001',
            'customer_id' => $customer->id,
            'type' => 'product',
            'channel' => 'website',
            'status' => 'pending',
            'subtotal' => 100000,
            'discount' => 0,
            'shipping_cost' => 0,
            'total' => 100000,
            'shipping_name' => 'Test Customer',
            'shipping_phone' => '6281234567890',
            'shipping_address' => 'Jl. Test No. 1',
        ]);

        return Invoice::query()->create([
            'code' => 'INV-'.now()->format('Ymd').'-001',
            'order_id' => $order->id,
            'customer_id' => $customer->id,
            'subtotal' => 100000,
            'discount' => 0,
            'shipping' => 0,
            'total' => 100000,
            'paid_amount' => 0,
            'status' => 'unpaid',
        ]);
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $invoice = $this->seedInvoice();

        $this->get(route('admin.invoice.pdf', $invoice))
            ->assertRedirect(route('login'));
    }

    public function test_customer_gets_403(): void
    {
        $invoice = $this->seedInvoice();
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.invoice.pdf', $invoice))
            ->assertForbidden();
    }

    public function test_staff_can_download_pdf(): void
    {
        $invoice = $this->seedInvoice();
        $staff = User::factory()->staff()->create();

        $response = $this->actingAs($staff)
            ->get(route('admin.invoice.pdf', $invoice));

        $response->assertOk();
        $response->assertHeader('content-disposition');
        $this->assertStringContainsString($invoice->code, (string) $response->headers->get('content-disposition'));
    }

    public function test_owner_can_download_pdf(): void
    {
        $invoice = $this->seedInvoice();
        $owner = User::factory()->owner()->create();

        $response = $this->actingAs($owner)
            ->get(route('admin.invoice.pdf', $invoice));

        $response->assertOk();
        $response->assertHeader('content-disposition');
    }
}
