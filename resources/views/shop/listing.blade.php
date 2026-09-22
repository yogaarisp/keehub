@extends('layouts.storefront')

@section('title', ($activeCategory?->meta_title) ?: ($activeCategory?->name ? $activeCategory->name.' — KeeHub Shop' : 'Shop — KeeHub'))

@section('meta_description', $activeCategory?->meta_description ?: 'Belanja PC parts di KeeHub: CPU, GPU, Motherboard, RAM, SSD, PSU, dan aksesoris lainnya.')

@section('content')
<div class="x-container py-8">
    <nav class="mb-4 text-sm text-gray-500 dark:text-gray-400">
        <a href="{{ route('home') }}" class="hover:text-kee-600">Home</a>
        <span class="mx-1.5">/</span>
        <a href="{{ route('shop.index') }}" class="hover:text-kee-600">Shop</a>
        @if ($activeCategory)
            <span class="mx-1.5">/</span>
            <span class="font-medium text-gray-900 dark:text-white">{{ $activeCategory->name }}</span>
        @endif
    </nav>

    <div class="grid gap-6 lg:grid-cols-[16rem_1fr]">
        {{-- Sidebar filters (desktop) --}}
        <aside class="hidden lg:block">
            <form id="filter-form" method="GET" action="{{ route('shop.index') }}" class="space-y-6">
                <div class="x-card p-4">
                    <h3 class="mb-3 text-sm font-bold uppercase tracking-wide text-gray-500">Cari</h3>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari produk / SKU..." class="x-input !py-2 text-sm">
                </div>

                <div class="x-card p-4">
                    <h3 class="mb-3 text-sm font-bold uppercase tracking-wide text-gray-500">Kategori</h3>
                    <div class="space-y-1.5">
                        <label class="flex items-center gap-2 text-sm">
                            <input type="radio" name="category" value="" @checked(! request('category')) class="text-kee-600 focus:ring-kee-500">
                            <span class="text-gray-700 dark:text-gray-300">Semua</span>
                        </label>
                        @foreach ($categories as $category)
                            <label class="flex items-center gap-2 text-sm">
                                <input type="radio" name="category" value="{{ $category->slug }}" @checked(request('category') === $category->slug) class="text-kee-600 focus:ring-kee-500">
                                <span class="text-gray-700 dark:text-gray-300">{{ $category->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="x-card p-4">
                    <h3 class="mb-3 text-sm font-bold uppercase tracking-wide text-gray-500">Brand</h3>
                    <div class="max-h-52 space-y-1.5 overflow-y-auto">
                        @foreach ($brands as $brand)
                            <label class="flex items-center gap-2 text-sm">
                                <input type="checkbox" name="brand[]" value="{{ $brand->slug }}" @checked(in_array($brand->slug, (array) request('brand'))) class="rounded text-kee-600 focus:ring-kee-500">
                                <span class="text-gray-700 dark:text-gray-300">{{ $brand->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="x-card p-4">
                    <h3 class="mb-3 text-sm font-bold uppercase tracking-wide text-gray-500">Harga</h3>
                    <div class="flex items-center gap-2">
                        <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="x-input !py-2 text-sm" min="0">
                        <span class="text-gray-400">—</span>
                        <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" class="x-input !py-2 text-sm" min="0">
                    </div>
                </div>

                <div class="x-card p-4">
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="availability" value="in_stock" @checked(request('availability') === 'in_stock') class="rounded text-kee-600 focus:ring-kee-500">
                        <span class="text-gray-700 dark:text-gray-300">Hanya stok tersedia</span>
                    </label>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="x-btn-primary flex-1">Terapkan</button>
                    <a href="{{ route('shop.index') }}" class="x-btn-outline">Reset</a>
                </div>
            </form>
        </aside>

        {{-- Products --}}
        <div>
            <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $products->total() }} produk</p>
                <form method="GET" action="{{ route('shop.index') }}" class="flex items-center gap-2" id="sort-form">
                    @foreach (request()->except('sort', 'page') as $key => $value)
                        @if (is_array($value))
                            @foreach ($value as $v)
                                <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                            @endforeach
                        @else
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach
                    <select name="sort" onchange="document.getElementById('sort-form').submit()" class="x-input !w-auto !py-2 text-sm">
                        <option value="newest" @selected(request('sort') === 'newest')>Terbaru</option>
                        <option value="best_seller" @selected(request('sort') === 'best_seller')>Best Seller</option>
                        <option value="price_asc" @selected(request('sort') === 'price_asc')>Harga Terendah</option>
                        <option value="price_desc" @selected(request('sort') === 'price_desc')>Harga Tertinggi</option>
                    </select>
                </form>
            </div>

            {{-- Mobile filter toggle --}}
            <div class="mb-4 lg:hidden" x-data="{ open: false }">
                <button x-on:click="open = !open" class="x-btn-outline w-full">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                    Filter & Pencarian
                </button>
                <div x-show="open" x-collapse x-cloak class="mt-3 space-y-4">
                    @include('shop.partials.filter-body')
                </div>
            </div>

            @if ($products->isEmpty())
                <div class="x-card flex flex-col items-center gap-3 p-16 text-center">
                    <span class="text-4xl">🔍</span>
                    <p class="font-semibold text-gray-900 dark:text-white">Produk tidak ditemukan</p>
                    <p class="text-sm text-gray-500">Coba ubah filter atau kata kunci pencarian.</p>
                </div>
            @else
                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 xl:grid-cols-4">
                    @foreach ($products as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
                <div class="mt-6">{{ $products->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
