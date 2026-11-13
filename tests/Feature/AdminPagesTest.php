<?php

namespace Tests\Feature;

use App\Filament\Pages\Reports;
use App\Filament\Resources\PaymentResource\Pages\ListPayments;
use App\Filament\Resources\QuotationResource\Pages\ListQuotations;
use App\Filament\Resources\ShipmentResource\Pages\ListShipments;
use App\Filament\Widgets\LowStock;
use App\Filament\Widgets\RecentOrders;
use App\Filament\Widgets\RecentServices;
use App\Filament\Widgets\StatsOverview;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Inventory;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Product;
use App\Models\QcRecord;
use App\Models\Quotation;
use App\Models\Service;
use App\Models\Shipment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
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
            'customers.index' => 'filament.admin.resources.customers.index',
            'customers.create' => 'filament.admin.resources.customers.create',
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
            'customers.view' => route('filament.admin.resources.customers.view', $customer),
            'customers.edit' => route('filament.admin.resources.customers.edit', $customer),
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

    public function test_reports_page_and_export_works(): void
    {
        $admin = User::factory()->create(['role' => 'owner']);

        $response = $this->actingAs($admin)->get(route('filament.admin.pages.reports'));
        $response->assertOk();

        Livewire::actingAs($admin)
            ->test(Reports::class)
            ->call('applyPreset', 'today')
            ->assertSet('activePreset', 'today')
            ->call('applyFilter')
            ->assertHasNoErrors()
            ->callAction('export_excel')
            ->assertSuccessful();
    }

    public function test_dashboard_widgets_render_with_records(): void
    {
        $admin = User::factory()->create(['role' => 'owner']);
        $brand = Brand::factory()->create();
        $category = Category::factory()->create();
        $customer = Customer::factory()->create();
        $product = Product::factory()->create(['brand_id' => $brand->id, 'category_id' => $category->id]);

        $inventory = Inventory::query()->updateOrCreate(
            ['product_id' => $product->id],
            ['current_stock' => 1, 'min_stock' => 5],
        );

        $order = Order::query()->create([
            'code' => 'ORD-DASH-001',
            'customer_id' => $customer->id,
            'type' => 'product',
            'channel' => 'admin',
            'status' => 'pending',
            'subtotal' => 250000,
            'discount' => 0,
            'shipping_cost' => 0,
            'total' => 250000,
            'shipping_name' => $customer->name,
            'shipping_phone' => $customer->whatsapp,
        ]);

        $service = Service::query()->create([
            'code' => 'SVC-DASH-001',
            'invoice_number' => 'INV-SVC-DASH-001',
            'customer_id' => $customer->id,
            'device_name' => 'PC Workstation Test',
            'service_type' => 'troubleshooting',
            'status' => 'processing',
        ]);

        Livewire::actingAs($admin)
            ->test(StatsOverview::class)
            ->assertSee('Penjualan Hari Ini')
            ->assertSee('Pesanan Hari Ini')
            ->assertSee('Servis Aktif')
            ->assertSee('Stok Menipis');

        Livewire::actingAs($admin)
            ->test(RecentOrders::class)
            ->assertCanSeeTableRecords([$order]);

        Livewire::actingAs($admin)
            ->test(LowStock::class)
            ->assertCanSeeTableRecords([$inventory]);

        Livewire::actingAs($admin)
            ->test(RecentServices::class)
            ->assertCanSeeTableRecords([$service]);
    }

    public function test_quotation_create_modal_action_works(): void
    {
        $admin = User::factory()->create(['role' => 'owner']);
        $customer = Customer::factory()->create();

        $test = Livewire::actingAs($admin)
            ->test(ListQuotations::class)
            ->mountAction('create');

        $mountedItems = $test->get('mountedActionsData.0.items');
        $itemKey = is_array($mountedItems) && ! empty($mountedItems)
            ? array_key_first($mountedItems)
            : (string) \Illuminate\Support\Str::uuid();

        $test->setActionData([
            'customer_id' => $customer->id,
            'quotation_date' => today()->format('Y-m-d'),
            'expired_date' => today()->addDays(14)->format('Y-m-d'),
            'status' => 'draft',
            'discount' => 10000,
            'shipping' => 15000,
            'items' => [
                $itemKey => [
                    'name' => 'Paket Rakit PC Office',
                    'item_type' => 'custom',
                    'quantity' => 2,
                    'price' => 5000000,
                ],
            ],
        ])
            ->callMountedAction()
            ->assertHasNoActionErrors();

        $this->assertDatabaseHas('quotations', [
            'customer_id' => $customer->id,
            'status' => 'draft',
            'discount' => 10000,
            'shipping' => 15000,
            'subtotal' => 10000000,
            'total' => 10005000,
        ]);
    }

    public function test_payment_create_modal_action_works(): void
    {
        $admin = User::factory()->create(['role' => 'owner']);
        $customer = Customer::factory()->create();
        $order = Order::query()->create([
            'code' => 'ORD-PAY-001',
            'customer_id' => $customer->id,
            'type' => 'product',
            'channel' => 'admin',
            'status' => 'pending',
            'subtotal' => 500000,
            'discount' => 0,
            'shipping_cost' => 0,
            'total' => 500000,
        ]);
        $invoice = Invoice::query()->create([
            'order_id' => $order->id,
            'code' => 'INV-TEST-001',
            'status' => 'unpaid',
            'total' => 500000,
            'due_date' => today()->addDays(7),
        ]);

        Livewire::actingAs($admin)
            ->test(ListPayments::class)
            ->mountAction('create')
            ->setActionData([
                'invoice_id' => $invoice->id,
                'method' => 'transfer',
                'amount' => 500000,
                'paid_at' => today()->format('Y-m-d'),
                'reference' => 'TRF-TEST-123',
                'notes' => 'Lunas via transfer BCA',
            ])
            ->callMountedAction()
            ->assertHasNoActionErrors();

        $this->assertDatabaseHas('payments', [
            'invoice_id' => $invoice->id,
            'method' => 'transfer',
            'amount' => 500000,
            'reference' => 'TRF-TEST-123',
        ]);

        $this->assertEquals('paid', $invoice->fresh()->status);
    }

    public function test_shipment_create_modal_action_works(): void
    {
        $admin = User::factory()->create(['role' => 'owner']);
        $customer = Customer::factory()->create();
        $order = Order::query()->create([
            'code' => 'ORD-SHIP-001',
            'customer_id' => $customer->id,
            'type' => 'product',
            'channel' => 'admin',
            'status' => 'pending',
            'subtotal' => 300000,
            'discount' => 0,
            'shipping_cost' => 20000,
            'total' => 320000,
        ]);

        Livewire::actingAs($admin)
            ->test(ListShipments::class)
            ->mountAction('create')
            ->setActionData([
                'order_id' => $order->id,
                'courier' => 'JNE',
                'tracking_number' => 'JNE-RESI-12345',
                'shipping_cost' => 20000,
                'status' => 'preparing',
                'shipped_at' => today()->format('Y-m-d'),
                'notes' => 'Packing kayu aman',
            ])
            ->callMountedAction()
            ->assertHasNoActionErrors();

        $this->assertDatabaseHas('shipments', [
            'order_id' => $order->id,
            'courier' => 'JNE',
            'tracking_number' => 'JNE-RESI-12345',
            'shipping_cost' => 20000,
        ]);
    }
}
