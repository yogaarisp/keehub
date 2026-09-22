@php
    $waLink = \App\Services\WhatsAppService::link('Halo KeeHub, saya ingin konsultasi.');
    $categories = \App\Models\Category::query()->where('is_active', true)->orderBy('sort_order')->get();
@endphp

<div class="x-container flex h-16 items-center justify-between gap-4">
    <a href="{{ route('home') }}" class="flex items-center gap-2.5">
        <img src="/logo-96.png" alt="KeeHub" class="h-9 w-9">
        <span class="text-lg font-extrabold tracking-tight">Kee<span class="text-kee-500">Hub</span></span>
    </a>

    <nav class="hidden items-center gap-1 lg:flex">
        <a href="{{ route('home') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800">Home</a>
        <div class="relative" x-data="{ open: false }" @mouseleave="open = false">
            <a href="{{ route('shop.index') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800" @mouseenter="open = true">Shop</a>
            <div x-show="open" x-cloak class="absolute left-0 top-full grid w-[32rem] grid-cols-3 gap-1 rounded-2xl border border-gray-100 bg-white p-3 shadow-xl dark:border-gray-800 dark:bg-gray-900">
                @foreach ($categories as $category)
                    <a href="{{ route('shop.index', ['category' => $category->slug]) }}" class="rounded-lg px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800">{{ $category->name }}</a>
                @endforeach
            </div>
        </div>
        <a href="{{ route('builder.index') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800">PC Builder</a>
        <a href="{{ route('rakitan.index') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800">PC Rakitan</a>
        <a href="{{ route('service.create') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800">Service</a>
    </nav>

    <div class="flex items-center gap-2">
        <button x-on:click="dark = !dark" class="rounded-xl p-2 text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800" aria-label="Toggle dark mode">
            <svg x-show="!dark" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
            <svg x-show="dark" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        </button>

        @auth
            <a href="{{ route('account.dashboard') }}" class="hidden rounded-xl p-2 text-gray-600 hover:bg-gray-100 sm:block dark:text-gray-400 dark:hover:bg-gray-800" aria-label="Account">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </a>
        @endauth

        <a href="{{ route('cart.index') }}" class="relative rounded-xl p-2 text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-800" aria-label="Cart">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            @if (($cartCount = \App\Services\CartService::current()->totalQuantity()) > 0)
                <span class="absolute -right-0.5 -top-0.5 flex h-4 min-w-4 items-center justify-center rounded-full bg-kee-500 px-1 text-[10px] font-bold text-gray-950">{{ $cartCount }}</span>
            @endif
        </a>

        @auth
            @if (auth()->user()->isAdmin())
                <a href="{{ url('/admin') }}" class="x-btn-primary hidden !px-3 !py-1.5 lg:inline-flex">Admin</a>
            @endif
        @else
            <a href="{{ route('login') }}" class="x-btn-outline hidden !px-3 !py-1.5 sm:inline-flex">Login</a>
        @endauth

        @if ($waLink)
            <a href="{{ $waLink }}" target="_blank" rel="noopener" class="x-btn-dark hidden !px-3 !py-1.5 md:inline-flex">
                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                <span class="hidden lg:inline">WhatsApp</span>
            </a>
        @endif
    </div>
</div>
