<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShopControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_shop_listing_renders_with_category_price_and_stock_filters(): void
    {
        $cpu = Category::factory()->create(['name' => 'Processor', 'slug' => 'processor', 'is_active' => true]);
        $gpu = Category::factory()->create(['name' => 'Kartu Grafis', 'slug' => 'gpu', 'is_active' => true]);
        $brand = Brand::factory()->create(['name' => 'AMD', 'slug' => 'amd', 'is_active' => true]);

        $ryzen = Product::factory()->create([
            'category_id' => $cpu->id,
            'brand_id' => $brand->id,
            'name' => 'AMD Ryzen 5 5600',
            'price' => 1850000,
            'is_active' => true,
        ]);
        Inventory::query()->updateOrCreate(['product_id' => $ryzen->id], ['current_stock' => 5, 'min_stock' => 2]);

        $rtx = Product::factory()->create([
            'category_id' => $gpu->id,
            'brand_id' => $brand->id,
            'name' => 'RTX 4060 Dual',
            'price' => 4500000,
            'is_active' => true,
        ]);
        Inventory::query()->updateOrCreate(['product_id' => $rtx->id], ['current_stock' => 0, 'min_stock' => 1]);

        $this->get(route('shop.index'))
            ->assertSuccessful()
            ->assertSee('Katalog Produk')
            ->assertSee('AMD Ryzen 5 5600')
            ->assertSee('RTX 4060 Dual');

        $this->get(route('shop.index', [
            'category' => $cpu->slug,
            'availability' => 'in_stock',
            'min_price' => 1000000,
            'max_price' => 2000000,
        ]))
            ->assertSuccessful()
            ->assertSee('AMD Ryzen 5 5600')
            ->assertDontSee('RTX 4060 Dual')
            ->assertSee('filter aktif');

        $this->get(route('shop.index', ['q' => 'produk-tidak-ada-xyz']))
            ->assertSuccessful()
            ->assertSee('Produk tidak ditemukan');
    }

    public function test_product_detail_page_renders_product_and_related_items(): void
    {
        $cpu = Category::factory()->create(['name' => 'Processor', 'slug' => 'processor', 'is_active' => true]);
        $brand = Brand::factory()->create(['name' => 'AMD', 'slug' => 'amd', 'is_active' => true]);

        $primary = Product::factory()->create([
            'category_id' => $cpu->id,
            'brand_id' => $brand->id,
            'name' => 'AMD Ryzen 5 5600',
            'slug' => 'amd-ryzen-5-5600',
            'price' => 1850000,
            'is_active' => true,
        ]);
        Inventory::query()->updateOrCreate(['product_id' => $primary->id], ['current_stock' => 5, 'min_stock' => 2]);

        $related = Product::factory()->create([
            'category_id' => $cpu->id,
            'brand_id' => $brand->id,
            'name' => 'AMD Ryzen 7 5700X',
            'slug' => 'amd-ryzen-7-5700x',
            'price' => 2750000,
            'is_active' => true,
        ]);

        $this->get(route('shop.show', $primary->slug))
            ->assertSuccessful()
            ->assertSee('AMD Ryzen 5 5600')
            ->assertSee('+ Keranjang')
            ->assertSee('Beli Sekarang')
            ->assertSee('Produk Serupa')
            ->assertSee('AMD Ryzen 7 5700X');
    }
}
