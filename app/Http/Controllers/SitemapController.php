<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $products = Product::query()->active()->get(['slug', 'updated_at']);
        $categories = Category::query()->where('is_active', true)->get(['slug', 'updated_at']);

        $urls = collect([['loc' => url('/'), 'priority' => '1.0'], ['loc' => url('/shop'), 'priority' => '0.9'], ['loc' => url('/pc-builder'), 'priority' => '0.9'], ['loc' => url('/pc-rakitan'), 'priority' => '0.8'], ['loc' => url('/service'), 'priority' => '0.8']])
            ->merge($products->map(fn ($p) => ['loc' => url('/produk/'.$p->slug), 'lastmod' => $p->updated_at->toAtomString(), 'priority' => '0.8']))
            ->merge($categories->map(fn ($c) => ['loc' => url('/shop?category='.$c->slug), 'priority' => '0.6']));

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n".'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
        foreach ($urls as $u) {
            $xml .= "  <url>\n    <loc>{$u['loc']}</loc>\n".(isset($u['lastmod']) ? "    <lastmod>{$u['lastmod']}</lastmod>\n" : '')."    <priority>{$u['priority']}</priority>\n  </url>\n";
        }
        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }
}
