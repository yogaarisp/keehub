<div class="flex items-center gap-2.5 min-w-0">
    {{-- Logo Tile --}}
    <div class="w-8 h-8 rounded-xl bg-white dark:bg-slate-800 border border-slate-200/60 dark:border-white/10 flex items-center justify-center flex-shrink-0 shadow-sm">
        <img
            src="{{ \App\Models\Setting::logoUrl() }}"
            alt="{{ \App\Models\Setting::get('store_name', 'KeeHub') }}"
            class="w-5 h-5 object-contain"
        >
    </div>

    {{-- Brand Name + Admin Pill --}}
    <div class="flex items-center gap-1.5 min-w-0">
        <span class="text-[15px] font-bold text-slate-900 dark:text-white tracking-tight leading-none truncate">
            {{ \App\Models\Setting::get('store_name', 'KeeHub') }}
        </span>
        <span class="inline-flex items-center px-1.5 py-0.5 rounded-md text-[10px] font-semibold tracking-wider uppercase text-amber-700 dark:text-amber-400 bg-amber-50 dark:bg-amber-500/10 border border-amber-200/60 dark:border-amber-500/20 leading-none flex-shrink-0">
            Admin
        </span>
    </div>
</div>

