<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::query()->where('is_active', true)->orderBy('sort_order')->get();
        $brands = Brand::query()->where('is_active', true)->orderBy('name')->get();

        $products = Product::query()
            ->active()
            ->with(['brand', 'category', 'images', 'inventory'])
            ->when($request->filled('category'), fn ($q) => $q->whereHas('category', fn ($c) => $c->where('slug', $request->category)))
            ->when($request->filled('brand'), fn ($q) => $q->whereHas('brand', fn ($b) => $b->whereIn('slug', (array) $request->brand)))
            ->when($request->filled('q'), fn ($q) => $q->where(fn ($w) => $w->where('name', 'like', '%'.$request->q.'%')->orWhere('sku', 'like', '%'.$request->q.'%')))
            ->when($request->filled('min_price'), fn ($q) => $q->where('price', '>=', (int) $request->min_price))
            ->when($request->filled('max_price'), fn ($q) => $q->where('price', '<=', (int) $request->max_price))
            ->when($request->availability === 'in_stock', fn ($q) => $q->whereHas('inventory', fn ($i) => $i->where('current_stock', '>', 0)))
            ->when($request->sort === 'price_asc', fn ($q) => $q->orderBy('price'))
            ->when($request->sort === 'price_desc', fn ($q) => $q->orderByDesc('price'))
            ->when($request->sort === 'best_seller', fn ($q) => $q->orderByDesc('sold_count'))
            ->when(in_array($request->sort, [null, '', 'newest'], true), fn ($q) => $q->orderByDesc('created_at'))
            ->paginate(12)
            ->withQueryString();

        $activeCategory = $categories->firstWhere('slug', $request->category);

        return view('shop.listing', [
            'categories' => $categories,
            'brands' => $brands,
            'products' => $products,
            'activeCategory' => $activeCategory,
        ]);
    }

    public function show(string $slug): View
    {
        $product = Product::query()
            ->active()
            ->with(['brand', 'category', 'images', 'inventory', 'specs'])
            ->where('slug', $slug)
            ->firstOrFail();

        $product->increment('view_count');

        $related = Product::query()
            ->active()
            ->with(['brand', 'images', 'inventory'])
            ->where('category_id', $product->category_id)
            ->whereKeyNot($product->id)
            ->limit(4)
            ->get();

        return view('shop.detail', [
            'product' => $product,
            'related' => $related,
        ]);
    }
}
