<div class="fi-topbar-start-wrapper flex items-center gap-2 sm:gap-3 min-w-0">
    {{-- Mobile Brand Logo & Name --}}
    <div class="flex items-center gap-2 lg:hidden min-w-0">
        <img
            src="{{ \App\Models\Setting::logoUrl() }}"
            alt="{{ \App\Models\Setting::get('store_name', 'KeeHub') }}"
            class="w-6 h-6 rounded-md object-contain flex-shrink-0"
        >
        <span class="text-sm font-bold text-slate-900 dark:text-white tracking-tight leading-none truncate max-w-[110px] sm:max-w-none">
            {{ \App\Models\Setting::get('store_name', 'KeeHub') }}
        </span>
    </div>

    {{-- Desktop Breadcrumb / System Context Indicator --}}
    <div class="hidden lg:flex items-center gap-2 text-xs">
        <span class="font-semibold text-slate-800 dark:text-slate-100 tracking-tight">{{ \App\Models\Setting::get('store_name', 'KeeHub') }} Admin</span>
        <span class="text-slate-300 dark:text-slate-600">/</span>
        <span class="text-slate-500 dark:text-slate-400 font-medium">Dashboard</span>
    </div>

    {{-- Live System Status Pill (Hidden on small mobile to prevent topbar overflow) --}}
    <div class="hidden md:inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-700 dark:text-emerald-400 text-[11px] font-medium flex-shrink-0">
        <span class="relative flex h-2 w-2">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
        </span>
        <span class="font-medium text-[11px]">Online</span>
    </div>
</div>
