@php
    $storeName = \App\Models\Setting::get('store_name', 'KeeHub');
    $logoUrl = \App\Models\Setting::logoUrl();
@endphp

<div class="keehub-brand-header-root flex items-center justify-between w-full min-w-0 pr-0.5">
    <a href="{{ url('/admin') }}" class="keehub-brand-link flex items-center gap-2.5 min-w-0 text-decoration-none group">
        {{-- Logo Tile with High-Contrast Background --}}
        <div class="keehub-brand-tile flex-shrink-0 flex items-center justify-center">
            <img
                src="{{ $logoUrl }}"
                alt="{{ $storeName }}"
                class="keehub-brand-img object-contain"
            >
        </div>

        {{-- Brand Name + Refined Admin Badge --}}
        <div class="flex items-center gap-2 min-w-0">
            @if ($storeName === 'KeeHub')
                <span class="keehub-brand-title">
                    Kee<span class="keehub-brand-accent">Hub</span>
                </span>
            @else
                <span class="keehub-brand-title truncate">
                    {{ $storeName }}
                </span>
            @endif

            <span class="keehub-admin-pill">
                <span class="keehub-admin-dot"></span>
                Admin
            </span>
        </div>
    </a>

    {{-- Dedicated Mobile Close (X) Button --}}
    <button
        type="button"
        x-on:click.stop.prevent="$store.sidebar.close()"
        class="keehub-mobile-close lg:hidden inline-flex items-center justify-center transition-all flex-shrink-0 ms-1.5"
        title="Tutup Menu"
        aria-label="Tutup Menu"
    >
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
