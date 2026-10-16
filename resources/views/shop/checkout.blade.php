@extends('layouts.storefront')

@section('title', 'Checkout — KeeHub')

@section('content')
<div class="x-container py-8" x-data="{ 
    shipping: '{{ old('shipping_method', 'pickup') }}', 
    shipCost: {{ $shipShippingCost }},
    courierApiEnabled: {{ \App\Models\Setting::get('courier_api_enabled', '0') === '1' ? 'true' : 'false' }},
    showCourierNotice: false
}">
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
                        <input type="radio" name="shipping_method" value="pickup" x-model="shipping" @click="showCourierNotice = false" class="mt-0.5 text-kee-600 focus:ring-kee-500">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-gray-900 dark:text-white">Pickup at Store</span>
                                <span class="rounded bg-emerald-100 px-1.5 py-0.5 text-[10px] font-bold text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-400">Gratis</span>
                            </div>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Ambil langsung di toko — tanpa ongkir, siap ambil setelah dikonfirmasi.</p>
                        </div>
                    </label>

                    <!-- Kirim via Kurir (Coming Soon) -->
                    <div @click="if (!courierApiEnabled) { shipping = 'pickup'; showCourierNotice = true; } else { shipping = 'ship'; showCourierNotice = false; }"
                         class="group relative flex cursor-pointer items-start gap-3 rounded-xl border p-4 transition"
                         :class="courierApiEnabled && shipping === 'ship' ? 'border-kee-500 bg-kee-500/5 ring-1 ring-kee-500' : 'border-dashed border-amber-300 bg-amber-50/40 hover:border-amber-400 dark:border-amber-500/30 dark:bg-amber-950/20'">
                        <input type="radio" name="shipping_method" value="ship" 
                               :checked="shipping === 'ship'" 
                               :disabled="!courierApiEnabled"
                               class="mt-0.5 text-amber-500 focus:ring-amber-500 opacity-70">
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-gray-900 dark:text-white">Kirim via Kurir</span>
                                <span class="inline-flex items-center rounded-full bg-gradient-to-r from-amber-500 to-orange-500 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-white shadow-sm">
                                    Coming Soon
                                </span>
                            </div>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">JNE, J&T, SiCepat, AnterAja, Cargo.</p>
                            <p class="mt-1.5 text-[11px] font-semibold text-amber-600 group-hover:underline dark:text-amber-400">
                                <span x-show="!courierApiEnabled">Klik untuk info pengiriman ekspedisi &rarr;</span>
                                <span x-show="courierApiEnabled">Cek ongkir via kurir aktif</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Alert Notice Coming Soon Kurir -->
                <div x-show="showCourierNotice" x-cloak class="mt-4 rounded-xl border border-amber-200 bg-amber-50/90 p-4 text-sm dark:border-amber-900/40 dark:bg-amber-950/40">
                    <div class="flex items-start gap-3">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-amber-500 text-white shadow-sm">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-amber-900 dark:text-amber-200">🚀 Opsi Kirim via Kurir Segera Hadir (Coming Soon)</h3>
                            <p class="mt-1 text-xs leading-relaxed text-amber-800 dark:text-amber-300">
                                {{ \App\Models\Setting::get('courier_coming_soon_note') ?: 'Fitur kalkulasi otomatis cek ongkir kurir (JNE, J&T, SiCepat) sedang dalam tahap integrasi API. Untuk saat ini pemesanan dilayani via Ambil di Toko (Pickup at Store) atau koordinasi pengiriman langsung via WhatsApp admin.' }}
                            </p>
                            <div class="mt-3 flex flex-wrap items-center gap-2">
                                <button type="button" @click="showCourierNotice = false; shipping = 'pickup'" class="rounded-lg bg-amber-600 px-3 py-1.5 text-xs font-semibold text-white shadow hover:bg-amber-700">
                                    Lanjut Ambil di Toko (Gratis)
                                </button>
                                @php
                                    $waNumber = \App\Models\Setting::get('whatsapp_number', '6281234567890');
                                    $waLink = 'https://wa.me/' . preg_replace('/\D/', '', $waNumber) . '?text=' . urlencode('Halo KeeHub, saya ingin bertanya tentang opsi pengiriman ekspedisi/kurir untuk pesanan saya.');
                                @endphp
                                <a href="{{ $waLink }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 rounded-lg border border-amber-300 bg-white px-3 py-1.5 text-xs font-semibold text-amber-900 hover:bg-amber-100 dark:border-amber-800 dark:bg-gray-900 dark:text-amber-200">
                                    <svg class="h-3.5 w-3.5 fill-current text-green-600" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                                    Tanya Admin via WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Input Alamat (Jika kurir aktif) -->
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
