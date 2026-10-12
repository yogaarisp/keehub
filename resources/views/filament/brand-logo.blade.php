<div class="flex items-center gap-2.5 min-w-0">
    {{-- Store Icon / Logo --}}
    <img
        src="{{ \App\Models\Setting::logoUrl() }}"
        alt="{{ \App\Models\Setting::get('store_name', 'KeeHub') }}"
        class="w-7 h-7 rounded-lg object-contain flex-shrink-0"
    >

    {{-- Brand Name & Minimal Admin Indicator --}}
    <div class="flex items-center gap-2 min-w-0 truncate">
        <span class="text-[15px] font-bold text-slate-900 dark:text-white tracking-tight leading-none truncate">
            {{ \App\Models\Setting::get('store_name', 'KeeHub') }}
        </span>
        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium tracking-wide text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-white/5 border border-slate-200/60 dark:border-white/10 leading-none flex-shrink-0">
            Admin
        </span>
    </div>
</div>

