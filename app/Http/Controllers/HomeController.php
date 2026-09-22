<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        return view('shop.index', [
            'categories' => Category::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'bestSellers' => Product::query()->active()->with(['brand', 'category', 'images', 'inventory'])->orderByDesc('sold_count')->limit(8)->get(),
            'newest' => Product::query()->active()->with(['brand', 'category', 'images', 'inventory'])->orderByDesc('created_at')->limit(8)->get(),
        ]);
    }
}
