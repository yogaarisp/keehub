<div class="flex items-center gap-2.5 min-w-0 pr-1">
    {{-- Logo Container with Amber Glow & Pulse --}}
    <div class="relative flex-shrink-0">
        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-amber-50 to-amber-100/90 dark:from-amber-950/40 dark:to-slate-900 border border-amber-500/30 p-1 flex items-center justify-center shadow-xs">
            <img src="{{ asset('logo-96.png') }}" alt="KeeHub" class="w-6 h-6 object-contain">
        </div>
        <span class="absolute -top-0.5 -right-0.5 flex h-2 w-2">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
        </span>
    </div>

    {{-- Brand Information --}}
    <div class="flex flex-col min-w-0">
        <div class="flex items-center gap-1.5">
            <span class="text-[14px] font-extrabold tracking-tight text-slate-900 dark:text-white leading-none">
                KeeHub
            </span>
            <span class="inline-flex items-center px-1.5 py-0.2 rounded text-[9px] font-mono font-bold tracking-wider uppercase bg-amber-500/15 text-amber-700 dark:bg-amber-400/15 dark:text-amber-300 border border-amber-500/25 leading-none">
                ADMIN
            </span>
        </div>
        <span class="text-[10px] text-slate-400 dark:text-slate-500 font-medium truncate mt-0.5 leading-none">
            Keyboard & PC Hub
        </span>
    </div>
</div>
