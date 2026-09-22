<?php

namespace Tests\Feature\Services;

use App\Models\Customer;
use App\Models\OrderStatusHistory;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\User;
use App\Services\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private Customer $customer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->customer = Customer::factory()->create();
    }

    public function test_create_manual_computes_totals_and_creates_invoice(): void
    {
        $product = Product::factory()->withInventory(10)->create(['price' => 100000]);

        $order = OrderService::createManual([
            'customer_id' => $this->customer->id,
            'discount' => 10000,
            'shipping_cost' => 5000,
        ], [
            ['product_id' => $product->id, 'quantity' => 2],
        ], $this->user);

        $this->assertSame('pending', $order->status);
        $this->assertSame(200000, $order->subtotal);
        $this->assertSame(195000, $order->total);
        $this->assertCount(1, $order->items);
        $this->assertSame('ORD-', substr($order->code, 0, 4));

        $this->assertNotNull($order->invoice);
        $this->assertSame('INV-', substr($order->invoice->code, 0, 4));
        $this->assertSame(195000, $order->invoice->total);
        $this->assertCount(1, $order->invoice->items);
    }

    public function test_generated_codes_are_sequential(): void
    {
        $product = Product::factory()->create(['price' => 100000]);

        $first = OrderService::createManual(['customer_id' => $this->customer->id], [
            ['product_id' => $product->id, 'quantity' => 1],
        ]);

        $second = OrderService::createManual(['customer_id' => $this->customer->id], [
            ['product_id' => $product->id, 'quantity' => 1],
        ]);

        $this->assertSame('ORD-'.now()->format('Ymd').'-001', $first->code);
        $this->assertSame('ORD-'.now()->format('Ymd').'-002', $second->code);
        $this->assertNotSame($first->code, $second->code);
    }

    public function test_confirming_order_deducts_stock_once(): void
    {
        $product = Product::factory()->withInventory(10)->create(['price' => 100000]);

        $order = OrderService::createManual(['customer_id' => $this->customer->id], [
            ['product_id' => $product->id, 'quantity' => 3],
        ]);

        OrderService::setStatus($order, 'confirmed', null, $this->user);
        OrderService::setStatus($order, 'processing', null, $this->user);

        $this->assertSame(7, $product->inventory->fresh()->current_stock);
        $this->assertSame(1, StockMovement::query()->where('type', 'out')->count());
    }

    public function test_invalid_transition_is_rejected(): void
    {
        $product = Product::factory()->create(['price' => 100000]);
        $order = OrderService::createManual(['customer_id' => $this->customer->id], [
            ['product_id' => $product->id, 'quantity' => 1],
        ]);

        $this->expectException(\DomainException::class);

        OrderService::setStatus($order, 'completed', null, $this->user);
    }

    public function test_same_status_transition_is_rejected(): void
    {
        $product = Product::factory()->create(['price' => 100000]);
        $order = OrderService::createManual(['customer_id' => $this->customer->id], [
            ['product_id' => $product->id, 'quantity' => 1],
        ]);

        $this->expectException(\DomainException::class);

        OrderService::setStatus($order, 'pending', null, $this->user);
    }

    public function test_cancelling_order_reverses_stock(): void
    {
        $product = Product::factory()->withInventory(10)->create(['price' => 100000]);

        $order = OrderService::createManual(['customer_id' => $this->customer->id], [
            ['product_id' => $product->id, 'quantity' => 3],
        ]);

        OrderService::setStatus($order, 'confirmed', null, $this->user);
        OrderService::setStatus($order, 'cancelled', null, $this->user);

        $this->assertSame(10, $product->inventory->fresh()->current_stock);

        $this->assertSame(1, StockMovement::query()->where('type', 'out')->count());
        $this->assertSame(1, StockMovement::query()->where('type', 'reversal')->count());
    }

    public function test_cancelling_before_deduction_does_not_deduct_stock(): void
    {
        $product = Product::factory()->withInventory(5)->create(['price' => 100000]);

        $order = OrderService::createManual(['customer_id' => $this->customer->id], [
            ['product_id' => $product->id, 'quantity' => 2],
        ]);

        OrderService::setStatus($order, 'cancelled', null, $this->user);

        $this->assertSame(5, $product->inventory->fresh()->current_stock);
        $this->assertCount(0, StockMovement::query()->get());
    }

    public function test_set_status_records_history(): void
    {
        $product = Product::factory()->withInventory(10)->create(['price' => 100000]);
        $order = OrderService::createManual(['customer_id' => $this->customer->id], [
            ['product_id' => $product->id, 'quantity' => 1],
        ]);

        OrderService::setStatus($order, 'confirmed', 'Oke', $this->user);

        $history = OrderStatusHistory::query()->where('order_id', $order->id)->get();

        $this->assertCount(1, $history);
        $this->assertSame('pending', $history->first()->from_status);
        $this->assertSame('confirmed', $history->first()->to_status);
        $this->assertSame('Oke', $history->first()->notes);
        $this->assertSame($this->user->id, $history->first()->user_id);
    }

    public function test_create_manual_uses_current_price_from_database(): void
    {
        $product = Product::factory()->create(['price' => 250000]);

        $order = OrderService::createManual(['customer_id' => $this->customer->id], [
            ['product_id' => $product->id, 'quantity' => 1],
        ]);

        $this->assertSame(250000, $order->items->first()->price);
    }
}
