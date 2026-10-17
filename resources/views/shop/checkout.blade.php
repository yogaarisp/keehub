@extends('layouts.storefront')

@section('title', 'Checkout — KeeHub')

@section('content')
<div class="x-container py-8" x-data="{ 
    shipping: '{{ old('shipping_method', 'pickup') }}', 
    shipCost: {{ $shipShippingCost }},
    showToast: false
}">
    <!-- Floating Toast Info Coming Soon -->
    <div x-show="showToast" 
         x-cloak 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
         class="fixed top-20 left-1/2 -translate-x-1/2 z-50 flex items-center gap-2.5 rounded-full bg-gray-900/95 px-5 py-2.5 text-xs font-medium text-white shadow-2xl backdrop-blur ring-1 ring-white/10 dark:bg-white dark:text-gray-900">
        <span class="inline-flex h-2 w-2 rounded-full bg-amber-400 animate-pulse"></span>
        <span class="font-bold text-amber-300 dark:text-amber-600">Coming Soon:</span>
        <span>Kirim via kurir segera hadir. Saat ini pilih <strong>Pickup at Store</strong>.</span>
    </div>

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
                <div class="flex items-center justify-between">
                    <h2 class="font-bold text-gray-900 dark:text-white">Metode Pengiriman</h2>
                    <span class="text-xs text-gray-400">Pilih opsi pengiriman</span>
                </div>

                <div class="mt-4 grid gap-3 sm:grid-cols-2">
                    <!-- Pickup at Store -->
                    <label class="relative flex cursor-pointer items-start gap-3 rounded-xl border p-4 transition"
                           :class="shipping === 'pickup' ? 'border-kee-500 bg-kee-500/5 ring-1 ring-kee-500' : 'border-gray-200 hover:border-gray-300 dark:border-gray-800'">
                        <input type="radio" name="shipping_method" value="pickup" x-model="shipping" class="mt-0.5 text-kee-600 focus:ring-kee-500">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-gray-900 dark:text-white">Pickup at Store</span>
                                <span class="rounded bg-emerald-100 px-1.5 py-0.5 text-[10px] font-bold text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-400">Gratis</span>
                            </div>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Ambil langsung di toko — tanpa ongkir, tanpa resi.</p>
                        </div>
                    </label>

                    <!-- Kirim via Kurir (Coming Soon) -->
                    <div @click="shipping = 'pickup'; showToast = true; setTimeout(() => showToast = false, 3000)"
                         class="group relative flex cursor-pointer items-start gap-3 rounded-xl border border-dashed border-gray-300 bg-gray-50/60 p-4 transition hover:border-amber-400 hover:bg-amber-50/30 dark:border-gray-800 dark:bg-gray-900/40 dark:hover:border-amber-500/40">
                        <input type="radio" disabled class="mt-0.5 text-gray-400 opacity-40">
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-gray-500 dark:text-gray-400">Kirim via Kurir</span>
                                <span class="rounded-full bg-amber-100 px-2 py-0.5 text-[10px] font-bold text-amber-700 dark:bg-amber-950/80 dark:text-amber-400">
                                    Coming Soon
                                </span>
                            </div>
                            <p class="mt-1 text-xs text-gray-400 dark:text-gray-500">JNE, J&T, SiCepat, AnterAja, Pos, Cargo.</p>
                            <p x-show="showToast" x-cloak class="mt-1.5 text-[11px] font-semibold text-amber-600 dark:text-amber-400">
                                Info: Opsi kurir segera hadir (Coming Soon)
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Input Alamat (Hanya jika shipping === 'ship') -->
                <div x-show="shipping === 'ship'" x-cloak class="mt-4">
                    <label class="mb-1 block text-sm font-medium">Alamat Pengiriman Lengkap</label>
                    <textarea name="address" rows="3" class="x-input" placeholder="Jalan, kelurahan, kecamatan, kota, kode pos">{{ old('address') }}</textarea>
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
                <div class="flex justify-between"><span class="text-gray-500">Ongkir</span><span class="font-semibold" x-text="shipping === 'pickup' ? 'Gratis (pickup)' : 'Rp' + shipCost.toLocaleString('id-ID')"></span></div>
                <div class="flex justify-between border-t border-gray-100 pt-3 text-base dark:border-gray-800"><span class="font-bold">Total</span><span class="font-extrabold text-kee-600 dark:text-kee-400" x-text="'Rp' + ({{ $subtotal }} + (shipping === 'pickup' ? 0 : shipCost)).toLocaleString('id-ID')"></span></div>
            </div>
            <button type="submit" class="x-btn-primary mt-5 w-full">Buat Order</button>
            <p class="mt-3 text-center text-xs text-gray-400">Pembayaran dicatat manual oleh admin setelah order dibuat.</p>
        </div>
    </form>
</div>
@endsection
