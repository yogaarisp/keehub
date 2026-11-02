<?php

namespace Tests\Feature;

use App\Filament\Resources\ProductResource;
use App\Filament\Resources\ProductResource\Pages\CreateProduct;
use App\Filament\Resources\ProductResource\Pages\ListProducts;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class ProductResourceTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'owner']);
    }

    public function test_can_render_product_list_page(): void
    {
        $products = Product::factory()->count(2)->create();

        ProductImage::create([
            'product_id' => $products->first()->id,
            'path' => 'products/sample-test.jpg',
            'is_primary' => true,
            'sort_order' => 0,
        ]);

        $this->actingAs($this->admin)
            ->get(ProductResource::getUrl('index'))
            ->assertOk();

        Livewire::actingAs($this->admin)
            ->test(ListProducts::class)
            ->assertCanSeeTableRecords($products);
    }

    public function test_can_manage_product_images_action(): void
    {
        $product = Product::factory()->create();

        Livewire::actingAs($this->admin)
            ->test(ListProducts::class)
            ->callTableAction('manage_images', $product, data: [
                'images_upload' => ['products/custom-photo-1.jpg', 'products/custom-photo-2.jpg'],
            ])
            ->assertHasNoTableActionErrors();

        $this->assertDatabaseHas('product_images', [
            'product_id' => $product->id,
            'path' => 'products/custom-photo-1.jpg',
            'is_primary' => true,
            'sort_order' => 0,
        ]);

        $this->assertDatabaseHas('product_images', [
            'product_id' => $product->id,
            'path' => 'products/custom-photo-2.jpg',
            'is_primary' => false,
            'sort_order' => 1,
        ]);
    }

    public function test_can_create_product_with_image_upload(): void
    {
        Storage::fake('public');

        $category = Category::factory()->create();
        $brand = Brand::factory()->create();
        $file = UploadedFile::fake()->image('test-gpu.jpg');

        Livewire::actingAs($this->admin)
            ->test(CreateProduct::class)
            ->fillForm([
                'sku' => 'GPU-TEST-001',
                'name' => 'GeForce RTX 4070 Test Edition',
                'slug' => 'geforce-rtx-4070-test-edition',
                'category_id' => $category->id,
                'brand_id' => $brand->id,
                'price' => 9500000,
                'cost_price' => 8800000,
                'images_upload' => [$file],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('products', [
            'sku' => 'GPU-TEST-001',
            'name' => 'GeForce RTX 4070 Test Edition',
        ]);

        $product = Product::where('sku', 'GPU-TEST-001')->first();
        $this->assertNotNull($product);
        $this->assertCount(1, $product->images);
    }
}
