<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Service;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThermalReceiptTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_order_thermal_receipt(): void
    {
        $admin = User::factory()->create(['role' => 'owner']);
        $customer = Customer::factory()->create(['name' => 'Budi Santoso', 'whatsapp' => '081234567890']);
        $product = Product::factory()->create(['name' => 'Gateron Yellow Switch', 'price' => 150000]);

        $order = Order::query()->create([
            'code' => 'ORD-TEST-001',
            'customer_id' => $customer->id,
            'type' => 'product',
            'channel' => 'offline',
            'status' => 'completed',
            'subtotal' => 150000,
            'discount' => 0,
            'shipping_cost' => 0,
            'total' => 150000,
        ]);

        OrderItem::query()->create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'name' => 'Gateron Yellow Switch',
            'quantity' => 1,
            'price' => 150000,
            'total' => 150000,
        ]);

        Setting::put('printer_paper_size', '58mm');
        Setting::put('printer_print_logo', '1');

        $response = $this->actingAs($admin)->get(route('admin.order.receipt', $order));

        $response->assertSuccessful();
        $response->assertSee('ORD-TEST-001');
        $response->assertSee('Budi Santoso');
        $response->assertSee('Gateron Yellow Switch');
        $response->assertSee('Rp 150.000');
    }

    public function test_admin_can_view_service_thermal_receipt(): void
    {
        $admin = User::factory()->create(['role' => 'owner']);
        $customer = Customer::factory()->create(['name' => 'Andi Wijaya', 'whatsapp' => '089876543210']);

        $service = Service::query()->create([
            'code' => 'SRV-TEST-001',
            'customer_id' => $customer->id,
            'service_type' => 'rakit_pc',
            'device_name' => 'PC Gaming Custom',
            'serial_number' => 'SN-12345',
            'status' => 'ready',
            'problem_description' => 'Upgrade RAM & Cable Management',
            'total_cost' => 250000,
        ]);

        Setting::put('printer_paper_size', '80mm');

        $response = $this->actingAs($admin)->get(route('admin.service.receipt', $service));

        $response->assertSuccessful();
        $response->assertSee('SRV-TEST-001');
        $response->assertSee('Andi Wijaya');
        $response->assertSee('PC Gaming Custom');
        $response->assertSee('Rp 250.000');
    }
}
