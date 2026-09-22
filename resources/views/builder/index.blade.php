@extends('layouts.storefront')

@section('title', 'PC Builder — KeeHub')

@section('content')
<div class="x-container py-8"
     x-data="builder({
         initialItems: {{ json_encode(collect($selected)->map(fn ($id, $slot) => ['slot' => $slot, 'product_id' => $id])->values()->all()) }},
         initialBuildId: {{ $build?->id ?? 'null' }},
         initialName: {{ json_encode($build?->name) }},
         initialPurpose: {{ json_encode($build?->purpose) }},
         initialBudget: {{ $build?->budget ?? 'null' }},
         isLoggedIn: {{ auth()->check() ? 'true' : 'false' }}
     })">

    <div class="flex flex-wrap items-end justify-between gap-3">
        <div>
            <h1 class="x-section-title">PC Builder</h1>
            <p class="mt-1 text-sm text-gray-500">Susun PC impianmu — kompatibilitas & daya dicek otomatis.</p>
        </div>
        <div class="flex items-center gap-2">
            <span x-show="compatibility.overall === 'compatible'" class="x-badge bg-green-100 text-green-700">✓ Compatible</span>
            <span x-show="compatibility.overall === 'warning'" x-cloak class="x-badge bg-yellow-100 text-yellow-700">⚠ Warning</span>
            <span x-show="compatibility.overall === 'incompatible'" x-cloak class="x-badge bg-red-100 text-red-700">✕ Incompatible</span>
        </div>
    </div>

    {{-- Step 1 & 2: purpose + budget --}}
    <div class="mt-6 grid gap-4 sm:grid-cols-2">
        <div class="x-card p-5">
            <h2 class="text-sm font-bold uppercase tracking-wide text-gray-500">1. Kebutuhan</h2>
            <div class="mt-3 flex flex-wrap gap-2">
                @foreach ($purposes as $purpose)
                    <button type="button" x-on:click="purpose = '{{ $purpose }}'; refresh()"
                            x-bind:class="purpose === '{{ $purpose }}' ? 'bg-kee-500 text-gray-950' : 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300'"
                            class="rounded-full px-4 py-1.5 text-xs font-semibold capitalize transition">{{ $purpose }}</button>
                @endforeach
            </div>
        </div>
        <div class="x-card p-5">
            <h2 class="text-sm font-bold uppercase tracking-wide text-gray-500">2. Budget</h2>
            <div class="mt-3 flex flex-wrap gap-2">
                @foreach ([5000000, 7000000, 10000000, 15000000] as $budget)
                    <button type="button" x-on:click="budget = {{ $budget }}; refresh()"
                            x-bind:class="budget === {{ $budget }} ? 'bg-kee-500 text-gray-950' : 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300'"
                            class="rounded-full px-4 py-1.5 text-xs font-semibold transition">Rp{{ number_format($budget / 1000000, 0) }} jt</button>
                @endforeach
                <input type="number" x-model.number="budget" x-on:change="refresh()" placeholder="Custom (Rp)" class="x-input !w-36 !py-1.5 text-xs">
            </div>
        </div>
    </div>

    {{-- Step 3: components --}}
    <div class="mt-6 grid gap-6 lg:grid-cols-[1fr_22rem]">
        <div class="space-y-4">
            @foreach ($slots as $slot)
                <div class="x-card overflow-hidden" x-data="{ pickerOpen: false, products: [] }">
                    <div class="flex items-center gap-4 p-4">
                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-kee-500/10 text-lg font-bold text-kee-600 dark:text-kee-400">{{ strtoupper(mb_substr($slot, 0, 2)) }}</div>
                        <div class="min-w-0 flex-1">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400">{{ $slot }}</p>
                            <p class="truncate text-sm font-semibold text-gray-900 dark:text-white" x-text="items['{{ $slot }}']?.name ?? 'Belum dipilih'"></p>
                            <p class="text-sm text-gray-500" x-show="items['{{ $slot }}']" x-text="items['{{ $slot }}'] ? 'Rp' + items['{{ $slot }}'].price.toLocaleString('id-ID') : ''"></p>
                        </div>
                        <button type="button" x-on:click="pickerOpen = !pickerOpen; pickerOpen && pick('{{ $slot }}')"
                                class="x-btn-outline !px-3 !py-1.5 text-xs">
                            {{ in_array($slot, ['cpu', 'motherboard']) ? 'Pilih' : 'Pilih / Ganti' }}
                        </button>
                        <button type="button" x-show="items['{{ $slot }}']" x-cloak x-on:click="clearSlot('{{ $slot }}')" class="rounded-lg p-1.5 text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" aria-label="Hapus">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <div x-show="pickerOpen" x-cloak x-collapse class="border-t border-gray-100 dark:border-gray-800">
                        <div class="p-4">
                            <input type="text" x-model="pickQuery" x-on:input.debounce.400ms="pick('{{ $slot }}')" placeholder="Cari {{ $slot }}..." class="x-input !py-2 text-sm mb-3">
                            <div class="max-h-72 space-y-2 overflow-y-auto">
                                <template x-for="product in products" :key="product.id">
                                    <button type="button" x-on:click="choose('{{ $slot }}', product); pickerOpen = false"
                                            class="flex w-full items-center justify-between gap-3 rounded-xl border border-gray-100 p-3 text-left transition hover:border-kee-500 dark:border-gray-800">
                                        <div class="min-w-0">
                                            <p class="truncate text-sm font-semibold" x-text="product.name"></p>
                                            <p class="text-xs text-gray-400"><span x-text="product.brand"></span> <span x-show="!product.in_stock" class="text-red-500">• Stok habis</span></p>
                                        </div>
                                        <span class="shrink-0 font-bold text-kee-600 dark:text-kee-400" x-text="'Rp' + product.price.toLocaleString('id-ID')"></span>
                                    </button>
                                </template>
                                <p x-show="products.length === 0" class="py-4 text-center text-sm text-gray-400">Tidak ada produk.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Summary --}}
        <div class="h-fit lg:sticky lg:top-24">
            <div class="x-card p-5">
                <h2 class="font-bold text-gray-900 dark:text-white">Build Summary</h2>
                <div class="mt-4 space-y-2 text-sm">
                    <template x-for="(item, slot) in items" :key="slot">
                        <div class="flex justify-between gap-2">
                            <span class="capitalize text-gray-500" x-text="slot"></span>
                            <span class="font-semibold" x-text="'Rp' + item.price.toLocaleString('id-ID')"></span>
                        </div>
                    </template>
                </div>
                <div class="mt-4 flex justify-between border-t border-gray-100 pt-4 text-base dark:border-gray-800">
                    <span class="font-bold">TOTAL</span>
                    <span class="font-extrabold text-kee-600 dark:text-kee-400" x-text="'Rp' + total.toLocaleString('id-ID')"></span>
                </div>

                {{-- Power calc --}}
                <div class="mt-4 rounded-xl bg-gray-50 p-4 text-sm dark:bg-gray-800/60" x-show="power.total > 0" x-cloak>
                    <p class="text-xs font-bold uppercase tracking-wide text-gray-400">Estimasi Daya</p>
                    <template x-for="(watt, part) in power.breakdown" :key="part">
                        <div class="mt-1 flex justify-between"><span class="capitalize text-gray-500" x-text="part"></span><span x-text="watt + 'W'"></span></div>
                    </template>
                    <div class="mt-2 flex justify-between border-t border-gray-200 pt-2 dark:border-gray-700">
                        <span class="font-semibold">Estimasi Total</span><span class="font-bold" x-text="power.total + 'W'"></span>
                    </div>
                    <div class="mt-1 flex justify-between">
                        <span class="text-gray-500">Rekomendasi PSU</span>
                        <span class="font-bold text-kee-600 dark:text-kee-400" x-text="recommendedPsu + 'W'"></span>
                    </div>
                </div>

                {{-- Compatibility details --}}
                <div class="mt-4 space-y-2">
                    <template x-for="check in compatibility.checks" :key="check.key">
                        <div class="flex items-start gap-2 text-xs">
                            <span x-text="check.status === 'compatible' ? '✓' : (check.status === 'warning' ? '⚠' : '✕')"
                                  x-bind:class="check.status === 'compatible' ? 'text-green-500' : (check.status === 'warning' ? 'text-yellow-500' : 'text-red-500')"></span>
                            <div>
                                <p class="font-semibold" x-text="check.title"></p>
                                <p class="text-gray-500" x-text="check.message"></p>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="mt-5 space-y-2">
                    <input type="text" x-model="buildName" placeholder="Nama build (opsional)" class="x-input !py-2 text-sm">
                    <div class="grid grid-cols-2 gap-2">
                        <button type="button" x-on:click="save()" x-bind:disabled="saving" class="x-btn-dark w-full">
                            <span x-text="saved ? '✓ Tersimpan' : (saving ? 'Menyimpan...' : 'Simpan Build')"></span>
                        </button>
                        <button type="button" x-on:click="addToCart()" x-show="isLoggedIn" class="x-btn-primary w-full">+ Cart</button>
                    </div>
                    <p x-show="!isLoggedIn" class="text-center text-xs text-gray-400"><a href="{{ route('login') }}" class="font-semibold text-kee-600 hover:underline">Login</a> untuk menyimpan build ke akun.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function builder(config) {
        return {
            items: {},
            purpose: config.initialPurpose,
            budget: config.initialBudget,
            buildId: config.initialBuildId,
            buildName: config.initialName,
            compatibility: { overall: 'compatible', checks: [] },
            power: { total: 0, breakdown: {} },
            recommendedPsu: null,
            total: 0,
            saving: false,
            saved: false,
            pickQuery: '',
            currentSlot: null,

            init() {
                (config.initialItems || []).forEach(({ slot, product_id }) => {
                    if (product_id) this.fetchProduct(slot, product_id);
                });
                this.refresh();
            },

            async fetchProduct(slot, id) {
                const res = await fetch(`/builder/api/components/${slot}`);
                const data = await res.json();
                const product = data.products.find(p => p.id === id);
                if (product) { this.items[slot] = product; this.refresh(); }
            },

            async pick(slot) {
                this.currentSlot = slot;
                const params = new URLSearchParams();
                if (this.pickQuery) params.set('q', this.pickQuery);
                Object.entries(this.items).forEach(([s, item]) => params.set(`items[${s}]`, item.id));
                const res = await fetch(`/builder/api/components/${slot}?${params}`);
                const data = await res.json();
                this.products = data.products;
                if (this.$el?.closest('.x-card')) {
                    // set products on the specific card's scope
                    const card = [...document.querySelectorAll('.x-card')].find(c => c.contains(this.$el));
                }
                this.products = data.products;
            },

            choose(slot, product) {
                this.items[slot] = product;
                this.pickQuery = '';
                this.refresh();
            },

            clearSlot(slot) {
                delete this.items[slot];
                this.refresh();
            },

            async refresh() {
                const params = new URLSearchParams();
                Object.entries(this.items).forEach(([s, item]) => params.set(`items[${s}]`, item.id));
                const res = await fetch(`/builder/api/check?${params}`);
                const data = await res.json();
                this.compatibility = data.compatibility;
                this.power = data.power;
                this.recommendedPsu = data.recommended_psu;
                this.total = data.total;
                this.saved = false;
            },

            payload() {
                return {
                    build_id: this.buildId,
                    name: this.buildName,
                    purpose: this.purpose,
                    budget: this.budget,
                    items: Object.entries(this.items).map(([slot, item]) => ({ slot, product_id: item.id })),
                };
            },

            async save() {
                if (!config.isLoggedIn) { window.location = '{{ route('login') }}'; return; }
                this.saving = true;
                try {
                    const res = await fetch('{{ route('builder.save') }}', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
                        body: JSON.stringify(this.payload()),
                    });
                    const data = await res.json();
                    if (data.code) {
                        this.buildId = data.build_id || this.buildId;
                        this.saved = true;
                        window.KeeBuilderToken = data.share_token;
                    }
                } finally { this.saving = false; }
            },

            async addToCart() {
                if (!this.buildId || !this.saved) { await this.save(); }
                await fetch('{{ route('builder.add-to-cart') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
                    body: JSON.stringify({ build_id: this.buildId }),
                });
                window.location = '{{ route('cart.index') }}';
            },
        };
    }
</script>
@endsection
