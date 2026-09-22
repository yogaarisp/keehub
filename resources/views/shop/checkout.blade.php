@extends('layouts.storefront')

@section('title', 'Checkout — KeeHub')

@section('content')
<div class="x-container py-8" x-data="{ shipping: '{{ old('shipping_method', 'pickup') }}' }">
    <h1 class="x-section-title">Checkout</h1>

    @if ($errors->any())
        <div class="mt-4 rounded-xl bg-red-50 px-4 py-3 text-sm text-red-600 dark:bg-red-900/30 dark:text-red-400">
            <ul class="list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('checkout.store') }}" class="mt-6 grid gap-6 lg:grid-cols-[1fr_20rem]">
        @csrf
        <div class="space-y-5">
            <div class="x-card p-5">
                <h2 class="font-bold text-gray-900 dark:text-white">Data Penerima</h2>
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-medium">Nama</label>
                        <input type="text" name="name" value="{{ old('name', $customer?->name) }}" required class="x-input" placeholder="Nama penerima">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium">WhatsApp</label>
                        <input type="text" name="whatsapp" value="{{ old('whatsapp', $customer?->whatsapp) }}" required class="x-input" placeholder="08xxxxxxxxxx">
                    </div>
                </div>
            </div>

            <div class="x-card p-5">
                <h2 class="font-bold text-gray-900 dark:text-white">Pengiriman</h2>
                <div class="mt-4 grid gap-3 sm:grid-cols-2">
                    <label class="flex cursor-pointer items-start gap-3 rounded-xl border p-4 transition has-[:checked]:border-kee-500 has-[:checked]:bg-kee-500/5">
                        <input type="radio" name="shipping_method" value="pickup" x-on:change="shipping = 'pickup'" @checked(old('shipping_method', 'pickup') === 'pickup') class="mt-0.5 text-kee-600 focus:ring-kee-500">
                        <div>
                            <span class="font-semibold text-gray-900 dark:text-white">Pickup at Store</span>
                            <p class="text-xs text-gray-500">Ambil langsung di toko — tanpa ongkir, tanpa resi.</p>
                        </div>
                    </label>
                    <label class="flex cursor-pointer items-start gap-3 rounded-xl border p-4 transition has-[:checked]:border-kee-500 has-[:checked]:bg-kee-500/5">
                        <input type="radio" name="shipping_method" value="ship" x-on:change="shipping = 'ship'" @checked(old('shipping_method') === 'ship') class="mt-0.5 text-kee-600 focus:ring-kee-500">
                        <div>
                            <span class="font-semibold text-gray-900 dark:text-white">Kirim via Kurir</span>
                            <p class="text-xs text-gray-500">JNE, J&T, SiCepat, AnterAja, Pos, Cargo.</p>
                        </div>
                    </label>
                </div>
                <div x-show="shipping === 'ship'" x-cloak class="mt-4">
                    <label class="mb-1 block text-sm font-medium">Alamat Lengkap</label>
                    <textarea name="address" rows="3" class="x-input" placeholder="Jalan, kota, provinsi, kode pos">{{ old('address') }}</textarea>
                </div>
            </div>

            <div class="x-card p-5">
                <label class="mb-1 block text-sm font-medium" for="notes">Catatan (opsional)</label>
                <textarea name="notes" id="notes" rows="2" class="x-input" placeholder="Contoh: rakit PC juga (jasa rakit)">{{ old('notes') }}</textarea>
            </div>
        </div>

        <div class="h-fit x-card p-5 lg:sticky lg:top-24">
            <h2 class="font-bold text-gray-900 dark:text-white">Ringkasan Order</h2>
            <div class="mt-4 max-h-52 space-y-3 overflow-y-auto pr-1">
                @foreach ($items as $item)
                    <div class="flex justify-between gap-2 text-sm">
                        <span class="text-gray-600 dark:text-gray-400">{{ \Illuminate\Support\Str::limit($item->product?->name ?? 'PC Build '.($item->build?->code ?? ''), 28) }} × {{ $item->quantity }}</span>
                        <span class="font-semibold">Rp{{ number_format(\App\Services\CartService::itemPrice($item) * $item->quantity, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>
            <div class="mt-4 space-y-2 border-t border-gray-100 pt-4 text-sm dark:border-gray-800">
                <div class="flex justify-between"><span class="text-gray-500">Subtotal</span><span class="font-semibold">Rp{{ number_format($subtotal, 0, ',', '.') }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Ongkir</span><span class="font-semibold" x-text="shipping === 'pickup' ? 'Gratis (pickup)' : 'Rp15.000'"></span></div>
                <input type="hidden" name="shipping_cost" value="15000">
                <div class="flex justify-between border-t border-gray-100 pt-3 text-base dark:border-gray-800"><span class="font-bold">Total</span><span class="font-extrabold text-kee-600 dark:text-kee-400" x-text="'Rp' + ({{ $subtotal }} + (shipping === 'pickup' ? 0 : 15000)).toLocaleString('id-ID')"></span></div>
            </div>
            <button type="submit" class="x-btn-primary mt-5 w-full">Buat Order</button>
            <p class="mt-3 text-center text-xs text-gray-400">Pembayaran dicatat manual oleh admin setelah order dibuat.</p>
        </div>
    </form>
</div>
@endsection
