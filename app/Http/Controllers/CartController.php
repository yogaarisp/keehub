<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        return view('shop.cart', [
            'items' => CartService::itemsWithDetails(),
            'subtotal' => CartService::subtotal(),
        ]);
    }

    public function add(int $productId): RedirectResponse
    {
        $product = Product::query()->where('is_active', true)->findOrFail($productId);

        CartService::addProduct($product);

        return redirect()->route('cart.index')->with('success', 'Produk ditambahkan ke cart.');
    }

    public function buyNow(int $productId): RedirectResponse
    {
        $product = Product::query()->where('is_active', true)->findOrFail($productId);

        CartService::addProduct($product);

        return redirect()->route('checkout.index');
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'item_id' => ['required', 'integer'],
            'quantity' => ['required', 'integer', 'min:0'],
        ]);

        CartService::updateQuantity($validated['item_id'], $validated['quantity']);

        return back()->with('success', 'Cart diperbarui.');
    }

    public function remove(Request $request): RedirectResponse
    {
        $validated = $request->validate(['item_id' => ['required', 'integer']]);

        CartService::removeItem($validated['item_id']);

        return back()->with('success', 'Item dihapus dari cart.');
    }
}
