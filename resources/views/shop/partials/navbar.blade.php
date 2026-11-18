@php
    $waLink = \App\Services\WhatsAppService::link('Halo KeeHub, saya ingin konsultasi.');
    $categories = \App\Models\Category::query()->where('is_active', true)->orderBy('sort_order')->get();
    $isHome = request()->routeIs('home');
    $isShop = request()->routeIs('shop.*');
    $isBuilder = request()->routeIs('builder.*');
    $isRakitan = request()->routeIs('rakitan.*');
    $isService = request()->routeIs('service.*');
@endphp

{{-- iOS Floating Glassmorphism Header Bar --}}
<div class="pointer-events-auto mx-auto flex h-14 sm:h-16 max-w-7xl items-center justify-between gap-3 sm:gap-4 rounded-2xl sm:rounded-full border border-white/70 bg-white/80 px-3.5 sm:px-6 shadow-[0_8px_30px_rgb(0,0,0,0.06),0_2px_8px_rgb(0,0,0,0.04)] backdrop-blur-xl transition-all duration-200 dark:border-white/10 dark:bg-slate-900/80 dark:shadow-[0_8px_32px_rgb(0,0,0,0.35)]">
    {{-- Brand Logo --}}
    <a href="{{ route('home') }}" class="group flex items-center gap-2.5 transition active:scale-95">
        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-slate-100/80 p-1 ring-1 ring-slate-200/60 transition group-hover:scale-105 dark:bg-slate-800/80 dark:ring-white/10">
            <img src="{{ \App\Models\Setting::logoUrl() }}" alt="{{ \App\Models\Setting::get('store_name', 'KeeHub') }}" class="h-full w-full object-contain">
        </div>
        @php $currentStoreName = \App\Models\Setting::get('store_name', 'KeeHub'); @endphp
        @if ($currentStoreName === 'KeeHub')
            <span class="text-base sm:text-lg font-bold tracking-tight text-slate-900 dark:text-slate-100">Kee<span class="text-amber-600 dark:text-amber-400">Hub</span></span>
        @else
            <span class="text-base sm:text-lg font-bold tracking-tight text-slate-900 dark:text-slate-100">{{ $currentStoreName }}</span>
        @endif
    </a>

    {{-- Desktop Navigation (iOS Segmented Pill style) --}}
    <nav class="hidden items-center gap-1 rounded-full bg-slate-100/70 p-1 lg:flex dark:bg-slate-800/60">
        <a href="{{ route('home') }}"
           class="rounded-full px-3.5 py-1.5 text-xs font-semibold tracking-wide transition-all duration-150 active:scale-95 {{ $isHome ? 'bg-white text-slate-900 shadow-sm dark:bg-slate-700 dark:text-white' : 'text-slate-600 hover:text-slate-900 dark:text-slate-300 dark:hover:text-white' }}">
            Home
        </a>

        <div class="relative" x-data="{ open: false }" @mouseleave="open = false">
            <a href="{{ route('shop.index') }}"
               @mouseenter="open = true"
               class="flex items-center gap-1 rounded-full px-3.5 py-1.5 text-xs font-semibold tracking-wide transition-all duration-150 active:scale-95 {{ $isShop ? 'bg-white text-slate-900 shadow-sm dark:bg-slate-700 dark:text-white' : 'text-slate-600 hover:text-slate-900 dark:text-slate-300 dark:hover:text-white' }}">
                <span>Shop</span>
                <svg class="h-3 w-3 opacity-60 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
            </a>
            <div x-show="open" x-cloak
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                 class="absolute left-0 top-full mt-2 grid w-[32rem] grid-cols-3 gap-1.5 rounded-2xl border border-white/70 bg-white/90 p-3 shadow-2xl backdrop-blur-xl dark:border-white/10 dark:bg-slate-900/90">
                @foreach ($categories as $category)
                    <a href="{{ route('shop.index', ['category' => $category->slug]) }}"
                       class="rounded-xl px-3 py-2 text-xs font-medium text-slate-600 hover:bg-amber-500/10 hover:text-amber-600 dark:text-slate-300 dark:hover:bg-amber-400/10 dark:hover:text-amber-400 transition-colors">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <a href="{{ route('builder.index') }}"
           class="rounded-full px-3.5 py-1.5 text-xs font-semibold tracking-wide transition-all duration-150 active:scale-95 {{ $isBuilder ? 'bg-white text-slate-900 shadow-sm dark:bg-slate-700 dark:text-white' : 'text-slate-600 hover:text-slate-900 dark:text-slate-300 dark:hover:text-white' }}">
            PC Builder
        </a>

        <a href="{{ route('rakitan.index') }}"
           class="rounded-full px-3.5 py-1.5 text-xs font-semibold tracking-wide transition-all duration-150 active:scale-95 {{ $isRakitan ? 'bg-white text-slate-900 shadow-sm dark:bg-slate-700 dark:text-white' : 'text-slate-600 hover:text-slate-900 dark:text-slate-300 dark:hover:text-white' }}">
            PC Rakitan
        </a>

        <a href="{{ route('service.create') }}"
           class="rounded-full px-3.5 py-1.5 text-xs font-semibold tracking-wide transition-all duration-150 active:scale-95 {{ $isService ? 'bg-white text-slate-900 shadow-sm dark:bg-slate-700 dark:text-white' : 'text-slate-600 hover:text-slate-900 dark:text-slate-300 dark:hover:text-white' }}">
            Service
        </a>
    </nav>

    {{-- Actions --}}
    <div class="flex items-center gap-1.5 sm:gap-2">
        <button x-on:click="dark = !dark"
                class="flex h-9 w-9 items-center justify-center rounded-full text-slate-500 transition-all hover:bg-slate-100/80 hover:text-slate-800 active:scale-90 dark:text-slate-400 dark:hover:bg-slate-800/80 dark:hover:text-slate-200"
                aria-label="Toggle dark mode">
            <svg x-show="!dark" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
            <svg x-show="dark" x-cloak class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        </button>

        @auth
            <a href="{{ route('account.dashboard') }}"
               class="hidden h-9 w-9 items-center justify-center rounded-full text-slate-500 transition-all hover:bg-slate-100/80 hover:text-slate-800 active:scale-90 sm:flex dark:text-slate-400 dark:hover:bg-slate-800/80 dark:hover:text-slate-200"
               aria-label="Account">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </a>
        @endauth

        <a href="{{ route('cart.index') }}"
           class="relative flex h-9 w-9 items-center justify-center rounded-full text-slate-500 transition-all hover:bg-slate-100/80 hover:text-slate-800 active:scale-90 dark:text-slate-400 dark:hover:bg-slate-800/80 dark:hover:text-slate-200"
           aria-label="Cart">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            @if (($cartCount = \App\Services\CartService::count()) > 0)
                <span class="absolute -right-0.5 -top-0.5 flex h-4 min-w-4 items-center justify-center rounded-full bg-amber-600 px-1 text-[10px] font-bold text-white shadow-sm ring-2 ring-white dark:ring-slate-900">{{ $cartCount }}</span>
            @endif
        </a>

        @auth
            @if (auth()->user()->isAdmin())
                <a href="{{ url('/admin') }}" class="hidden items-center justify-center rounded-full bg-amber-600 px-3.5 py-1.5 text-xs font-semibold text-white shadow-sm shadow-amber-600/20 transition-all hover:bg-amber-500 active:scale-95 lg:inline-flex">Admin</a>
            @endif
        @else
            <a href="{{ route('login') }}" class="hidden items-center justify-center rounded-full border border-slate-200/80 bg-white/70 px-3.5 py-1.5 text-xs font-semibold text-slate-700 shadow-sm transition-all hover:bg-white hover:text-slate-900 active:scale-95 sm:inline-flex dark:border-slate-700/80 dark:bg-slate-800/70 dark:text-slate-200 dark:hover:bg-slate-800 dark:hover:text-white">Login</a>
        @endauth

        @if ($waLink)
            <a href="{{ $waLink }}" target="_blank" rel="noopener" class="hidden items-center gap-1.5 rounded-full bg-slate-900/90 px-3.5 py-1.5 text-xs font-semibold text-white shadow-sm transition-all hover:bg-slate-800 active:scale-95 md:inline-flex dark:bg-slate-100/90 dark:text-slate-900 dark:hover:bg-white">
                <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                <span class="hidden lg:inline">WhatsApp</span>
            </a>
        @endif
    </div>
</div>
