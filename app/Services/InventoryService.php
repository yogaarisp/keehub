<?php

namespace App\Services;

use App\Models\Inventory;
use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;

class InventoryService
{
    public static function move(
        Product $product,
        string $type,
        int $quantity,
        ?string $referenceType = null,
        ?int $referenceId = null,
        ?string $notes = null,
        ?int $userId = null
    ): StockMovement {
        if (! in_array($type, StockMovement::TYPES, true)) {
            throw new \InvalidArgumentException("Invalid movement type: {$type}");
        }

        return DB::transaction(function () use ($product, $type, $quantity, $referenceType, $referenceId, $notes, $userId) {
            $inventory = Inventory::query()->where('product_id', $product->id)->lockForUpdate()->first();

            if (! $inventory) {
                $inventory = Inventory::query()->create([
                    'product_id' => $product->id,
                    'current_stock' => 0,
                    'min_stock' => 0,
                ]);
            }

            $before = $inventory->current_stock;

            $delta = match ($type) {
                'in' => abs($quantity),
                'out' => -abs($quantity),
                'adjustment' => $quantity,
                'reversal' => abs($quantity),
            };

            $after = $before + $delta;

            if ($after < 0) {
                throw new \DomainException("Insufficient stock for product [{$product->sku}]. Available: {$before}, requested: ".abs($delta).'.');
            }

            $inventory->current_stock = $after;
            $inventory->save();

            return StockMovement::query()->create([
                'product_id' => $product->id,
                'type' => $type,
                'quantity' => $delta,
                'stock_before' => $before,
                'stock_after' => $after,
                'reference_type' => $referenceType,
                'reference_id' => $referenceId,
                'user_id' => $userId,
                'notes' => $notes,
            ]);
        });
    }

    public static function reverseMovementsFor(string $referenceType, int $referenceId, ?int $userId = null, ?string $notes = null): void
    {
        $movements = StockMovement::query()
            ->where('reference_type', $referenceType)
            ->where('reference_id', $referenceId)
            ->where('type', 'out')
            ->get();

        foreach ($movements as $movement) {
            $product = Product::query()->findOrFail($movement->product_id);
            static::move(
                $product,
                'reversal',
                abs($movement->quantity),
                $referenceType,
                $referenceId,
                $notes ?? 'Stock reversal for '.$referenceType.'#'.$referenceId,
                $userId
            );
        }
    }

    public static function lowStockProducts()
    {
        return Inventory::query()
            ->with('product')
            ->whereColumn('current_stock', '<=', 'min_stock')
            ->get();
    }
}
