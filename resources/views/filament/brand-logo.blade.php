<div class="flex items-center justify-between w-full min-w-0 pr-0.5">
    <div class="flex items-center gap-2 min-w-0">
        {{-- Logo Tile --}}
        <div class="w-7 h-7 rounded-lg bg-slate-50 dark:bg-slate-800 border border-slate-200/60 dark:border-white/10 flex items-center justify-center flex-shrink-0 shadow-2xs">
            <img
                src="{{ \App\Models\Setting::logoUrl() }}"
                alt="{{ \App\Models\Setting::get('store_name', 'KeeHub') }}"
                class="w-4.5 h-4.5 object-contain"
            >
        </div>

        {{-- Brand Name + Admin Pill --}}
        <div class="flex items-center gap-1.5 min-w-0">
            <span class="text-[14.5px] font-bold text-slate-900 dark:text-white tracking-tight leading-none truncate">
                {{ \App\Models\Setting::get('store_name', 'KeeHub') }}
            </span>
            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[9.5px] font-semibold tracking-wider uppercase text-amber-600 dark:text-amber-400 bg-amber-500/10 dark:bg-amber-500/15 border border-amber-500/20 leading-none flex-shrink-0">
                Admin
            </span>
        </div>
    </div>

    {{-- Dedicated Mobile Close (X) Button --}}
    <button
        type="button"
        x-on:click.stop.prevent="$store.sidebar.close()"
        class="lg:hidden inline-flex items-center justify-center w-7 h-7 rounded-md bg-slate-100 hover:bg-slate-200/80 dark:bg-white/10 dark:hover:bg-white/15 text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-white transition-all flex-shrink-0 ms-1.5"
        title="Tutup Menu"
        aria-label="Tutup Menu"
    >
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>

