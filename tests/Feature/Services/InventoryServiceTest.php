<?php

namespace Tests\Feature\Services;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\StockMovement;
use App\Services\InventoryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_move_in_increases_stock(): void
    {
        $product = Product::factory()->withInventory(5)->create();

        InventoryService::move($product, 'in', 3, null, null, 'Restock');

        $this->assertSame(8, $product->inventory->fresh()->current_stock);

        $movement = StockMovement::query()->first();
        $this->assertSame('in', $movement->type);
        $this->assertSame(3, $movement->quantity);
        $this->assertSame(5, $movement->stock_before);
        $this->assertSame(8, $movement->stock_after);
        $this->assertSame('Restock', $movement->notes);
    }

    public function test_move_out_decreases_stock(): void
    {
        $product = Product::factory()->withInventory(10)->create();

        InventoryService::move($product, 'out', 4, null, null, 'Sale');

        $this->assertSame(6, $product->inventory->fresh()->current_stock);

        $movement = StockMovement::query()->first();
        $this->assertSame('out', $movement->type);
        $this->assertSame(-4, $movement->quantity);
        $this->assertSame(10, $movement->stock_before);
        $this->assertSame(6, $movement->stock_after);
    }

    public function test_insufficient_stock_is_rejected_and_stock_is_unchanged(): void
    {
        $product = Product::factory()->withInventory(2)->create();

        try {
            InventoryService::move($product, 'out', 5);
            $this->fail('Expected DomainException was not thrown.');
        } catch (\DomainException $e) {
            $this->assertStringContainsString('Insufficient stock', $e->getMessage());
        }

        $this->assertSame(2, $product->inventory->fresh()->current_stock);
        $this->assertCount(0, StockMovement::query()->get());
    }

    public function test_move_creates_inventory_row_when_missing(): void
    {
        $product = Product::factory()->create();

        InventoryService::move($product, 'in', 7);

        $inventory = Inventory::query()->where('product_id', $product->id)->first();
        $this->assertNotNull($inventory);
        $this->assertSame(7, $inventory->current_stock);
    }

    public function test_invalid_movement_type_is_rejected(): void
    {
        $product = Product::factory()->create();

        $this->expectException(\InvalidArgumentException::class);

        InventoryService::move($product, 'banana', 1);
    }

    public function test_reverse_movements_restores_stock(): void
    {
        $product = Product::factory()->withInventory(10)->create();

        InventoryService::move($product, 'out', 4, Product::class, 99, 'Order');

        InventoryService::reverseMovementsFor(Product::class, 99);

        $this->assertSame(10, $product->inventory->fresh()->current_stock);
        $this->assertSame(1, StockMovement::query()->where('type', 'out')->count());
        $this->assertSame(1, StockMovement::query()->where('type', 'reversal')->count());
    }

    public function test_low_stock_returns_products_at_or_below_minimum(): void
    {
        $healthy = Product::factory()->withInventory(20, 5)->create();
        $low = Product::factory()->withInventory(3, 5)->create();

        $lowStock = InventoryService::lowStockProducts();

        $this->assertCount(1, $lowStock);
        $this->assertSame($low->id, $lowStock->first()->product_id);
        $this->assertNotSame($healthy->id, $lowStock->first()->product_id);
    }
}
