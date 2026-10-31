@extends('layouts.storefront')

@section('title', 'PC Builder Simulator — KeeHub')

@php
$slotMeta = [
    'cpu' => [
        'name' => 'Processor',
        'sub' => 'CPU (Central Processing Unit)',
        'badge' => 'CPU',
        'icon' => 'M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12H3m18 0h-1.5m-15 3.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21m-9-1.5h10.5a2.25 2.25 0 002.25-2.25V6.75a2.25 2.25 0 00-2.25-2.25H6.75A2.25 2.25 0 004.5 6.75v10.5a2.25 2.25 0 002.25 2.25zm.75-12h9v9h-9v-9z',
    ],
    'motherboard' => [
        'name' => 'Motherboard',
        'sub' => 'Mainboard Komputer',
        'badge' => 'MOBO',
        'icon' => 'M3.75 6A2.25 2.25 0 016 3.75h12A2.25 2.25 0 0120.25 6v12A2.25 2.25 0 0118 20.25H6A2.25 2.25 0 013.75 18V6zM7.5 7.5h3v3h-3v-3zm6 0h3v3h-3v-3zm-6 6h3v3h-3v-3zm6 0h3v3h-3v-3z',
    ],
    'ram' => [
        'name' => 'RAM / Memori',
        'sub' => 'Memory Module',
        'badge' => 'RAM',
        'icon' => 'M3.75 6.75h16.5M3.75 17.25h16.5m-16.5-6.75h16.5M6 4.5v15m4-15v15m4-15v15m4-15v15',
    ],
    'gpu' => [
        'name' => 'Kartu Grafis',
        'sub' => 'VGA / Video Card',
        'badge' => 'VGA',
        'icon' => 'M2.25 8.25A2.25 2.25 0 014.5 6h15a2.25 2.25 0 012.25 2.25v7.5A2.25 2.25 0 0119.5 18h-15a2.25 2.25 0 01-2.25-2.25v-7.5zm5.25 3.75a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm9 0a1.5 1.5 0 100-3 1.5 1.5 0 000 3z',
    ],
    'storage' => [
        'name' => 'Penyimpanan',
        'sub' => 'SSD / HDD Drive',
        'badge' => 'SSD',
        'icon' => 'M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 5.625c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125',
    ],
    'psu' => [
        'name' => 'Power Supply',
        'sub' => 'PSU Unit',
        'badge' => 'PSU',
        'icon' => 'M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z',
    ],
    'case' => [
        'name' => 'Casing PC',
        'sub' => 'Chassis / Case',
        'badge' => 'CASE',
        'icon' => 'M6 3.75h12A2.25 2.25 0 0120.25 6v12A2.25 2.25 0 0118 20.25H6A2.25 2.25 0 013.75 18V6A2.25 2.25 0 016 3.75zm1.5 3h9M7.5 9.75h3',
    ],
    'cooler' => [
        'name' => 'CPU Cooler',
        'sub' => 'Heatsink / Liquid AIO',
        'badge' => 'COOL',
        'icon' => 'M12 3v18m9-9H3m15.364 6.364l-12.728-12.728m0 12.728L18.364 5.636',
    ],
];
@endphp

