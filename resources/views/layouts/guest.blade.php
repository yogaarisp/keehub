<!DOCTYPE html>
<html lang="id" class="h-full overflow-hidden" x-data="{ dark: localStorage.getItem('theme') === 'dark' }" x-bind:class="dark ? 'dark' : ''" x-init="$watch('dark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#f59e0b" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#0f172a" media="(prefers-color-scheme: dark)">

    {{-- PWA & iOS Standalone Metadata --}}
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="{{ \App\Models\Setting::get('store_name', 'KeeHub') }}">
    <link rel="manifest" href="/manifest.json">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ \App\Models\Setting::faviconUrl() }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ \App\Models\Setting::logoUrl() }}">
    <link rel="apple-touch-icon" href="{{ \App\Models\Setting::logoUrl() }}">

    <title>{{ config('app.name', 'KeeHub') }} — Masuk Akun</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html, body {
            height: 100%;
            height: 100dvh;
            max-height: 100dvh;
            overflow: hidden !important;
            overscroll-behavior: none !important;
            touch-action: manipulation;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
        }
    </style>
</head>
<body class="h-full h-[100dvh] max-h-[100dvh] overflow-hidden overscroll-none bg-slate-50 font-sans text-slate-800 antialiased dark:bg-slate-950 dark:text-slate-100 selection:bg-amber-500 selection:text-white">
    <!-- Floating Top Bar (Back to Home + Theme Toggle) -->
    <header class="fixed top-2.5 inset-x-3 sm:top-3 sm:inset-x-6 z-50 flex items-center justify-between pointer-events-none">
        {{-- Back to Home Pill Button --}}
        <a href="{{ route('home') }}"
           class="pointer-events-auto group inline-flex items-center gap-1.5 sm:gap-2 rounded-full border border-white/80 bg-white/85 px-3 py-1.5 sm:px-3.5 sm:py-2 text-xs font-bold text-slate-700 shadow-[0_4px_16px_rgba(0,0,0,0.06)] backdrop-blur-xl transition-all duration-150 hover:bg-white hover:text-slate-950 hover:shadow-md active:scale-95 dark:border-white/10 dark:bg-slate-900/85 dark:text-slate-200 dark:hover:bg-slate-800 dark:hover:text-white dark:shadow-[0_4px_16px_rgba(0,0,0,0.4)]">
            <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4 transition-transform duration-150 group-hover:-translate-x-0.5 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            <span>Kembali ke Beranda</span>
        </a>

        {{-- Theme Toggle Pill Button --}}
        <button x-on:click="dark = !dark"
                class="pointer-events-auto flex h-8 w-8 sm:h-9 sm:w-9 items-center justify-center rounded-full border border-white/80 bg-white/85 text-slate-600 shadow-[0_4px_16px_rgba(0,0,0,0.06)] backdrop-blur-xl transition-all duration-150 hover:bg-white hover:text-slate-900 active:scale-90 dark:border-white/10 dark:bg-slate-900/85 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white dark:shadow-[0_4px_16px_rgba(0,0,0,0.4)]"
                aria-label="Toggle dark mode">
            <svg x-show="!dark" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
            <svg x-show="dark" x-cloak class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        </button>
    </header>

    <div class="h-full h-[100dvh] max-h-[100dvh] overflow-hidden lg:grid lg:grid-cols-12">
        <!-- Left Column: High-Impact Brand Showcase (Desktop Only) -->
        <div class="relative hidden lg:col-span-5 lg:flex flex-col justify-between overflow-hidden bg-gradient-to-br from-gray-950 via-slate-900 to-black p-10 xl:p-12 text-white border-r border-gray-800/80">
            <!-- Ambient Glow Accents -->
            <div class="pointer-events-none absolute -left-20 -top-20 h-80 w-80 rounded-full bg-amber-500/20 blur-3xl"></div>
            <div class="pointer-events-none absolute -right-20 bottom-10 h-80 w-80 rounded-full bg-orange-600/15 blur-3xl"></div>

            <!-- Header Brand -->
            <div class="relative z-10 pt-8">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3 transition hover:opacity-95">
                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white/10 p-2 ring-1 ring-white/20 backdrop-blur-md">
                        <img src="{{ \App\Models\Setting::logoUrl() }}" alt="{{ \App\Models\Setting::get('store_name', 'KeeHub') }}" class="h-full w-full object-contain drop-shadow">
                    </div>
                    @php $storeName = \App\Models\Setting::get('store_name', 'KeeHub'); @endphp
                    @if ($storeName === 'KeeHub')
                        <span class="text-2xl font-black tracking-tight">Kee<span class="text-amber-500">Hub</span></span>
                    @else
                        <span class="text-2xl font-black tracking-tight">{{ $storeName }}</span>
                    @endif
                </a>
                <div class="mt-3 inline-flex items-center gap-1.5 rounded-full border border-amber-500/30 bg-amber-500/10 px-3 py-1 text-[11px] font-semibold tracking-wide text-amber-400">
                    <span class="h-1.5 w-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                    PC Builder & Hardware Ecosystem
                </div>
            </div>

            <!-- Middle Value Proposition & Perks -->
            <div class="relative z-10 my-auto py-6">
                <h1 class="text-3xl font-extrabold tracking-tight text-white xl:text-4xl leading-tight">
                    Build Your Dream PC.<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-orange-500">Your Way, Anywhere.</span>
                </h1>
                <p class="mt-3 text-xs xl:text-sm text-gray-400 leading-relaxed max-w-md">
                    Katalog parts terlengkap, simulasi kompatibilitas soket & daya otomatis, serta pelacakan perakitan dan servis PC secara transparan.
                </p>

                <!-- Value Perks List -->
                <div class="mt-6 space-y-3 max-w-md">
                    <div class="flex items-center gap-3 rounded-2xl border border-white/10 bg-white/5 p-3 backdrop-blur-sm transition hover:bg-white/[0.08]">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-amber-500/20 text-amber-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-gray-200">Cek Kompatibilitas Otomatis</h4>
                            <p class="text-[10.5px] text-gray-400">Validasi soket CPU, motherboard, RAM & estimasi daya PSU.</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 rounded-2xl border border-white/10 bg-white/5 p-3 backdrop-blur-sm transition hover:bg-white/[0.08]">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-emerald-500/20 text-emerald-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-gray-200">Garansi Resmi & Teknisi Ahli</h4>
                            <p class="text-[10.5px] text-gray-400">Semua unit dirakit profesional dengan pengujian stres & kabel rapi.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Note -->
            <div class="relative z-10 text-[10.5px] text-gray-500 flex items-center justify-between border-t border-gray-800/80 pt-4">
                <span>&copy; {{ date('Y') }} KeeHub System</span>
                <span class="inline-flex items-center gap-1.5 text-gray-400 font-medium">
                    <span class="inline-block h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Operational Ready
                </span>
            </div>
        </div>

        <!-- Right Column: Form Container (Fixed Screen Height, Center Vertically) -->
        <div class="relative flex h-full h-[100dvh] max-h-[100dvh] overflow-hidden lg:col-span-7 flex-col items-center justify-center px-4 py-2 sm:px-8">
            {{-- Ambient Backdrop Glows --}}
            <div class="pointer-events-none absolute -right-20 top-20 h-64 w-64 rounded-full bg-amber-500/10 blur-3xl"></div>
            <div class="pointer-events-none absolute -left-20 bottom-20 h-64 w-64 rounded-full bg-blue-500/10 blur-3xl"></div>

            <div class="w-full max-w-[390px] mx-auto flex flex-col justify-center relative z-10">
                <!-- Mobile Brand Header (Compact) -->
                <div class="mb-3 text-center lg:hidden">
                    <a href="{{ route('home') }}" class="group inline-flex items-center gap-2 transition active:scale-95">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white p-1.5 shadow-[0_4px_12px_rgba(0,0,0,0.06)] ring-1 ring-slate-900/5 transition group-hover:scale-105 dark:bg-slate-900 dark:ring-white/10">
                            <img src="{{ \App\Models\Setting::logoUrl() }}" alt="{{ \App\Models\Setting::get('store_name', 'KeeHub') }}" class="h-full w-full object-contain">
                        </div>
                        <div class="text-left">
                            @php $storeName = \App\Models\Setting::get('store_name', 'KeeHub'); @endphp
                            <span class="text-lg font-black tracking-tight text-slate-900 dark:text-white leading-none block">
                                @if ($storeName === 'KeeHub')
                                    Kee<span class="text-amber-600 dark:text-amber-400">Hub</span>
                                @else
                                    {{ $storeName }}
                                @endif
                            </span>
                            <span class="text-[9.5px] font-semibold tracking-wider uppercase text-slate-400 leading-tight block">
                                {{ \App\Models\Setting::get('store_tagline', 'Build • Buy • Upgrade') }}
                            </span>
                        </div>
                    </a>
                </div>

                <!-- Form Card (iOS Glassmorphism Container) -->
                <div class="overflow-hidden rounded-3xl border border-white/80 bg-white/85 p-5 sm:p-7 shadow-[0_16px_40px_-8px_rgba(0,0,0,0.08)] backdrop-blur-2xl dark:border-white/10 dark:bg-slate-900/85 dark:shadow-[0_16px_40px_-8px_rgba(0,0,0,0.5)]">
                    {{ $slot }}
                </div>

                <!-- Bottom Copyright -->
                <p class="mt-2.5 text-center text-[10px] text-slate-400 dark:text-slate-500">
                    &copy; {{ date('Y') }} KeeHub. Seluruh hak cipta dilindungi.
                </p>
            </div>
        </div>
    </div>
</body>
</html>
