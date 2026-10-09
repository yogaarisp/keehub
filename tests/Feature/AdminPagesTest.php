<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\QcRecord;
use App\Models\Quotation;
use App\Models\Service;
use App\Models\Shipment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_admin_index_and_create_pages_load_for_owner(): void
    {
        $admin = User::factory()->create(['role' => 'owner']);

        $routes = [
            'admin' => 'filament.admin.pages.dashboard',
            'manage-settings' => 'filament.admin.pages.manage-settings',
            'reports' => 'filament.admin.pages.reports',
            'brands.index' => 'filament.admin.resources.brands.index',
            'brands.create' => 'filament.admin.resources.brands.create',
            'categories.index' => 'filament.admin.resources.categories.index',
            'categories.create' => 'filament.admin.resources.categories.create',
            'products.index' => 'filament.admin.resources.products.index',
            'products.create' => 'filament.admin.resources.products.create',
            'orders.index' => 'filament.admin.resources.orders.index',
            'orders.create' => 'filament.admin.resources.orders.create',
            'payments.index' => 'filament.admin.resources.payments.index',
            'payments.create' => 'filament.admin.resources.payments.create',
            'qcs.index' => 'filament.admin.resources.qcs.index',
            'qcs.create' => 'filament.admin.resources.qcs.create',
            'quotations.index' => 'filament.admin.resources.quotations.index',
            'quotations.create' => 'filament.admin.resources.quotations.create',
            'services.index' => 'filament.admin.resources.services.index',
            'services.create' => 'filament.admin.resources.services.create',
            'shipments.index' => 'filament.admin.resources.shipments.index',
            'shipments.create' => 'filament.admin.resources.shipments.create',
            'stock.index' => 'filament.admin.resources.stock.index',
            'stock.movements' => 'filament.admin.resources.stock.movements',
            'users.index' => 'filament.admin.resources.users.index',
            'users.create' => 'filament.admin.resources.users.create',
        ];

        foreach ($routes as $name => $route) {
            $response = $this->actingAs($admin)->get(route($route));
            $this->assertEquals(200, $response->status(), "Failed on route: {$route}");
        }
    }

    public function test_all_admin_record_view_and_edit_pages_load(): void
    {
        $admin = User::factory()->create(['role' => 'owner']);
        $brand = Brand::factory()->create();
        $category = Category::factory()->create();
        $customer = Customer::factory()->create();
        $product = Product::factory()->create(['brand_id' => $brand->id, 'category_id' => $category->id]);

        $order = Order::query()->create([
            'code' => 'ORD-TEST-001',
            'customer_id' => $customer->id,
            'type' => 'product',
            'channel' => 'admin',
            'status' => 'pending',
            'subtotal' => 100000,
            'discount' => 0,
            'shipping_cost' => 0,
            'total' => 100000,
            'shipping_name' => 'John Doe',
            'shipping_phone' => '08123456789',
        ]);

        $service = Service::query()->create([
            'code' => 'SVC-TEST-001',
            'invoice_number' => 'INV-SVC-TEST-001',
            'customer_id' => $customer->id,
            'device_name' => 'PC Gaming i9',
            'service_type' => 'rakit_pc',
            'status' => 'received',
        ]);

        $quotation = Quotation::query()->create([
            'code' => 'QOT-TEST-001',
            'customer_id' => $customer->id,
            'quotation_date' => now(),
            'subtotal' => 100000,
            'total' => 100000,
            'status' => 'draft',
        ]);

        $qc = QcRecord::query()->create([
            'service_id' => $service->id,
            'result' => 'pending',
        ]);

        $shipment = Shipment::query()->create([
            'order_id' => $order->id,
            'courier' => 'JNE',
            'status' => 'preparing',
        ]);

        $recordRoutes = [
            'brands.edit' => route('filament.admin.resources.brands.edit', $brand),
            'categories.edit' => route('filament.admin.resources.categories.edit', $category),
            'products.edit' => route('filament.admin.resources.products.edit', $product),
            'orders.view' => route('filament.admin.resources.orders.view', $order),
            'orders.edit' => route('filament.admin.resources.orders.edit', $order),
            'services.view' => route('filament.admin.resources.services.view', $service),
            'services.edit' => route('filament.admin.resources.services.edit', $service),
            'quotations.view' => route('filament.admin.resources.quotations.view', $quotation),
            'qcs.edit' => route('filament.admin.resources.qcs.edit', $qc),
            'shipments.edit' => route('filament.admin.resources.shipments.edit', $shipment),
            'users.edit' => route('filament.admin.resources.users.edit', $admin),
        ];

        foreach ($recordRoutes as $name => $url) {
            $response = $this->actingAs($admin)->get($url);
            if ($response->status() !== 200) {
                dump("Error on {$name}: ".($response->exception ? $response->exception->getMessage().' at '.$response->exception->getFile().':'.$response->exception->getLine() : substr($response->getContent(), 0, 500)));
            }
            $this->assertEquals(200, $response->status(), "Failed on route {$name}: {$url}");
        }
    }
}
