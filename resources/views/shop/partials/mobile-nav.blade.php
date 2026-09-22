<nav class="fixed bottom-0 left-0 right-0 z-50 border-t border-gray-200 bg-white/95 backdrop-blur md:hidden dark:border-gray-800 dark:bg-gray-950/95">
    <div class="grid grid-cols-5 h-16">
        <a href="{{ route('home') }}" class="flex flex-col items-center justify-center gap-0.5 text-[11px] font-medium text-gray-600 dark:text-gray-400">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Home
        </a>
        <a href="{{ route('shop.index') }}" class="flex flex-col items-center justify-center gap-0.5 text-[11px] font-medium text-gray-600 dark:text-gray-400">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            Shop
        </a>
        <a href="{{ route('builder.index') }}" class="relative -mt-5 flex flex-col items-center justify-center">
            <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-kee-500 text-gray-950 shadow-lg shadow-kee-500/30">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17.25l.75-3.75m5.25 3.75l-.75-3.75M4.875 8.25h14.25M12 4.5a8.25 8.25 0 00-8.25 8.25c0 2.04.74 3.9 1.97 5.34.2.24.5.36.8.36h10.96c.3 0 .6-.12.8-.36a8.22 8.22 0 001.97-5.34A8.25 8.25 0 0012 4.5z"/></svg>
            </span>
            <span class="mt-0.5 text-[10px] font-bold text-gray-900 dark:text-white">Builder</span>
        </a>
        <a href="{{ route('service.create') }}" class="flex flex-col items-center justify-center gap-0.5 text-[11px] font-medium text-gray-600 dark:text-gray-400">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085"/></svg>
            Service
        </a>
        <a href="{{ auth()->check() ? route('account.dashboard') : route('login') }}" class="flex flex-col items-center justify-center gap-0.5 text-[11px] font-medium text-gray-600 dark:text-gray-400">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            Account
        </a>
    </div>
</nav>