@section('content')
<div class="x-container py-6 sm:py-8 pb-36 lg:pb-12"
     x-data="builder({
         initialItems: {{ json_encode(collect($selected)->map(fn ($id, $slot) => ['slot' => $slot, 'product_id' => $id])->values()->all()) }},
         initialBuildId: {{ $build?->id ?? 'null' }},
         initialName: {{ json_encode($build?->name) }},
         initialPurpose: {{ json_encode($build?->purpose) }},
         initialBudget: {{ $build?->budget ?? 'null' }},
         initialShareToken: {{ json_encode($build?->share_token) }},
         isLoggedIn: {{ auth()->check() ? 'true' : 'false' }},
         totalSlots: {{ count($slots) }}
     })">

    {{-- Toast Notification --}}
    <div x-show="toast.show" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-3 sm:translate-y-0 sm:translate-x-3"
         x-transition:enter-end="opacity-100 translate-y-0 sm:translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed top-20 right-4 z-50 flex items-center gap-2 rounded-xl bg-gray-900 px-4 py-3 text-sm text-white shadow-xl dark:bg-white dark:text-gray-900">
        <svg class="h-4 w-4 text-kee-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
        </svg>
        <span x-text="toast.message" class="font-medium"></span>
    </div>

    {{-- Header Section --}}
    <div class="border-b border-gray-100 pb-5 dark:border-gray-800">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-kee-600 dark:text-kee-400">
                    <span>KeeHub Configurator</span>
                    <span>•</span>
                    <span x-text="selectedCount + ' / ' + totalSlots + ' Komponen'"></span>
                </div>
                <h1 class="mt-1 text-2xl font-extrabold text-gray-900 sm:text-3xl dark:text-white">PC Builder</h1>
                <p class="mt-1 text-xs sm:text-sm text-gray-500 dark:text-gray-400">Susun spesifikasi PC impianmu — kompatibilitas & kalkulasi watt dicek realtime.</p>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                {{-- Compatibility Badge --}}
                <div class="flex items-center">
                    <span x-show="compatibility.overall === 'compatible'" class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700 ring-1 ring-emerald-600/20 dark:bg-emerald-950/40 dark:text-emerald-400 dark:ring-emerald-500/30">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/></svg>
                        Semua Kompatibel
                    </span>
                    <span x-show="compatibility.overall === 'warning'" x-cloak class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-3 py-1 text-xs font-bold text-amber-700 ring-1 ring-amber-600/20 dark:bg-amber-950/40 dark:text-amber-400 dark:ring-amber-500/30">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
                        Perlu Perhatian
                    </span>
                    <span x-show="compatibility.overall === 'incompatible'" x-cloak class="inline-flex items-center gap-1.5 rounded-full bg-rose-50 px-3 py-1 text-xs font-bold text-rose-700 ring-1 ring-rose-600/20 dark:bg-rose-950/40 dark:text-rose-400 dark:ring-rose-500/30">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd"/></svg>
                        Tidak Kompatibel
                    </span>
                </div>

                {{-- Reset Button --}}
                <button type="button" x-show="selectedCount > 0" x-cloak x-on:click="confirmReset()"
                        class="inline-flex items-center gap-1 rounded-xl px-2.5 py-1 text-xs font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-800 dark:hover:text-gray-200 transition">
                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-4.142-3.358-7.5-7.5-7.5-2.616 0-4.93 1.341-6.275 3.385M4.5 12c0 4.142 3.358 7.5 7.5 7.5 2.616 0 4.93-1.341 6.275-3.385m0 0H16.5m-4.225 3.385V16.5M4.5 12H7.5M4.5 12V9"/></svg>
                    <span>Reset</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Step 1 & 2: Kebutuhan + Budget --}}
    <div class="mt-6 grid gap-4 sm:grid-cols-2">
        {{-- 1. Kebutuhan --}}
        <div class="x-card p-4 sm:p-5">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="flex h-5 w-5 items-center justify-center rounded-full bg-kee-500/20 text-[11px] font-extrabold text-kee-600 dark:text-kee-400">1</span>
                    <h2 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Tujuan Penggunaan</h2>
                </div>
                <span class="text-[11px] text-gray-400" x-text="purpose ? purpose.toUpperCase() : 'Bebas'"></span>
            </div>

            <div class="mt-3 flex flex-wrap gap-1.5 sm:gap-2">
                @foreach ($purposes as $p)
                    <button type="button" x-on:click="purpose = '{{ $p }}'; refresh()"
                            x-bind:class="purpose === '{{ $p }}'
                                ? 'bg-kee-500 text-gray-950 font-bold shadow-sm shadow-kee-500/20'
                                : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700'"
                            class="rounded-lg px-3 py-1.5 text-xs font-medium capitalize transition">
                        {{ $p }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- 2. Budget --}}
        <div class="x-card p-4 sm:p-5">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="flex h-5 w-5 items-center justify-center rounded-full bg-kee-500/20 text-[11px] font-extrabold text-kee-600 dark:text-kee-400">2</span>
                    <h2 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Target Budget</h2>
                </div>
                <span class="text-[11px] font-semibold text-kee-600 dark:text-kee-400" x-show="budget" x-text="'Rp ' + (budget || 0).toLocaleString('id-ID')"></span>
            </div>

            <div class="mt-3 flex flex-wrap items-center gap-1.5 sm:gap-2">
                @foreach ([5000000, 7000000, 10000000, 15000000, 20000000] as $b)
                    <button type="button" x-on:click="budget = {{ $b }}; refresh()"
                            x-bind:class="budget === {{ $b }}
                                ? 'bg-kee-500 text-gray-950 font-bold shadow-sm shadow-kee-500/20'
                                : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700'"
                            class="rounded-lg px-2.5 sm:px-3 py-1.5 text-xs font-medium transition">
                        Rp{{ number_format($b / 1000000, 0) }}jt
                    </button>
                @endforeach
                <div class="relative flex-1 min-w-[120px] max-w-[160px]">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-2.5 text-xs text-gray-400 font-semibold">Rp</span>
                    <input type="number" x-model.number="budget" x-on:change="refresh()" placeholder="Custom"
                           class="w-full rounded-lg border border-gray-200 bg-white py-1.5 pl-8 pr-2 text-xs font-semibold text-gray-900 focus:border-kee-500 focus:outline-none focus:ring-1 focus:ring-kee-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white">
                </div>
            </div>
        </div>
    </div>

    {{-- Main Workspace: Slots List (Left) & Sticky Summary (Right) --}}
    <div class="mt-6 grid gap-6 lg:grid-cols-[1fr_22rem]">
        {{-- Slot Components --}}
        <div class="space-y-3 sm:space-y-3.5">
            <div class="flex items-center justify-between px-1">
                <div class="flex items-center gap-2">
                    <span class="flex h-5 w-5 items-center justify-center rounded-full bg-kee-500/20 text-[11px] font-extrabold text-kee-600 dark:text-kee-400">3</span>
                    <h2 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Daftar Komponen Rakitan</h2>
                </div>
                <span class="text-xs text-gray-400 hidden sm:inline">Pilih komponen sesuai kebutuhan</span>
            </div>

            @foreach ($slots as $slot)
                @php
                    $meta = $slotMeta[$slot] ?? [
                        'name' => ucfirst($slot),
                        'sub' => $slot,
                        'badge' => strtoupper(substr($slot, 0, 3)),
                        'icon' => 'M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z',
                    ];
                @endphp

                <div class="x-card transition-all duration-200 overflow-hidden"
                     x-bind:class="items['{{ $slot }}'] ? 'border-l-4 border-l-kee-500 ring-1 ring-gray-200/80 dark:ring-gray-800' : 'hover:border-gray-300 dark:hover:border-gray-700'">
                    <div class="flex items-center justify-between gap-3 p-3.5 sm:p-4">
                        {{-- Icon & Info --}}
                        <div class="flex items-center gap-3 min-w-0 flex-1">
                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl transition"
                                 x-bind:class="items['{{ $slot }}'] ? 'bg-kee-500/15 text-kee-600 dark:text-kee-400 ring-1 ring-kee-500/30' : 'bg-gray-100 text-gray-400 dark:bg-gray-800 dark:text-gray-500'">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $meta['icon'] }}"/>
                                </svg>
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="rounded bg-gray-100 px-1.5 py-0.5 text-[10px] font-bold text-gray-500 uppercase tracking-wider dark:bg-gray-800 dark:text-gray-400">{{ $meta['badge'] }}</span>
                                    <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 truncate">{{ $meta['name'] }}</span>
                                </div>

                                {{-- Product Name or Placeholder --}}
                                <div class="mt-0.5">
                                    <template x-if="items['{{ $slot }}']">
                                        <div>
                                            <p class="truncate text-sm font-bold text-gray-900 dark:text-white" x-text="items['{{ $slot }}'].name" :title="items['{{ $slot }}'].name"></p>
                                            <div class="flex items-center gap-2 mt-0.5">
                                                <span class="text-xs font-extrabold text-kee-600 dark:text-kee-400" x-text="'Rp ' + items['{{ $slot }}'].price.toLocaleString('id-ID')"></span>
                                                <span class="text-[11px] text-gray-400" x-show="items['{{ $slot }}'].brand" x-text="'• ' + items['{{ $slot }}'].brand"></span>
                                            </div>
                                        </div>
                                    </template>
                                    <template x-if="!items['{{ $slot }}']">
                                        <p class="text-xs text-gray-400 dark:text-gray-500 italic">Belum dipilih</p>
                                    </template>
                                </div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex items-center gap-1.5 shrink-0">
                            {{-- When NOT selected --}}
                            <button type="button" x-show="!items['{{ $slot }}']"
                                    x-on:click="openPicker('{{ $slot }}', '{{ $meta['name'] }}')"
                                    class="inline-flex items-center gap-1.5 rounded-xl bg-kee-500 px-3.5 py-2 text-xs font-bold text-gray-950 transition hover:bg-kee-400 active:scale-95 shadow-sm shadow-kee-500/20">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                                <span>Pilih</span>
                            </button>

                            {{-- When SELECTED --}}
                            <div x-show="items['{{ $slot }}']" x-cloak class="flex items-center gap-1">
                                <button type="button"
                                        x-on:click="openPicker('{{ $slot }}', '{{ $meta['name'] }}')"
                                        class="inline-flex items-center gap-1 rounded-lg border border-gray-200 bg-white px-2.5 py-1.5 text-xs font-semibold text-gray-700 transition hover:bg-gray-50 hover:border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700">
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"/></svg>
                                    <span class="hidden sm:inline">Ganti</span>
                                </button>

                                <button type="button"
                                        x-on:click="clearSlot('{{ $slot }}')"
                                        class="rounded-lg p-1.5 text-gray-400 hover:bg-rose-50 hover:text-rose-600 dark:hover:bg-rose-950/40 dark:hover:text-rose-400 transition"
                                        title="Hapus komponen">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Desktop Sticky Sidebar Summary --}}
        <div class="hidden lg:block">
            <div class="sticky top-24 space-y-4">
                <div class="x-card p-5">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3 dark:border-gray-800">
                        <h2 class="font-bold text-gray-900 dark:text-white">Ringkasan Rakitan</h2>
                        <span class="rounded-full bg-kee-500/15 px-2.5 py-0.5 text-xs font-bold text-kee-600 dark:text-kee-400" x-text="selectedCount + ' / ' + totalSlots"></span>
                    </div>

                    {{-- Selected items list preview --}}
                    <div class="mt-3 divide-y divide-gray-50 text-xs dark:divide-gray-800/60 max-h-56 overflow-y-auto">
                        <template x-for="(item, slot) in items" :key="slot">
                            <div class="flex items-center justify-between py-2 gap-2">
                                <div class="min-w-0 flex-1">
                                    <span class="font-bold uppercase tracking-wider text-[10px] text-gray-400" x-text="slot"></span>
                                    <p class="truncate font-medium text-gray-800 dark:text-gray-200" x-text="item.name"></p>
                                </div>
                                <span class="shrink-0 font-bold text-gray-900 dark:text-white" x-text="'Rp' + item.price.toLocaleString('id-ID')"></span>
                            </div>
                        </template>
                        <p x-show="selectedCount === 0" class="py-4 text-center text-xs text-gray-400 italic">Belum ada komponen dipilih.</p>
                    </div>

                    {{-- Total price --}}
                    <div class="mt-4 flex items-baseline justify-between border-t border-gray-100 pt-4 dark:border-gray-800">
                        <div>
                            <p class="text-xs uppercase font-bold tracking-wider text-gray-400">Total Biaya</p>
                            <p class="text-2xl font-extrabold text-kee-600 dark:text-kee-400" x-text="'Rp ' + total.toLocaleString('id-ID')"></p>
                        </div>
                        <div x-show="budget > 0" class="text-right">
                            <p class="text-[10px] uppercase font-bold text-gray-400">Sisa Budget</p>
                            <p class="text-xs font-bold" x-bind:class="(budget - total) >= 0 ? 'text-emerald-600' : 'text-rose-500'" x-text="'Rp ' + (budget - total).toLocaleString('id-ID')"></p>
                        </div>
                    </div>

                    {{-- Power Calculator breakdown --}}
                    <div class="mt-4 rounded-xl bg-gray-50 p-3.5 text-xs dark:bg-gray-800/50" x-show="power.total > 0" x-cloak>
                        <div class="flex items-center justify-between">
                            <span class="font-bold uppercase tracking-wider text-[10px] text-gray-400">Estimasi Daya</span>
                            <span class="font-extrabold text-gray-900 dark:text-white" x-text="power.total + ' Watt'"></span>
                        </div>
                        <div class="mt-2 space-y-1 border-t border-gray-200/60 pt-2 dark:border-gray-700/60">
                            <template x-for="(watt, part) in power.breakdown" :key="part">
                                <div class="flex justify-between text-gray-500 dark:text-gray-400">
                                    <span class="capitalize" x-text="part"></span>
                                    <span x-text="watt + 'W'"></span>
                                </div>
                            </template>
                        </div>
                        <div class="mt-2 flex items-center justify-between border-t border-gray-200/60 pt-2 font-bold text-kee-600 dark:text-kee-400 dark:border-gray-700/60">
                            <span>Saran Min. PSU</span>
                            <span x-text="(recommendedPsu || 450) + ' Watt'"></span>
                        </div>
                    </div>

                    {{-- Compatibility breakdown --}}
                    <div class="mt-4 space-y-2 border-t border-gray-100 pt-3 dark:border-gray-800" x-show="compatibility.checks.length > 0" x-cloak>
                        <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Pemeriksaan Sistem</p>
                        <template x-for="check in compatibility.checks" :key="check.key">
                            <div class="flex items-start gap-2 text-xs">
                                <span class="shrink-0 mt-0.5"
                                      x-text="check.status === 'compatible' ? '✓' : (check.status === 'warning' ? '⚠' : '✕')"
                                      x-bind:class="check.status === 'compatible' ? 'text-emerald-500 font-bold' : (check.status === 'warning' ? 'text-amber-500 font-bold' : 'text-rose-500 font-bold')"></span>
                                <div class="min-w-0">
                                    <p class="font-semibold text-gray-800 dark:text-gray-200" x-text="check.title"></p>
                                    <p class="text-[11px] text-gray-500 dark:text-gray-400" x-text="check.message"></p>
                                </div>
                            </div>
                        </template>
                    </div>

                    {{-- Name & Action Buttons --}}
                    <div class="mt-5 space-y-2.5">
                        <input type="text" x-model="buildName" placeholder="Beri nama rakitan (opsional)"
                               class="w-full rounded-xl border border-gray-200 px-3 py-2 text-xs focus:border-kee-500 focus:outline-none focus:ring-1 focus:ring-kee-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">

                        <div class="grid grid-cols-2 gap-2">
                            <button type="button" x-on:click="save()" x-bind:disabled="saving || selectedCount === 0"
                                    class="x-btn-dark !py-2 !px-3 text-xs w-full disabled:opacity-40">
                                <span x-text="saved ? '✓ Tersimpan' : (saving ? 'Menyimpan...' : 'Simpan Build')"></span>
                            </button>
                            <button type="button" x-on:click="addToCart()" x-show="isLoggedIn" x-bind:disabled="selectedCount === 0"
                                    class="x-btn-primary !py-2 !px-3 text-xs w-full disabled:opacity-40">+ Keranjang</button>
                            <a href="{{ route('login') }}" x-show="!isLoggedIn"
                               class="x-btn-outline !py-2 !px-3 text-xs w-full text-center">Login</a>
                        </div>

                        {{-- Share Link Box if Saved --}}
                        <div x-show="saved && shareToken" x-cloak class="mt-2 rounded-xl bg-gray-50 p-3 text-xs dark:bg-gray-800">
                            <div class="flex items-center justify-between">
                                <span class="font-semibold text-gray-700 dark:text-gray-300">Bagikan Build</span>
                                <button type="button" x-on:click="copyShareLink()" class="text-kee-600 dark:text-kee-400 font-bold hover:underline">
                                    Salin Link
                                </button>
                            </div>
                        </div>

                        <p x-show="!isLoggedIn" class="text-center text-[11px] text-gray-400 pt-1">
                            <a href="{{ route('login') }}" class="font-semibold text-kee-600 hover:underline">Masuk</a> untuk menyimpan build ke akun & keranjang.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Mobile Floating Summary Bar (Positioned above mobile-nav) --}}
    <div class="fixed bottom-16 left-0 right-0 z-40 border-t border-gray-200 bg-white/95 p-3.5 backdrop-blur dark:border-gray-800 dark:bg-gray-950/95 lg:hidden">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-3">
            <div class="min-w-0">
                <div class="flex items-center gap-1.5">
                    <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Total (<span x-text="selectedCount"></span>)</span>
                    <span x-show="compatibility.overall === 'compatible'" class="inline-block h-2 w-2 rounded-full bg-emerald-500"></span>
                    <span x-show="compatibility.overall === 'warning'" x-cloak class="inline-block h-2 w-2 rounded-full bg-amber-500"></span>
                    <span x-show="compatibility.overall === 'incompatible'" x-cloak class="inline-block h-2 w-2 rounded-full bg-rose-500"></span>
                </div>
                <p class="truncate text-base font-extrabold text-kee-600 dark:text-kee-400" x-text="'Rp ' + total.toLocaleString('id-ID')"></p>
            </div>

            <div class="flex items-center gap-2 shrink-0">
                <button type="button" x-on:click="summarySheetOpen = true"
                        class="inline-flex items-center gap-1 rounded-xl border border-gray-200 bg-white px-3 py-2 text-xs font-bold text-gray-800 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100">
                    <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
                    <span>Detail</span>
                </button>

                <button type="button" x-on:click="addToCart()" x-show="isLoggedIn" x-bind:disabled="selectedCount === 0"
                        class="inline-flex items-center gap-1 rounded-xl bg-kee-500 px-3.5 py-2 text-xs font-bold text-gray-950 hover:bg-kee-400 disabled:opacity-40">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    <span>+ Cart</span>
                </button>

                <button type="button" x-on:click="save()" x-show="!isLoggedIn || selectedCount > 0" x-bind:disabled="saving || selectedCount === 0"
                        class="inline-flex items-center gap-1 rounded-xl bg-gray-900 px-3 py-2 text-xs font-bold text-white dark:bg-white dark:text-gray-900 disabled:opacity-40">
                    <span x-text="saved ? '✓' : 'Simpan'"></span>
                </button>
            </div>
        </div>
    </div>

    {{-- Component Picker Modal / Bottom Sheet --}}
    <div x-show="picker.open" x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         role="dialog" aria-modal="true">
        {{-- Backdrop --}}
        <div x-show="picker.open"
             x-transition:enter="transition-opacity ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             x-on:click="closePicker()"
             class="fixed inset-0 bg-black/60 backdrop-blur-sm"></div>

        <div class="flex min-h-full items-end sm:items-center justify-center p-0 sm:p-4 text-center">
            <div x-show="picker.open"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-full sm:translate-y-4 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-full sm:translate-y-4 sm:scale-95"
                 class="relative w-full max-w-2xl transform rounded-t-3xl sm:rounded-2xl bg-white text-left shadow-2xl transition-all dark:bg-gray-900 max-h-[85vh] sm:max-h-[80vh] flex flex-col">

                {{-- Header --}}
                <div class="flex items-center justify-between border-b border-gray-100 p-4 sm:p-5 dark:border-gray-800">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="rounded bg-kee-500/15 px-2 py-0.5 text-[10px] font-bold text-kee-600 uppercase tracking-wider dark:text-kee-400" x-text="picker.slot?.toUpperCase()"></span>
                            <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white" x-text="'Pilih ' + picker.slotLabel"></h3>
                        </div>
                        <p class="text-xs text-gray-400 mt-0.5">Komponen difilter otomatis berdasarkan kompatibilitas rakitan Anda.</p>
                    </div>

                    <button type="button" x-on:click="closePicker()"
                            class="rounded-xl p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-800 dark:hover:text-gray-200 transition"
                            aria-label="Tutup">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                {{-- Search Bar --}}
                <div class="p-4 sm:p-5 pb-2 sm:pb-3 border-b border-gray-100 dark:border-gray-800">
                    <div class="relative">
                        <svg class="pointer-events-none absolute inset-y-0 left-0 my-auto ml-3.5 h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                        </svg>
                        <input type="text" x-model="picker.query" x-on:input.debounce.350ms="fetchPickerProducts()"
                               x-bind:placeholder="'Cari nama produk, spesifikasi, atau brand ' + picker.slotLabel + '...'"
                               class="w-full rounded-xl border border-gray-200 bg-gray-50 py-2.5 pl-10 pr-10 text-xs sm:text-sm text-gray-900 focus:border-kee-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-kee-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:bg-gray-900">
                        <button type="button" x-show="picker.query" x-on:click="picker.query = ''; fetchPickerProducts()"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>

                {{-- Products List --}}
                <div class="flex-1 overflow-y-auto p-4 sm:p-5 space-y-2.5">
                    {{-- Loading State --}}
                    <div x-show="picker.loading" class="py-12 text-center">
                        <div class="inline-block h-8 w-8 animate-spin rounded-full border-3 border-solid border-kee-500 border-r-transparent"></div>
                        <p class="mt-2 text-xs font-semibold text-gray-400">Memeriksa stok & kompatibilitas...</p>
                    </div>

                    {{-- Loaded List --}}
                    <template x-if="!picker.loading && picker.products.length > 0">
                        <div class="space-y-2.5">
                            <template x-for="product in picker.products" :key="product.id">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 rounded-2xl border border-gray-100 p-3.5 sm:p-4 transition hover:border-kee-500 hover:shadow-md dark:border-gray-800 dark:hover:border-kee-500/60 dark:bg-gray-950/40">
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center gap-2">
                                            <span class="rounded bg-gray-100 px-2 py-0.5 text-[10px] font-bold text-gray-600 uppercase dark:bg-gray-800 dark:text-gray-300" x-text="product.brand || 'Original'"></span>
                                            <span x-show="product.in_stock" class="text-[11px] font-semibold text-emerald-600 dark:text-emerald-400">✓ Stok Tersedia</span>
                                            <span x-show="!product.in_stock" class="text-[11px] font-semibold text-rose-500">• Stok Habis</span>
                                        </div>

                                        <h4 class="mt-1 font-bold text-sm text-gray-900 dark:text-white" x-text="product.name"></h4>

                                        {{-- Specs tags if available --}}
                                        <div class="mt-1.5 flex flex-wrap gap-1" x-show="product.specs && product.specs.length > 0">
                                            <template x-for="spec in (product.specs || []).slice(0, 3)" :key="spec.key">
                                                <span class="rounded bg-gray-50 px-1.5 py-0.5 text-[10px] text-gray-500 dark:bg-gray-800 dark:text-gray-400"
                                                      x-text="spec.key + ': ' + spec.value"></span>
                                            </template>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between sm:justify-end gap-3 shrink-0 border-t border-gray-100 pt-2.5 sm:border-0 sm:pt-0 dark:border-gray-800">
                                        <span class="text-base font-extrabold text-kee-600 dark:text-kee-400" x-text="'Rp ' + product.price.toLocaleString('id-ID')"></span>
                                        <button type="button" x-on:click="choose(picker.slot, product)"
                                                class="x-btn-primary !py-1.5 !px-4 text-xs font-bold active:scale-95 transition">
                                            Pilih Ini
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>

                    {{-- Empty State --}}
                    <div x-show="!picker.loading && picker.products.length === 0" class="py-12 text-center">
                        <svg class="mx-auto h-10 w-10 text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                        </svg>
                        <h4 class="mt-2 text-sm font-bold text-gray-700 dark:text-gray-300">Tidak ada produk ditemukan</h4>
                        <p class="mt-1 text-xs text-gray-400">Coba ubah kata kunci pencarian atau sesuaikan komponen yang sudah dipilih.</p>
                        <button type="button" x-show="picker.query" x-on:click="picker.query = ''; fetchPickerProducts()"
                                class="mt-3 inline-flex items-center gap-1 text-xs font-semibold text-kee-600 dark:text-kee-400 hover:underline">
                            Hapus kata kunci pencarian
                        </button>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="border-t border-gray-100 p-3 sm:p-4 bg-gray-50/50 dark:border-gray-800 dark:bg-gray-900/50 flex justify-between items-center text-xs text-gray-500">
                    <span x-text="picker.products.length + ' pilihan produk ditampilkan'"></span>
                    <button type="button" x-on:click="closePicker()" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Mobile Summary Drawer / Bottom Sheet --}}
    <div x-show="summarySheetOpen" x-cloak
         class="fixed inset-0 z-50 overflow-hidden lg:hidden"
         role="dialog" aria-modal="true">
        {{-- Backdrop --}}
        <div x-show="summarySheetOpen"
             x-transition:enter="transition-opacity ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             x-on:click="summarySheetOpen = false"
             class="fixed inset-0 bg-black/60 backdrop-blur-sm"></div>

        <div class="fixed inset-x-0 bottom-0 max-h-[85vh] flex flex-col rounded-t-3xl bg-white shadow-2xl transition-all dark:bg-gray-900">
            {{-- Drawer Handle & Header --}}
            <div class="p-4 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-gray-900 dark:text-white">Ringkasan Rakitan</h3>
                    <p class="text-xs text-gray-400" x-text="selectedCount + ' dari ' + totalSlots + ' komponen dipilih'"></p>
                </div>
                <button type="button" x-on:click="summarySheetOpen = false" class="rounded-xl p-2 text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Content --}}
            <div class="flex-1 overflow-y-auto p-4 space-y-4">
                {{-- Items breakdown --}}
                <div class="divide-y divide-gray-100 text-xs dark:divide-gray-800">
                    <template x-for="(item, slot) in items" :key="slot">
                        <div class="flex items-center justify-between py-2 gap-2">
                            <div class="min-w-0 flex-1">
                                <span class="font-bold uppercase tracking-wider text-[10px] text-gray-400" x-text="slot"></span>
                                <p class="truncate font-semibold text-gray-800 dark:text-gray-200" x-text="item.name"></p>
                            </div>
                            <span class="shrink-0 font-bold text-kee-600 dark:text-kee-400" x-text="'Rp ' + item.price.toLocaleString('id-ID')"></span>
                        </div>
                    </template>
                    <p x-show="selectedCount === 0" class="py-4 text-center text-xs text-gray-400 italic">Belum ada komponen dipilih.</p>
                </div>

                {{-- Total --}}
                <div class="flex items-center justify-between rounded-xl bg-gray-50 p-3.5 dark:bg-gray-800/60">
                    <span class="font-bold text-gray-800 dark:text-gray-200">Total Harga</span>
                    <span class="text-xl font-extrabold text-kee-600 dark:text-kee-400" x-text="'Rp ' + total.toLocaleString('id-ID')"></span>
                </div>

                {{-- Power Calc --}}
                <div class="rounded-xl bg-gray-50 p-3.5 text-xs dark:bg-gray-800/60" x-show="power.total > 0" x-cloak>
                    <div class="flex items-center justify-between font-bold">
                        <span class="uppercase tracking-wider text-[10px] text-gray-400">Estimasi Daya</span>
                        <span x-text="power.total + ' Watt'"></span>
                    </div>
                    <div class="mt-2 flex items-center justify-between border-t border-gray-200/60 pt-2 font-bold text-kee-600 dark:text-kee-400 dark:border-gray-700/60">
                        <span>Rekomendasi PSU</span>
                        <span x-text="(recommendedPsu || 450) + ' Watt'"></span>
                    </div>
                </div>

                {{-- Compatibility list --}}
                <div class="space-y-2" x-show="compatibility.checks.length > 0" x-cloak>
                    <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400">Pemeriksaan Kompatibilitas</p>
                    <template x-for="check in compatibility.checks" :key="check.key">
                        <div class="flex items-start gap-2 text-xs">
                            <span class="shrink-0 mt-0.5"
                                  x-text="check.status === 'compatible' ? '✓' : (check.status === 'warning' ? '⚠' : '✕')"
                                  x-bind:class="check.status === 'compatible' ? 'text-emerald-500 font-bold' : (check.status === 'warning' ? 'text-amber-500 font-bold' : 'text-rose-500 font-bold')"></span>
                            <div>
                                <p class="font-semibold text-gray-800 dark:text-gray-200" x-text="check.title"></p>
                                <p class="text-[11px] text-gray-500 dark:text-gray-400" x-text="check.message"></p>
                            </div>
                        </div>
                    </template>
                </div>

                {{-- Build Name & Actions --}}
                <div class="space-y-2 pt-2">
                    <input type="text" x-model="buildName" placeholder="Nama rakitan (opsional)"
                           class="w-full rounded-xl border border-gray-200 px-3 py-2 text-xs focus:border-kee-500 focus:outline-none focus:ring-1 focus:ring-kee-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white">

                    <div class="grid grid-cols-2 gap-2">
                        <button type="button" x-on:click="save()" x-bind:disabled="saving || selectedCount === 0"
                                class="x-btn-dark !py-2.5 !px-3 text-xs w-full disabled:opacity-40">
                            <span x-text="saved ? '✓ Tersimpan' : (saving ? 'Menyimpan...' : 'Simpan')"></span>
                        </button>
                        <button type="button" x-on:click="addToCart()" x-show="isLoggedIn" x-bind:disabled="selectedCount === 0"
                                class="x-btn-primary !py-2.5 !px-3 text-xs w-full disabled:opacity-40">+ Keranjang</button>
                        <a href="{{ route('login') }}" x-show="!isLoggedIn"
                           class="x-btn-outline !py-2.5 !px-3 text-xs w-full text-center">Login</a>
                    </div>

                    <div x-show="saved && shareToken" x-cloak class="mt-2 rounded-xl bg-gray-50 p-3 text-xs dark:bg-gray-800 flex justify-between items-center">
                        <span class="font-semibold text-gray-700 dark:text-gray-300">Link Share Aktif</span>
                        <button type="button" x-on:click="copyShareLink()" class="text-kee-600 dark:text-kee-400 font-bold hover:underline">
                            Salin Link
                        </button>
                    </div>
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
            shareToken: config.initialShareToken,
            isLoggedIn: config.isLoggedIn,
            totalSlots: config.totalSlots || 8,
            compatibility: { overall: 'compatible', checks: [] },
            power: { total: 0, breakdown: {} },
            recommendedPsu: null,
            total: 0,
            saving: false,
            saved: false,
            summarySheetOpen: false,
            toast: { show: false, message: '', timer: null },

            picker: {
                open: false,
                slot: null,
                slotLabel: '',
                products: [],
                loading: false,
                query: '',
            },

            get selectedCount() {
                return Object.keys(this.items).length;
            },

            init() {
                (config.initialItems || []).forEach(({ slot, product_id }) => {
                    if (product_id) this.fetchProduct(slot, product_id);
                });
                this.refresh();
            },

            showToast(message) {
                this.toast.message = message;
                this.toast.show = true;
                if (this.toast.timer) clearTimeout(this.toast.timer);
                this.toast.timer = setTimeout(() => {
                    this.toast.show = false;
                }, 3000);
            },

            async fetchProduct(slot, id) {
                try {
                    const res = await fetch(`/builder/api/components/${slot}`);
                    const data = await res.json();
                    const product = data.products.find(p => p.id === id);
                    if (product) {
                        this.items[slot] = product;
                        this.refresh();
                    }
                } catch (e) {
                    console.error(e);
                }
            },

            openPicker(slot, slotLabel) {
                this.picker.slot = slot;
                this.picker.slotLabel = slotLabel;
                this.picker.open = true;
                this.picker.query = '';
                this.picker.products = [];
                this.fetchPickerProducts();
            },

            closePicker() {
                this.picker.open = false;
            },

            async fetchPickerProducts() {
                if (!this.picker.slot) return;
                this.picker.loading = true;
                try {
                    const params = new URLSearchParams();
                    if (this.picker.query) params.set('q', this.picker.query);
                    Object.entries(this.items).forEach(([s, item]) => {
                        if (s !== this.picker.slot) {
                            params.set(`items[${s}]`, item.id);
                        }
                    });
                    const res = await fetch(`/builder/api/components/${this.picker.slot}?${params}`);
                    const data = await res.json();
                    this.picker.products = data.products || [];
                } catch (e) {
                    console.error(e);
                    this.picker.products = [];
                } finally {
                    this.picker.loading = false;
                }
            },

            choose(slot, product) {
                this.items[slot] = product;
                this.closePicker();
                this.showToast(`${product.name} dipilih`);
                this.refresh();
            },

            clearSlot(slot) {
                if (this.items[slot]) {
                    const name = this.items[slot].name;
                    delete this.items[slot];
                    this.showToast(`${name} dihapus`);
                    this.refresh();
                }
            },

            confirmReset() {
                if (confirm('Apakah Anda yakin ingin mengosongkan semua pilihan komponen rakitan?')) {
                    this.items = {};
                    this.buildName = '';
                    this.saved = false;
                    this.refresh();
                    this.showToast('Semua pilihan komponen telah direset');
                }
            },

            async refresh() {
                try {
                    const params = new URLSearchParams();
                    Object.entries(this.items).forEach(([s, item]) => params.set(`items[${s}]`, item.id));
                    const res = await fetch(`/builder/api/check?${params}`);
                    const data = await res.json();
                    this.compatibility = data.compatibility || { overall: 'compatible', checks: [] };
                    this.power = data.power || { total: 0, breakdown: {} };
                    this.recommendedPsu = data.recommended_psu;
                    this.total = data.total || 0;
                    this.saved = false;
                } catch (e) {
                    console.error(e);
                }
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
                if (!this.isLoggedIn) {
                    window.location = '{{ route('login') }}';
                    return;
                }
                this.saving = true;
                try {
                    const token = document.querySelector('meta[name=csrf-token]')?.content;
                    const res = await fetch('{{ route('builder.save') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(this.payload()),
                    });
                    const data = await res.json();
                    if (data.code) {
                        this.buildId = data.build_id || this.buildId;
                        this.shareToken = data.share_token;
                        this.saved = true;
                        window.KeeBuilderToken = data.share_token;
                        this.showToast('Build berhasil disimpan!');
                    }
                } catch (e) {
                    console.error(e);
                    this.showToast('Gagal menyimpan build');
                } finally {
                    this.saving = false;
                }
            },

            async addToCart() {
                if (!this.buildId || !this.saved) {
                    await this.save();
                }
                try {
                    const token = document.querySelector('meta[name=csrf-token]')?.content;
                    await fetch('{{ route('builder.add-to-cart') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ build_id: this.buildId }),
                    });
                    this.showToast('Build ditambahkan ke keranjang!');
                    window.location = '{{ route('cart.index') }}';
                } catch (e) {
                    console.error(e);
                    this.showToast('Gagal menambahkan ke keranjang');
                }
            },

            copyShareLink() {
                if (!this.shareToken) return;
                const url = `${window.location.origin}/pc-builder/build/${this.shareToken}`;
                navigator.clipboard.writeText(url).then(() => {
                    this.showToast('Link build disalin ke clipboard!');
                }).catch(() => {
                    prompt('Salin link berikut:', url);
                });
            }
        };
    }
</script>
@endsection
