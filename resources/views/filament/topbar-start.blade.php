<div class="fi-topbar-start-wrapper flex items-center gap-3">
    {{-- Breadcrumb / System Context Indicator --}}
    <div class="flex items-center gap-2 text-xs">
        <span class="font-semibold text-slate-800 dark:text-slate-100 tracking-tight">KeeHub Admin</span>
        <span class="text-slate-300 dark:text-slate-600">/</span>
        <span class="text-slate-500 dark:text-slate-400 font-medium">Dashboard</span>
    </div>

    {{-- Live System Status Pill --}}
    <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-700 dark:text-emerald-400 text-[11px] font-medium">
        <span class="relative flex h-2 w-2">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
        </span>
        <span class="font-medium text-[11px]">Online</span>
    </div>
</div>
