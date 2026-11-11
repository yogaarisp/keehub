@extends('layouts.storefront')

@section('title', ($activeCategory?->meta_title) ?: ($activeCategory?->name ? $activeCategory->name.' — KeeHub Shop' : 'Shop — KeeHub'))

@section('meta_description', $activeCategory?->meta_description ?: 'Belanja PC parts di KeeHub: CPU, GPU, Motherboard, RAM, SSD, PSU, dan aksesoris lainnya.')

@php
    $activeFiltersCount = collect([
        request()->filled('q'),
        request()->filled('category'),
        ! empty((array) request('brand')),
        request()->filled('min_price'),
        request()->filled('max_price'),
        request('availability') === 'in_stock',
    ])->filter()->count();
@endphp

@section('content')
<div class="x-container py-6 sm:py-8"
     x-data="{ filterOpen: false }"
     x-effect="document.body.classList.toggle('overflow-hidden', filterOpen)"
     x-on:keydown.escape.window="filterOpen = false">
    {{-- Breadcrumb & Header --}}
    <div class="mb-5 border-b border-slate-100 pb-5 dark:border-slate-800">
        <nav class="mb-2 flex flex-wrap items-center gap-1.5 text-xs text-slate-500 sm:text-sm dark:text-slate-400">
            <a href="{{ route('home') }}" class="hover:text-amber-600 dark:hover:text-amber-400">Home</a>
            <span>/</span>
            <a href="{{ route('shop.index') }}" class="hover:text-amber-600 dark:hover:text-amber-400">Shop</a>
            @if ($activeCategory)
                <span>/</span>
                <span class="font-medium text-slate-900 dark:text-white">{{ $activeCategory->name }}</span>
            @endif
        </nav>

        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl dark:text-slate-100">
                    {{ $activeCategory?->name ?? 'Katalog Produk' }}
                </h1>
                <p class="mt-1 text-xs text-slate-500 sm:text-sm dark:text-slate-400">
                    {{ $activeCategory?->description ?: 'Temukan komponen PC original, hardware rakitan, dan perlengkapan pilihan KeeHub.' }}
                </p>
            </div>
            @if ($activeFiltersCount > 0)
                <a href="{{ route('shop.index') }}"
                   class="inline-flex w-fit items-center gap-1.5 rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700 ring-1 ring-amber-600/20 transition hover:bg-amber-100 dark:bg-amber-950/50 dark:text-amber-300 dark:ring-amber-500/30">
                    <span>{{ $activeFiltersCount }} filter aktif</span>
                    <span>• Reset</span>
                </a>
            @endif
        </div>

        {{-- Quick Category Chips --}}
        <div class="mt-4 flex gap-2 overflow-x-auto pb-1">
            <a href="{{ route('shop.index', request()->except('category', 'page')) }}"
               class="shrink-0 rounded-full px-3.5 py-1.5 text-xs font-medium transition {{ ! request('category') ? 'bg-amber-600 text-white shadow-sm shadow-amber-600/20' : 'bg-slate-100 text-slate-700 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700' }}">
                Semua
            </a>
            @foreach ($categories as $category)
                <a href="{{ route('shop.index', array_merge(request()->except('page'), ['category' => $category->slug])) }}"
                   class="shrink-0 rounded-full px-3.5 py-1.5 text-xs font-medium transition {{ request('category') === $category->slug ? 'bg-amber-600 text-white shadow-sm shadow-amber-600/20' : 'bg-slate-100 text-slate-700 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-[17rem_1fr]">
        {{-- Sidebar filters (desktop) --}}
        <aside class="hidden lg:block">
            <div class="sticky top-24">
                @include('shop.partials.filter-body', ['formId' => 'filter-form-desktop'])
            </div>
        </aside>

        {{-- Products --}}
        <div class="min-w-0">
            {{-- Toolbar --}}
            <div class="x-card mb-4 flex flex-wrap items-center justify-between gap-2.5 p-3 sm:mb-5 sm:p-4">
                <div class="flex items-center gap-2">
                    <button type="button"
                            x-on:click="filterOpen = true"
                            class="inline-flex items-center gap-1.5 rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-50 lg:hidden dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200">
                        <svg class="h-4 w-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                        <span>Filter</span>
                        @if ($activeFiltersCount > 0)
                            <span class="flex h-4 min-w-[1rem] items-center justify-center rounded-full bg-amber-600 px-1 text-[10px] font-bold text-white">{{ $activeFiltersCount }}</span>
                        @endif
                    </button>

                    <p class="text-xs text-slate-500 sm:text-sm dark:text-slate-400">
                        <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $products->total() }}</span> produk
                    </p>
                </div>

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
                    <label for="shop-sort-select" class="hidden text-xs font-medium text-slate-500 sm:inline dark:text-slate-400">Urutkan:</label>
                    <select id="shop-sort-select" name="sort" onchange="document.getElementById('sort-form').submit()" class="x-input !w-auto !py-1.5 text-xs sm:!py-2 sm:text-sm">
                        <option value="newest" @selected(request('sort') === 'newest')>Terbaru</option>
                        <option value="best_seller" @selected(request('sort') === 'best_seller')>Best Seller</option>
                        <option value="price_asc" @selected(request('sort') === 'price_asc')>Harga Terendah</option>
                        <option value="price_desc" @selected(request('sort') === 'price_desc')>Harga Tertinggi</option>
                    </select>
                </form>
            </div>

            @if ($products->isEmpty())
                <div class="x-card flex flex-col items-center gap-3 px-6 py-14 text-center sm:p-16">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800 dark:text-slate-500">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </div>
                    <p class="text-base font-semibold text-slate-900 dark:text-white">Produk tidak ditemukan</p>
                    <p class="max-w-sm text-xs text-slate-500 sm:text-sm dark:text-slate-400">Coba ubah filter kategori, rentang harga, atau kata kunci pencarian kamu.</p>
                    <a href="{{ route('shop.index') }}" class="x-btn-primary mt-1">Reset Semua Filter</a>
                </div>
            @else
                <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 sm:gap-4 xl:grid-cols-4">
                    @foreach ($products as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
                <div class="mt-6">{{ $products->links() }}</div>
            @endif
        </div>
    </div>

    {{-- Mobile Filter Drawer / Bottom Sheet --}}
    <div x-show="filterOpen" x-cloak class="fixed inset-0 z-[60] overflow-hidden lg:hidden" role="dialog" aria-modal="true">
        <div x-show="filterOpen"
             x-transition:enter="transition-opacity ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             x-on:click="filterOpen = false"
             class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm"></div>

        <div class="relative flex h-full items-end justify-center pointer-events-none sm:items-center sm:p-4">
            <div x-show="filterOpen"
                 x-transition:enter="transition ease-out duration-250"
                 x-transition:enter-start="opacity-0 translate-y-full sm:translate-y-4 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-full sm:translate-y-4 sm:scale-95"
                 class="pointer-events-auto flex max-h-[85vh] w-full max-w-lg flex-col rounded-t-3xl bg-slate-50 shadow-2xl sm:rounded-2xl dark:bg-slate-950">
                <div class="flex items-center justify-between border-b border-slate-200 bg-white px-5 py-4 rounded-t-3xl sm:rounded-t-2xl dark:border-slate-800 dark:bg-slate-900">
                    <div>
                        <h2 class="text-base font-bold text-slate-900 dark:text-white">Filter & Pencarian</h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Sesuaikan katalog sesuai kebutuhan rakitanmu.</p>
                    </div>
                    <button type="button" x-on:click="filterOpen = false" class="rounded-xl p-2 text-slate-400 hover:bg-slate-100 hover:text-slate-700 dark:hover:bg-slate-800 dark:hover:text-slate-200" aria-label="Tutup">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto overscroll-contain p-4">
                    @include('shop.partials.filter-body', ['formId' => 'filter-form-mobile'])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
