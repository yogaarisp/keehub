<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class CheckoutControllerTest extends TestCase
{
    use RefreshDatabase;

    private function guestSessionId(): string
    {
        return str_repeat('a', 40);
    }

    private function addGuestProductToCart(Product $product, int $quantity = 1): void
    {
        $cart = Cart::query()->create(['session_id' => $this->guestSessionId(), 'user_id' => null]);
        CartItem::query()->create([
            'cart_id' => $cart->id,
            'item_type' => 'product',
            'product_id' => $product->id,
            'quantity' => $quantity,
        ]);
    }

    private function postGuestCheckout(array $data): TestResponse
    {
        return $this
            ->withoutMiddleware([EncryptCookies::class])
            ->withUnencryptedCookie(config('session.cookie'), $this->guestSessionId())
            ->post(route('checkout.store'), $data);
    }

    public function test_empty_cart_redirects_to_cart_index(): void
    {
        $this->get(route('checkout.index'))
            ->assertRedirect(route('cart.index'));
    }

    public function test_shipping_cost_from_request_is_ignored_for_ship(): void
    {
        Setting::put('shipping_cost', '20000');
        $product = Product::factory()->create(['price' => 100000]);
        $this->addGuestProductToCart($product, 1);

        $this->postGuestCheckout([
            'name' => 'Test User',
            'whatsapp' => '6281234567890',
            'address' => 'Jl. Test No. 1',
            'shipping_method' => 'ship',
            'shipping_cost' => 1,
        ])->assertRedirect();

        $order = Order::query()->firstOrFail();
        $this->assertSame(20000, $order->shipping_cost);
        $this->assertSame(120000, $order->total);
        $this->assertSame('website', $order->channel);
        $this->assertSame('Jl. Test No. 1', $order->shipping_address);
    }

    public function test_pickup_always_charges_zero_shipping(): void
    {
        Setting::put('shipping_cost', '20000');
        $product = Product::factory()->create(['price' => 100000]);
        $this->addGuestProductToCart($product, 1);

        $this->postGuestCheckout([
            'name' => 'Test User',
            'whatsapp' => '6281234567890',
            'address' => '',
            'shipping_method' => 'pickup',
            'shipping_cost' => 999999,
        ])->assertRedirect();

        $order = Order::query()->firstOrFail();
        $this->assertSame(0, $order->shipping_cost);
        $this->assertSame(100000, $order->total);
        $this->assertSame('Pickup at Store', $order->shipping_address);
    }

    public function test_auth_checkout_links_order_to_customer_of_current_user(): void
    {
        $user = User::factory()->create();
        $customer = Customer::factory()->forUser($user)->create();
        $product = Product::factory()->create(['price' => 100000]);

        $cart = Cart::query()->create(['session_id' => null, 'user_id' => $user->id]);
        CartItem::query()->create([
            'cart_id' => $cart->id,
            'item_type' => 'product',
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response = $this->actingAs($user)->post(route('checkout.store'), [
            'name' => 'Test User',
            'whatsapp' => '6281234567890',
            'address' => 'Jl. Test',
            'shipping_method' => 'ship',
        ]);

        $order = Order::query()->firstOrFail();
        $this->assertSame($customer->id, $order->customer_id);

        $response->assertRedirect(route('account.orders.show', $order));
    }

    public function test_guest_checkout_creates_new_customer_record(): void
    {
        $product = Product::factory()->create(['price' => 100000]);
        $this->addGuestProductToCart($product, 1);

        $this->postGuestCheckout([
            'name' => 'Budi Tamu',
            'whatsapp' => '628111222333',
            'address' => 'Jl. Tamu',
            'shipping_method' => 'ship',
        ])->assertRedirect();

        $customer = Customer::query()->where('whatsapp', '628111222333')->first();
        $this->assertNotNull($customer);
        $this->assertNull($customer->user_id);

        $order = Order::query()->firstOrFail();
        $this->assertSame($customer->id, $order->customer_id);
    }

    public function test_invalid_shipping_method_is_rejected(): void
    {
        $product = Product::factory()->create(['price' => 100000]);
        $this->addGuestProductToCart($product, 1);

        $response = $this->postGuestCheckout([
            'name' => 'Test',
            'whatsapp' => '6281234567890',
            'address' => 'Jl. Test',
            'shipping_method' => 'drone',
        ]);

        $response->assertSessionHasErrors('shipping_method');
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_requires_address_when_ship_method(): void
    {
        $product = Product::factory()->create(['price' => 100000]);
        $this->addGuestProductToCart($product, 1);

        $response = $this->postGuestCheckout([
            'name' => 'Test',
            'whatsapp' => '6281234567890',
            'address' => '',
            'shipping_method' => 'ship',
        ]);

        $response->assertSessionHasErrors('address');
    }
}
