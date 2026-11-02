@php
    $storeName = \App\Models\Setting::get('store_name', 'KeeHub');
    $logoUrl = \App\Models\Setting::logoUrl();
@endphp

<div class="keehub-brand-header-root">
    <div class="keehub-brand-info">
        {{-- Logo Tile with Online Indicator --}}
        <div style="position: relative; flex-shrink: 0;">
            <div class="keehub-brand-tile">
                <img
                    src="{{ $logoUrl }}"
                    alt="{{ $storeName }}"
                    class="keehub-brand-img"
                >
            </div>
            <span class="fi-online-badge" title="Online"></span>
        </div>

        {{-- Brand & Meta Details (Matching Footer Structure) --}}
        <div class="fi-footer-meta">
            <span class="keehub-brand-title">
                @if ($storeName === 'KeeHub')
                    Kee<span class="keehub-brand-accent">Hub</span>
                @else
                    {{ $storeName }}
                @endif
            </span>
            <div class="fi-footer-sub">
                <span class="fi-user-role-badge">Admin</span>
                <span class="fi-footer-status">Panel</span>
            </div>
        </div>
    </div>

    {{-- Dedicated Mobile Close (X) Button --}}
    <button
        type="button"
        x-on:click.stop.prevent="$store.sidebar.close()"
        class="keehub-mobile-close lg:hidden"
        title="Tutup Menu"
        aria-label="Tutup Menu"
    >
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.25">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>
