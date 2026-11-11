<!DOCTYPE html>
<html lang="id" x-data="{ dark: localStorage.getItem('theme') === 'dark' }" x-bind:class="dark ? 'dark' : ''" x-init="$watch('dark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ \App\Models\Setting::faviconUrl() }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ \App\Models\Setting::logoUrl() }}">
    <link rel="apple-touch-icon" href="{{ \App\Models\Setting::logoUrl() }}">

    <title>{{ config('app.name', 'KeeHub') }} — Masuk Akun</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased dark:bg-slate-950 dark:text-slate-100 selection:bg-amber-500 selection:text-white">
    <div class="relative min-h-screen lg:grid lg:grid-cols-12">
        <!-- Floating Theme Toggle (Always Top Right) -->
        <div class="absolute right-4 top-4 z-50">
            <button x-on:click="dark = !dark" class="rounded-xl p-2.5 text-gray-500 hover:bg-gray-200/60 dark:text-gray-400 dark:hover:bg-gray-800 transition" aria-label="Toggle dark mode">
                <svg x-show="!dark" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                <svg x-show="dark" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </button>
        </div>

        <!-- Left Column: High-Impact Brand Showcase (Desktop Only) -->
        <div class="relative hidden lg:col-span-5 lg:flex flex-col justify-between overflow-hidden bg-gradient-to-br from-gray-950 via-slate-900 to-black p-12 text-white border-r border-gray-800">
            <!-- Ambient Glow Accents -->
            <div class="pointer-events-none absolute -left-20 -top-20 h-72 w-72 rounded-full bg-amber-500/15 blur-3xl"></div>
            <div class="pointer-events-none absolute -right-20 bottom-10 h-80 w-80 rounded-full bg-orange-600/10 blur-3xl"></div>

            <!-- Header Brand -->
            <div class="relative z-10">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3 transition hover:opacity-95">
                    <img src="{{ \App\Models\Setting::logoUrl() }}" alt="{{ \App\Models\Setting::get('store_name', 'KeeHub') }}" class="h-10 w-10 object-contain drop-shadow">
                    @php $storeName = \App\Models\Setting::get('store_name', 'KeeHub'); @endphp
                    @if ($storeName === 'KeeHub')
                        <span class="text-2xl font-black tracking-tight">Kee<span class="text-amber-500">Hub</span></span>
                    @else
                        <span class="text-2xl font-black tracking-tight">{{ $storeName }}</span>
                    @endif
                </a>
                <div class="mt-2 inline-flex items-center gap-1.5 rounded-full border border-amber-500/30 bg-amber-500/10 px-3 py-1 text-[11px] font-semibold tracking-wide text-amber-400">
                    <span class="h-1.5 w-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                    PC Builder & Hardware Ecosystem
                </div>
            </div>

            <!-- Middle Value Proposition & Perks -->
            <div class="relative z-10 my-auto py-10">
                <h1 class="text-3xl font-extrabold tracking-tight text-white xl:text-4xl leading-tight">
                    Build Your Dream PC.<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-orange-500">Your Way, Anywhere.</span>
                </h1>
                <p class="mt-4 text-sm text-gray-400 leading-relaxed max-w-md">
                    Katalog parts terlengkap, simulasi kompatibilitas soket & daya otomatis, serta pelacakan perakitan dan servis PC secara transparan.
                </p>

                <!-- Value Perks List -->
                <div class="mt-8 space-y-3.5 max-w-md">
                    <div class="flex items-center gap-3 rounded-xl border border-white/5 bg-white/5 p-3.5 backdrop-blur-sm transition hover:bg-white/[0.08]">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-amber-500/20 text-amber-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-gray-200">Cek Kompatibilitas Otomatis</h4>
                            <p class="text-[11px] text-gray-400">Validasi soket CPU, motherboard, RAM & estimasi daya PSU.</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 rounded-xl border border-white/5 bg-white/5 p-3.5 backdrop-blur-sm transition hover:bg-white/[0.08]">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-emerald-500/20 text-emerald-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-gray-200">Garansi Resmi & Teknisi Ahli</h4>
                            <p class="text-[11px] text-gray-400">Semua unit dirakit profesional dengan pengujian stres & kabel rapi.</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 rounded-xl border border-white/5 bg-white/5 p-3.5 backdrop-blur-sm transition hover:bg-white/[0.08]">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-sky-500/20 text-sky-400">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-gray-200">Terintegrasi ke Back-Office & POS</h4>
                            <p class="text-[11px] text-gray-400">Sinkronisasi stok real-time, cetak invoice otomatis & WhatsApp update.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Note -->
            <div class="relative z-10 text-[11px] text-gray-500 flex items-center justify-between border-t border-gray-800/80 pt-6">
                <span>&copy; {{ date('Y') }} KeeHub System</span>
                <span class="inline-flex items-center gap-1 text-gray-400 font-medium">
                    <span class="inline-block h-2 w-2 rounded-full bg-emerald-500"></span>
                    Operational Ready
                </span>
            </div>
        </div>

        <!-- Right Column: Form Container -->
        <div class="flex lg:col-span-7 flex-col justify-center px-4 py-12 sm:px-8 md:px-12 lg:px-16 relative">
            <div class="w-full max-w-md mx-auto">
                <!-- Mobile Only Brand Header -->
                <div class="mb-8 text-center lg:hidden">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5 transition hover:opacity-90">
                        <img src="{{ \App\Models\Setting::logoUrl() }}" alt="{{ \App\Models\Setting::get('store_name', 'KeeHub') }}" class="h-10 w-10 object-contain shadow-sm">
                        @php $storeName = \App\Models\Setting::get('store_name', 'KeeHub'); @endphp
                        @if ($storeName === 'KeeHub')
                            <span class="text-2xl font-black tracking-tight">Kee<span class="text-amber-500">Hub</span></span>
                        @else
                            <span class="text-2xl font-black tracking-tight">{{ $storeName }}</span>
                        @endif
                    </a>
                    <p class="mt-1 text-xs font-semibold tracking-wider uppercase text-gray-500 dark:text-gray-400">{{ \App\Models\Setting::get('store_tagline', 'Build • Buy • Upgrade • Service') }}</p>
                </div>

                <!-- Form Card -->
                <div class="x-card overflow-hidden p-6 sm:p-8 shadow-xl shadow-gray-200/50 dark:shadow-none border border-gray-100 dark:border-gray-800">
                    {{ $slot }}
                </div>

                <!-- Mobile Footer -->
                <p class="mt-8 text-center text-xs text-gray-400">
                    &copy; {{ date('Y') }} KeeHub. Seluruh hak cipta dilindungi.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
