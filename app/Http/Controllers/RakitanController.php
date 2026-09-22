<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class RakitanController extends Controller
{
    public function index(): View
    {
        $categories = [
            ['slug' => 'gaming', 'name' => 'Gaming PC', 'desc' => 'Dibangun untuk 1080p hingga 4K gaming'],
            ['slug' => 'office', 'name' => 'Office PC', 'desc' => 'Hemat daya, senyap, untuk produktivitas harian'],
            ['slug' => 'editing', 'name' => 'Editing PC', 'desc' => 'Render video & desain grafis tanpa bottleneck'],
            ['slug' => 'streaming', 'name' => 'Streaming PC', 'desc' => 'Stream + gaming serentak, encoding stabil'],
            ['slug' => 'budget', 'name' => 'Budget PC', 'desc' => 'Performa terbaik di harga semurah mungkin'],
            ['slug' => 'high-end', 'name' => 'High-End PC', 'desc' => 'Spesifikasi dewa untuk segala kebutuhan'],
        ];

        // Paket PC rakitan dari kombinasi produk best seller
        $packages = collect([
            ['name' => 'KeeHub Budget Build', 'desc' => 'Ryzen 5 5600 + RTX 3050 — gaming 1080p esport & AAA light', 'purpose' => 'gaming'],
            ['name' => 'KeeHub Gaming 1080p', 'desc' => 'Ryzen 5 5600 + RTX 4060 — 1080p ultra ray tracing', 'purpose' => 'gaming'],
            ['name' => 'KeeHub Office Slim', 'desc' => 'Office setup hemat listrik untuk kerja & sekolah', 'purpose' => 'office'],
        ]);

        return view('shop.rakitan', [
            'categories' => $categories,
            'packages' => $packages,
            'featured' => Product::query()->active()->with(['brand', 'images', 'inventory'])->orderByDesc('sold_count')->limit(4)->get(),
        ]);
    }
}
