<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CartService
{
    public static function shippingCost(string $shippingMethod): int
    {
        if ($shippingMethod === 'pickup') {
            return 0;
        }

        return (int) (Setting::get('shipping_cost', '15000') ?: 15000);
    }

    public static function current(): Cart
    {
        $user = auth()->user();
        $sessionId = session()->getId();

        $cart = Cart::query()
            ->when($user, fn ($q) => $q->where('user_id', $user->id), fn ($q) => $q->where('session_id', $sessionId)->whereNull('user_id'))
            ->first();

        if (! $cart) {
            $cart = Cart::query()->create([
                'session_id' => $user ? null : $sessionId,
                'user_id' => $user?->id,
            ]);
        }

        return $cart;
    }

    public static function count(): int
    {
        $user = auth()->user();
        $sessionId = session()->getId();

        $cart = Cart::query()
            ->when($user, fn ($q) => $q->where('user_id', $user->id), fn ($q) => $q->where('session_id', $sessionId)->whereNull('user_id'))
            ->first();

        if (! $cart) {
            return 0;
        }

        return (int) $cart->items()->sum('quantity');
    }

    public static function addProduct(Product $product, int $quantity = 1): void
    {
        $cart = self::current();

        $item = CartItem::query()->firstOrNew([
            'cart_id' => $cart->id,
            'item_type' => 'product',
            'product_id' => $product->id,
        ]);

        $item->quantity = ($item->exists ? $item->quantity : 0) + max(1, $quantity);
        $item->save();
    }

    public static function addBuild(int $pcBuildId): void
    {
        $cart = self::current();

        CartItem::query()->firstOrCreate([
            'cart_id' => $cart->id,
            'item_type' => 'build',
            'pc_build_id' => $pcBuildId,
        ], ['quantity' => 1]);
    }

    public static function removeItem(int $itemId): void
    {
        CartItem::query()->where('cart_id', self::current()->id)->where('id', $itemId)->delete();
    }

    public static function updateQuantity(int $itemId, int $quantity): void
    {
        $item = CartItem::query()->where('cart_id', self::current()->id)->findOrFail($itemId);

        if ($quantity <= 0) {
            $item->delete();

            return;
        }

        $item->update(['quantity' => $quantity]);
    }

    public static function itemsWithDetails()
    {
        return self::current()->items()->with([
            'product.images',
            'product.inventory',
            'build.items.product',
        ])->get();
    }

    public static function subtotal(): int
    {
        $total = 0;

        foreach (self::itemsWithDetails() as $item) {
            $total += self::itemPrice($item) * $item->quantity;
        }

        return $total;
    }

    public static function itemPrice(CartItem $item): int
    {
        if ($item->item_type === 'product') {
            return (int) ($item->product?->price ?? 0);
        }

        if ($item->item_type === 'build' && $item->build) {
            return (int) $item->build->items->sum('price');
        }

        return 0;
    }

    public static function checkout(array $data, ?User $user): Order
    {
        return DB::transaction(function () use ($data, $user) {
            $items = [];

            foreach (self::itemsWithDetails() as $cartItem) {
                if ($cartItem->item_type === 'product' && $cartItem->product) {
                    $items[] = [
                        'product_id' => $cartItem->product_id,
                        'name' => $cartItem->product->name,
                        'quantity' => $cartItem->quantity,
                    ];
                } elseif ($cartItem->item_type === 'build' && $cartItem->build) {
                    $buildTotal = self::itemPrice($cartItem);
                    $items[] = [
                        'item_type' => 'build',
                        'name' => 'PC Build '.$cartItem->build->code,
                        'price' => $buildTotal,
                        'quantity' => 1,
                    ];
                }
            }

            if (empty($items)) {
                throw new \DomainException('Cart kosong.');
            }

            $order = OrderService::createManual(
                array_merge($data, ['channel' => 'website', 'user_id' => $user?->id]),
                $items,
                $user
            );

            if ($data['pc_build_id'] ?? null) {
                $order->update(['pc_build_id' => $data['pc_build_id'], 'type' => 'pc_build']);
            }

            self::current()->items()->delete();

            return $order;
        });
    }
}
