<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Order;
use App\Models\PcBuild;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountControllerTest extends TestCase
{
    use RefreshDatabase;

    private function seedOrder(User $user): Order
    {
        $customer = Customer::factory()->forUser($user)->create();

        return Order::query()->create([
            'code' => 'ORD-'.now()->format('Ymd').'-'.str_pad((string) fake()->unique()->numberBetween(1, 999), 3, '0', STR_PAD_LEFT),
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
    }

    private function seedBuild(User $user): PcBuild
    {
        return PcBuild::query()->create([
            'code' => PcBuild::generateCode(),
            'user_id' => $user->id,
            'name' => 'Rakit Saya',
            'status' => 'draft',
            'share_token' => bin2hex(random_bytes(12)),
        ]);
    }

    public function test_guests_are_redirected_to_login(): void
    {
        $order = $this->seedOrder(User::factory()->create());

        $this->get(route('account.dashboard'))->assertRedirect(route('login'));
        $this->get(route('account.orders'))->assertRedirect(route('login'));
        $this->get(route('account.orders.show', $order))->assertRedirect(route('login'));
        $this->get(route('account.builds'))->assertRedirect(route('login'));
    }

    public function test_dashboard_loads_for_authenticated_customer(): void
    {
        $user = User::factory()->create();
        $this->seedOrder($user);
        $this->seedBuild($user);

        $this->actingAs($user)
            ->get(route('account.dashboard'))
            ->assertOk();
    }

    public function test_customer_can_view_own_order(): void
    {
        $user = User::factory()->create();
        $order = $this->seedOrder($user);

        $this->actingAs($user)
            ->get(route('account.orders.show', $order))
            ->assertOk()
            ->assertSee($order->code);
    }

    public function test_customer_cannot_view_another_users_order(): void
    {
        $owner = User::factory()->create();
        $order = $this->seedOrder($owner);

        $this->actingAs(User::factory()->create())
            ->get(route('account.orders.show', $order))
            ->assertForbidden();
    }

    public function test_orders_lists_only_current_users_orders(): void
    {
        $owner = User::factory()->create();
        $ownOrder = $this->seedOrder($owner);
        $foreignOrder = $this->seedOrder(User::factory()->create());

        $this->actingAs($owner)
            ->get(route('account.orders'))
            ->assertOk()
            ->assertSee($ownOrder->code)
            ->assertDontSee($foreignOrder->code);
    }

    public function test_builds_lists_only_current_users_builds(): void
    {
        $owner = User::factory()->create();
        $ownBuild = $this->seedBuild($owner);
        $this->seedBuild(User::factory()->create());

        $this->actingAs($owner)
            ->get(route('account.builds'))
            ->assertOk()
            ->assertSee($ownBuild->code);
    }
}
