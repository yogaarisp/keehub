@php
    $isHome = request()->routeIs('home');
    $isShop = request()->routeIs('shop.*');
    $isBuilder = request()->routeIs('builder.*');
    $isService = request()->routeIs('service.*');
    $isAccount = request()->routeIs('account.*', 'login', 'register', 'profile.*');
@endphp

<nav class="fixed bottom-0 left-0 right-0 z-50 border-t border-slate-200/80 bg-white/95 backdrop-blur-md md:hidden dark:border-slate-800/90 dark:bg-slate-950/95">
    <div class="grid h-16 grid-cols-5">
        <a href="{{ route('home') }}"
           class="flex flex-col items-center justify-center gap-1 text-[11px] transition {{ $isHome ? 'font-semibold text-amber-600 dark:text-amber-400' : 'font-medium text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200' }}">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="{{ $isHome ? '2' : '1.75' }}">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span>Home</span>
        </a>

        <a href="{{ route('shop.index') }}"
           class="flex flex-col items-center justify-center gap-1 text-[11px] transition {{ $isShop ? 'font-semibold text-amber-600 dark:text-amber-400' : 'font-medium text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200' }}">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="{{ $isShop ? '2' : '1.75' }}">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            <span>Shop</span>
        </a>

        <a href="{{ route('builder.index') }}" class="relative -mt-5 flex flex-col items-center justify-center">
            <span class="flex h-12 w-12 items-center justify-center rounded-2xl border-[3px] border-white bg-gradient-to-br from-amber-500 to-amber-600 text-white shadow-md shadow-amber-500/25 transition active:scale-95 dark:border-slate-950">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.85">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12H3m18 0h-1.5m-15 3.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21m-9-1.5h10.5a2.25 2.25 0 002.25-2.25V6.75a2.25 2.25 0 00-2.25-2.25H6.75A2.25 2.25 0 004.5 6.75v10.5a2.25 2.25 0 002.25 2.25zm.75-12h9v9h-9v-9z"/>
                </svg>
            </span>
            <span class="mt-1 text-[11px] leading-none {{ $isBuilder ? 'font-semibold text-amber-600 dark:text-amber-400' : 'font-medium text-slate-600 dark:text-slate-300' }}">Builder</span>
        </a>

        <a href="{{ route('service.create') }}"
           class="flex flex-col items-center justify-center gap-1 text-[11px] transition {{ $isService ? 'font-semibold text-amber-600 dark:text-amber-400' : 'font-medium text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200' }}">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="{{ $isService ? '2' : '1.75' }}">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085"/>
            </svg>
            <span>Service</span>
        </a>

        <a href="{{ auth()->check() ? route('account.dashboard') : route('login') }}"
           class="flex flex-col items-center justify-center gap-1 text-[11px] transition {{ $isAccount ? 'font-semibold text-amber-600 dark:text-amber-400' : 'font-medium text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200' }}">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="{{ $isAccount ? '2' : '1.75' }}">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span>Account</span>
        </a>
    </div>
</nav>
