<?php

namespace Tests\Feature\Services;

use App\Models\Customer;
use App\Models\PcBuild;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use App\Services\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_count_returns_zero_for_guest_without_cart(): void
    {
        $this->assertSame(0, CartService::count());
        $this->assertDatabaseCount('carts', 0);
    }

    public function test_count_returns_item_quantity_without_creating_cart(): void
    {
        $product = Product::factory()->create(['price' => 500000]);

        CartService::addProduct($product, 2);
        $cart = CartService::current();

        $this->assertSame(2, CartService::count());
        $this->assertSame(1, $cart->items()->count());
        $this->assertDatabaseCount('carts', 1);
    }

    public function test_guest_cart_is_isolated_per_session(): void
    {
        $product = Product::factory()->create();

        session()->setId('guest-session-1');
        CartService::addProduct($product, 1);
        $this->assertSame(1, CartService::count());

        session()->setId('guest-session-2');
        $this->assertSame(0, CartService::count());
        $this->assertDatabaseCount('carts', 1);
    }

    public function test_add_build_requires_build_in_cart_once(): void
    {
        $product = Product::factory()->create(['price' => 1000000]);
        $user = User::factory()->create();
        $build = $this->makeBuild($user, $product);

        $this->actingAs($user);

        CartService::addBuild($build->id);
        CartService::addBuild($build->id);

        $cart = CartService::current();
        $this->assertSame(1, $cart->items()->count());
        $this->assertSame('build', $cart->items()->first()->item_type);
    }

    public function test_subtotal_counts_products_and_builds(): void
    {
        $p1 = Product::factory()->create(['price' => 100000]);
        $p2 = Product::factory()->create(['price' => 250000]);
        $user = User::factory()->create();

        $this->actingAs($user);

        CartService::addProduct($p1, 2);
        CartService::addProduct($p2, 1);

        $build = $this->makeBuild($user, Product::factory()->create(['price' => 500000]));
        CartService::addBuild($build->id);

        $this->assertSame(100000 * 2 + 250000 + 500000, CartService::subtotal());
    }

    public function test_checkout_creates_order_and_clears_cart(): void
    {
        $product = Product::factory()->create(['price' => 300000]);
        $customer = Customer::factory()->create();
        $user = User::factory()->create();

        $this->actingAs($user);

        CartService::addProduct($product, 2);

        $order = CartService::checkout([
            'customer_id' => $customer->id,
            'shipping_cost' => 15000,
        ], $user);

        $this->assertSame(600000, $order->subtotal);
        $this->assertSame(615000, $order->total);
        $this->assertSame(2, $order->items()->sum('quantity'));
        $this->assertSame('website', $order->channel);

        $this->assertSame(0, CartService::count());
    }

    public function test_checkout_throws_when_cart_is_empty(): void
    {
        $this->expectException(\DomainException::class);

        CartService::checkout(['shipping_cost' => 0], null);
    }

    public function test_shipping_cost_reads_setting_for_ship_and_zero_for_pickup(): void
    {
        Setting::put('shipping_cost', '20000');

        $this->assertSame(20000, CartService::shippingCost('ship'));
        $this->assertSame(0, CartService::shippingCost('pickup'));
    }

    private function makeBuild(User $user, Product $product): PcBuild
    {
        $build = PcBuild::query()->create([
            'code' => PcBuild::generateCode(),
            'user_id' => $user->id,
            'name' => 'Build Test',
            'status' => 'draft',
            'share_token' => bin2hex(random_bytes(12)),
        ]);

        $build->items()->create([
            'slot' => 'cpu',
            'product_id' => $product->id,
            'price' => $product->price,
        ]);
        $build->update(['total_price' => $product->price]);

        return $build;
    }
}
