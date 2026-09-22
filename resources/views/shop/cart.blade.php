@extends('layouts.storefront')

@section('title', 'Cart — KeeHub')

@section('content')
<div class="x-container py-8">
    <h1 class="x-section-title">Cart</h1>

    @if (session('success'))
        <div class="mt-4 rounded-xl bg-green-50 px-4 py-3 text-sm text-green-700 dark:bg-green-900/30 dark:text-green-400">{{ session('success') }}</div>
    @endif

    @if ($items->isEmpty())
        <div class="x-card mt-6 flex flex-col items-center gap-3 p-16 text-center">
            <span class="text-4xl">🛒</span>
            <p class="font-semibold text-gray-900 dark:text-white">Cart kamu masih kosong</p>
            <a href="{{ route('shop.index') }}" class="x-btn-primary mt-2">Belanja Sekarang</a>
        </div>
    @else
        <div class="mt-6 grid gap-6 lg:grid-cols-[1fr_20rem]">
            <div class="space-y-3">
                @foreach ($items as $item)
                    <div class="x-card flex gap-4 p-4">
                        <div class="h-20 w-20 shrink-0 overflow-hidden rounded-xl bg-gray-100 dark:bg-gray-800">
                            @if ($item->item_type === 'product' && $item->product?->primaryImage() && ! str_ends_with($item->product->primaryImage(), 'placeholder.svg'))
                                <img src="{{ asset('storage/'.$item->product->primaryImage()) }}" class="h-full w-full object-cover" alt="">
                            @else
                                <div class="flex h-full items-center justify-center text-2xl">{{ $item->item_type === 'build' ? '🖥️' : '📦' }}</div>
                            @endif
                        </div>
                        <div class="flex flex-1 flex-col">
                            <div class="flex items-start justify-between gap-2">
                                <div>
                                    <span class="text-[11px] font-medium uppercase text-gray-400">{{ $item->item_type === 'build' ? 'PC Build' : 'Produk' }}</span>
                                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">{{ $item->product?->name ?? 'PC Build '.($item->build?->code ?? '') }}</h3>
                                </div>
                                <form method="POST" action="{{ route('cart.remove') }}">
                                    @csrf
                                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                                    <button type="submit" class="rounded-lg p-1.5 text-gray-400 hover:bg-red-50 hover:text-red-500 dark:hover:bg-red-900/20" aria-label="Hapus">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </form>
                            </div>
                            <div class="mt-auto flex items-center justify-between">
                                <form method="POST" action="{{ route('cart.update') }}" class="flex items-center gap-1.5">
                                    @csrf
                                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                                    <input type="number" name="quantity" value="{{ $item->quantity }}" min="0" max="{{ $item->item_type === 'product' ? ($item->product->inventory?->current_stock ?? 99) : 1 }}" class="x-input !w-16 !py-1.5 text-sm">
                                    <button type="submit" class="rounded-lg p-1.5 text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                    </button>
                                </form>
                                <span class="font-bold text-gray-900 dark:text-white">Rp{{ number_format(\App\Services\CartService::itemPrice($item) * $item->quantity, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="h-fit x-card p-5 lg:sticky lg:top-24">
                <h2 class="font-bold text-gray-900 dark:text-white">Ringkasan</h2>
                <div class="mt-4 space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-gray-500 dark:text-gray-400">Subtotal</span><span class="font-semibold">Rp{{ number_format($subtotal, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-500 dark:text-gray-400">Ongkir</span><span class="text-gray-400">Dihitung di checkout</span></div>
                    <div class="flex justify-between border-t border-gray-100 pt-3 text-base dark:border-gray-800"><span class="font-bold">Total</span><span class="font-extrabold text-kee-600 dark:text-kee-400">Rp{{ number_format($subtotal, 0, ',', '.') }}</span></div>
                </div>
                <a href="{{ route('checkout.index') }}" class="x-btn-primary mt-5 w-full">Lanjut ke Checkout</a>
                <a href="{{ route('shop.index') }}" class="mt-2 block text-center text-sm text-gray-500 hover:text-kee-600">← Lanjut belanja</a>
            </div>
        </div>
    @endif
</div>
@endsection
