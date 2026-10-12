<div class="fi-topbar-actions-wrapper flex items-center gap-2 sm:gap-3">
    {{-- Native Filament Quick Create Dropdown --}}
    <x-filament::dropdown placement="bottom-end" teleport>
        <x-slot name="trigger">
            <button
                type="button"
                class="fi-quick-add-btn inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-white shadow-xs transition-all duration-150"
                title="Tambah Data Cepat"
            >
                <x-filament::icon icon="heroicon-m-plus" class="w-3.5 h-3.5" />
                <span class="font-semibold">Buat Baru</span>
                <x-filament::icon icon="heroicon-m-chevron-down" class="w-3 h-3 opacity-80" />
            </button>
        </x-slot>

        <x-filament::dropdown.header>
            Pintasan Buat Cepat
        </x-filament::dropdown.header>

        <x-filament::dropdown.list>
            <x-filament::dropdown.list.item
                href="{{ url('/admin/orders/create') }}"
                icon="heroicon-o-shopping-bag"
                tag="a"
            >
                Pesanan Baru
            </x-filament::dropdown.list.item>

            <x-filament::dropdown.list.item
                href="{{ url('/admin/services/create') }}"
                icon="heroicon-o-wrench-screwdriver"
                tag="a"
            >
                Servis Baru
            </x-filament::dropdown.list.item>

            <x-filament::dropdown.list.item
                href="{{ url('/admin/products/create') }}"
                icon="heroicon-o-cube"
                tag="a"
            >
                Produk Baru
            </x-filament::dropdown.list.item>
        </x-filament::dropdown.list>
    </x-filament::dropdown>

    {{-- Kunjungi Website Toko --}}
    <a
        href="{{ url('/') }}"
        target="_blank"
        rel="noopener noreferrer"
        class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg text-xs font-medium text-slate-600 hover:text-slate-900 dark:text-slate-300 dark:hover:text-white bg-slate-100 hover:bg-slate-200/70 dark:bg-slate-800/80 dark:hover:bg-slate-700/80 border border-slate-200/60 dark:border-white/5 transition-colors"
        title="Buka Website Toko"
    >
        <x-filament::icon icon="heroicon-o-globe-alt" class="w-3.5 h-3.5 text-amber-500" />
        <span class="hidden sm:inline">Buka Toko</span>
        <x-filament::icon icon="heroicon-o-arrow-top-right-on-square" class="w-3 h-3 text-slate-400" />
    </a>

    {{-- Native Theme Switcher --}}
    <div class="flex items-center">
        <x-filament-panels::theme-switcher />
    </div>

    <div class="h-4 w-px bg-slate-200 dark:bg-white/10 mx-0.5"></div>
</div>
