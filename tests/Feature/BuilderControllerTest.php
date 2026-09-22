<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\PcBuild;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BuilderControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_page_loads(): void
    {
        $this->get(route('builder.index'))
            ->assertOk()
            ->assertViewHas('purposes', PcBuild::PURPOSES)
            ->assertViewHas('slots', PcBuild::SLOTS);
    }

    public function test_components_returns_active_products_for_valid_slot(): void
    {
        $category = Category::factory()->create(['slug' => 'cpu', 'name' => 'CPU']);
        $product = Product::factory()->create(['category_id' => $category->id, 'price' => 1500000, 'is_active' => true]);
        Product::factory()->inactive()->create(['category_id' => $category->id, 'price' => 2000000]);

        $this->getJson(route('builder.components', 'cpu'))
            ->assertOk()
            ->assertJsonPath('slot', 'cpu')
            ->assertJsonCount(1, 'products')
            ->assertJsonPath('products.0.id', $product->id)
            ->assertJsonPath('products.0.price', 1500000);
    }

    public function test_components_filters_by_search_query(): void
    {
        $category = Category::factory()->create(['slug' => 'cpu', 'name' => 'CPU']);
        Product::factory()->create(['category_id' => $category->id, 'name' => 'AMD Ryzen 5']);
        Product::factory()->create(['category_id' => $category->id, 'name' => 'Intel Core i5']);

        $this->getJson(route('builder.components', ['slot' => 'cpu', 'q' => 'AMD']))
            ->assertOk()
            ->assertJsonCount(1, 'products')
            ->assertJsonPath('products.0.name', 'AMD Ryzen 5');
    }

    public function test_components_returns_404_for_invalid_slot(): void
    {
        $this->getJson(route('builder.components', 'keyboard'))
            ->assertNotFound()
            ->assertJsonPath('error', 'Invalid slot');
    }

    public function test_check_returns_compatibility_power_and_total(): void
    {
        $category = Category::factory()->create(['slug' => 'cpu', 'name' => 'CPU']);
        $product = Product::factory()->create(['category_id' => $category->id, 'price' => 2200000]);

        $this->getJson(route('builder.check', ['items' => ['cpu' => $product->id]]))
            ->assertOk()
            ->assertJsonPath('total', 2200000)
            ->assertJsonStructure(['compatibility', 'power', 'recommended_psu', 'total']);
    }

    public function test_save_requires_authentication(): void
    {
        $this->postJson(route('builder.save'), ['items' => []])
            ->assertUnauthorized();
    }

    public function test_authenticated_user_can_save_build(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create(['slug' => 'cpu', 'name' => 'CPU']);
        $product = Product::factory()->create(['category_id' => $category->id, 'price' => 1500000]);

        $response = $this->actingAs($user)->postJson(route('builder.save'), [
            'name' => 'Rakit Gaming Saya',
            'purpose' => 'gaming',
            'budget' => 10000000,
            'items' => [
                ['slot' => 'cpu', 'product_id' => $product->id],
            ],
        ]);

        $response->assertOk()
            ->assertJsonStructure(['code', 'share_token', 'total_price'])
            ->assertJsonPath('total_price', 1500000);

        $this->assertDatabaseHas('pc_builds', [
            'user_id' => $user->id,
            'name' => 'Rakit Gaming Saya',
            'purpose' => 'gaming',
            'budget' => 10000000,
            'total_price' => 1500000,
        ]);
        $this->assertDatabaseCount('pc_build_items', 1);
    }

    public function test_cannot_save_using_other_users_build(): void
    {
        $owner = User::factory()->create();
        $intruder = User::factory()->create();
        $build = PcBuild::query()->create([
            'code' => PcBuild::generateCode(),
            'user_id' => $owner->id,
            'name' => 'Milik Owner',
            'status' => 'draft',
            'share_token' => bin2hex(random_bytes(12)),
        ]);

        $category = Category::factory()->create(['slug' => 'cpu', 'name' => 'CPU']);
        $product = Product::factory()->create(['category_id' => $category->id, 'price' => 1000000]);

        $this->actingAs($intruder)
            ->postJson(route('builder.save'), [
                'build_id' => $build->id,
                'items' => [
                    ['slot' => 'cpu', 'product_id' => $product->id],
                ],
            ])
            ->assertNotFound();

        $this->assertDatabaseCount('pc_build_items', 0);
    }

    public function test_add_to_cart_requires_own_build(): void
    {
        $owner = User::factory()->create();
        $build = PcBuild::query()->create([
            'code' => PcBuild::generateCode(),
            'user_id' => $owner->id,
            'status' => 'draft',
            'share_token' => bin2hex(random_bytes(12)),
        ]);

        $this->actingAs(User::factory()->create())
            ->postJson(route('builder.add-to-cart'), ['build_id' => $build->id])
            ->assertNotFound();
    }

    public function test_show_returns_404_for_unknown_share_token(): void
    {
        $this->get(route('builder.show', 'tidak-ada'))
            ->assertNotFound();
    }
}
