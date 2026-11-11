@extends('layouts.storefront')

@section('title', ($product->meta_title) ?: ($product->name.' — KeeHub'))

@section('meta_description', $product->meta_description ?: \Illuminate\Support\Str::limit(strip_tags($product->description), 150))

@push('meta')
    <meta property="og:title" content="{{ $product->name }}">
    <meta property="og:type" content="product">
    <meta property="product:price:amount" content="{{ $product->price }}">
    <meta property="product:price:currency" content="IDR">
@endpush

@section('content')
<div class="x-container py-6 sm:py-8">
    <nav class="mb-4 flex flex-wrap items-center gap-1.5 text-xs text-slate-500 sm:text-sm dark:text-slate-400">
        <a href="{{ route('home') }}" class="hover:text-amber-600 dark:hover:text-amber-400">Home</a>
        <span>/</span>
        <a href="{{ route('shop.index') }}" class="hover:text-amber-600 dark:hover:text-amber-400">Shop</a>
        <span>/</span>
        <a href="{{ route('shop.index', ['category' => $product->category->slug]) }}" class="hover:text-amber-600 dark:hover:text-amber-400">{{ $product->category->name }}</a>
        <span>/</span>
        <span class="font-medium text-slate-900 dark:text-white">{{ \Illuminate\Support\Str::limit($product->name, 40) }}</span>
    </nav>

    <div class="grid gap-6 lg:grid-cols-2 lg:gap-10">
        {{-- Gallery --}}
        <div x-data="{ active: 0 }" class="self-start">
            <div class="x-card aspect-square overflow-hidden bg-slate-100 dark:bg-slate-800">
                @forelse ($product->images as $i => $image)
                    @if (str_ends_with($image->path, 'placeholder.svg'))
                        <div x-show="active === {{ $i }}" class="flex h-full items-center justify-center text-slate-300 dark:text-slate-600">
                            <svg class="h-24 w-24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17.25l.75-3.75m5.25 3.75l-.75-3.75M4.875 8.25h14.25M12 4.5a8.25 8.25 0 00-8.25 8.25c0 2.04.74 3.9 1.97 5.34.2.24.5.36.8.36h10.96c.3 0 .6-.12.8-.36a8.22 8.22 0 001.97-5.34A8.25 8.25 0 0012 4.5z"/></svg>
                        </div>
                    @else
                        <img x-show="active === {{ $i }}" src="{{ asset('storage/'.$image->path) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                    @endif
                @empty
                    <div class="flex h-full items-center justify-center text-slate-300 dark:text-slate-600">
                        <svg class="h-24 w-24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17.25l.75-3.75m5.25 3.75l-.75-3.75M4.875 8.25h14.25M12 4.5a8.25 8.25 0 00-8.25 8.25c0 2.04.74 3.9 1.97 5.34.2.24.5.36.8.36h10.96c.3 0 .6-.12.8-.36a8.22 8.22 0 001.97-5.34A8.25 8.25 0 0012 4.5z"/></svg>
                    </div>
                @endforelse
            </div>
            @if ($product->images->count() > 1)
                <div class="mt-3 grid grid-cols-5 gap-2">
                    @foreach ($product->images as $i => $image)
                        <button type="button" x-on:click="active = {{ $i }}" class="x-card aspect-square overflow-hidden ring-2 transition" x-bind:class="active === {{ $i }} ? 'ring-amber-500' : 'ring-transparent'">
                            @if (str_ends_with($image->path, 'placeholder.svg'))
                                <div class="flex h-full items-center justify-center bg-slate-100 text-slate-400 dark:bg-slate-800">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909" /></svg>
                                </div>
                            @else
                                <img src="{{ asset('storage/'.$image->path) }}" alt="" class="h-full w-full object-cover">
                            @endif
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Info --}}
        <div class="min-w-0">
            <div class="flex flex-wrap items-center gap-2">
                <span class="x-badge bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300">{{ $product->brand?->name ?? '-' }}</span>
                @if ($product->sold_count >= 10)
                    <span class="x-badge bg-amber-600 text-white">Best Seller</span>
                @endif
                @if ($product->stockStatus() === 'low_stock')
                    <span class="x-badge bg-orange-600 text-white">Stok Menipis</span>
                @elseif ($product->stockStatus() === 'out_of_stock')
                    <span class="x-badge bg-slate-900 text-white">Stok Habis</span>
                @endif
            </div>

            <h1 class="mt-3 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl dark:text-slate-100">{{ $product->name }}</h1>
            <p class="mt-1 text-xs text-slate-400 sm:text-sm">SKU: {{ $product->sku }}</p>

            <p class="mt-4 text-3xl font-bold tabular-nums text-amber-600 dark:text-amber-400">Rp{{ number_format($product->price, 0, ',', '.') }}</p>

            @if ($product->inventory && $product->inventory->current_stock > 0)
                <p class="mt-1 text-sm font-medium text-emerald-600 dark:text-emerald-400">Stok tersedia: {{ $product->inventory->current_stock }}</p>
            @endif

            <div class="mt-6 grid grid-cols-2 gap-2.5 sm:flex sm:flex-wrap sm:gap-3">
                @if ($product->stockStatus() !== 'out_of_stock')
                    <form method="POST" action="{{ route('cart.add', $product->id) }}" class="contents">
                        @csrf
                        <button type="submit" class="x-btn-primary justify-center">+ Keranjang</button>
                    </form>
                    <form method="POST" action="{{ route('cart.buy-now', $product->id) }}" class="contents">
                        @csrf
                        <button type="submit" class="x-btn-dark justify-center">Beli Sekarang</button>
                    </form>
                @endif

                @if ($waLink = \App\Services\WhatsAppService::productInquiry($product->name, url()->current()))
                    <a href="{{ $waLink }}" target="_blank" rel="noopener" class="x-btn-outline col-span-2 justify-center sm:col-span-1">
                        <svg class="h-4 w-4 text-emerald-500" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        Tanya via WhatsApp
                    </a>
                @endif
            </div>

            @if ($product->description)
                <div class="mt-8">
                    <h2 class="font-bold text-slate-900 dark:text-white">Deskripsi</h2>
                    <p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-slate-600 dark:text-slate-400">{{ $product->description }}</p>
                </div>
            @endif

            {{-- Compatibility info terstruktur --}}
            @if ($product->specs->isNotEmpty())
                <div class="mt-8">
                    <h2 class="font-bold text-slate-900 dark:text-white">Spesifikasi</h2>
                    <dl class="mt-3 divide-y divide-slate-100 rounded-2xl border border-slate-100 dark:divide-slate-800 dark:border-slate-800">
                        @foreach ($product->specs as $spec)
                            <div class="grid grid-cols-[40%_60%] gap-2 px-4 py-2.5 text-sm">
                                <dt class="capitalize text-slate-500 dark:text-slate-400">{{ str_replace('_', ' ', $spec->key) }}</dt>
                                <dd class="min-w-0 break-words font-medium text-slate-900 dark:text-white">{{ $spec->value }}{{ $spec->unit ? ' '.$spec->unit : '' }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </div>
            @endif

            <div class="mt-6 flex flex-wrap gap-4 text-sm text-slate-500 dark:text-slate-400">
                @if ($product->warranty)
                    <span class="flex items-center gap-1.5">
                        <svg class="h-4 w-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"/></svg>
                        Garansi {{ $product->warranty }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    @if ($related->isNotEmpty())
        <section class="mt-12">
            <h2 class="x-section-title">Produk Serupa</h2>
            <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-3 sm:gap-4 lg:grid-cols-4">
                @foreach ($related as $item)
                    <x-product-card :product="$item" />
                @endforeach
            </div>
        </section>
    @endif
</div>
@endsection
