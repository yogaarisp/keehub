<x-guest-layout>
    <div class="mb-3.5">
        <span class="inline-flex items-center gap-1 rounded-full bg-amber-500/10 px-2 py-0.5 text-[9.5px] font-bold tracking-wide text-amber-600 dark:bg-amber-400/10 dark:text-amber-400">
            <span class="h-1 w-1 rounded-full bg-amber-500 animate-pulse"></span>
            PORTAL AKUN
        </span>
        <h2 class="mt-1 text-xl font-black tracking-tight text-slate-900 sm:text-2xl dark:text-white">
            Masuk ke Akun
        </h2>
        <p class="text-[11.5px] text-slate-500 dark:text-slate-400">
            Akses dashboard, riwayat order, dan PC build Anda.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-3" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-3" x-data="{ showPass: false }">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="mb-1 block text-xs font-semibold text-slate-700 dark:text-slate-300">
                Alamat Email
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 dark:text-slate-500">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                    </svg>
                </div>
                <input id="email"
                       type="email"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       autofocus
                       autocomplete="username"
                       placeholder="nama@email.com"
                       class="w-full rounded-2xl border border-slate-200/90 bg-slate-50/70 py-2.5 pl-10 pr-4 text-xs sm:text-sm text-slate-900 placeholder-slate-400 transition-all duration-150 focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-amber-500/15 dark:border-slate-700/80 dark:bg-slate-800/60 dark:text-white dark:placeholder-slate-500 dark:focus:bg-slate-900">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-500" />
        </div>

        <!-- Password -->
        <div>
            <div class="mb-1 flex items-center justify-between">
                <label for="password" class="text-xs font-semibold text-slate-700 dark:text-slate-300">
                    Kata Sandi
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-[11.5px] font-semibold text-amber-600 hover:text-amber-500 hover:underline dark:text-amber-400">
                        Lupa sandi?
                    </a>
                @endif
            </div>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 dark:text-slate-500">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input id="password"
                       :type="showPass ? 'text' : 'password'"
                       name="password"
                       required
                       autocomplete="current-password"
                       placeholder="••••••••"
                       class="w-full rounded-2xl border border-slate-200/90 bg-slate-50/70 py-2.5 pl-10 pr-10 text-xs sm:text-sm text-slate-900 placeholder-slate-400 transition-all duration-150 focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-amber-500/15 dark:border-slate-700/80 dark:bg-slate-800/60 dark:text-white dark:placeholder-slate-500 dark:focus:bg-slate-900">
                <button type="button"
                        @click="showPass = !showPass"
                        class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors"
                        aria-label="Lihat kata sandi">
                    <svg x-show="!showPass" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="showPass" x-cloak class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-red-500" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between text-xs">
            <label for="remember_me" class="inline-flex items-center text-slate-600 dark:text-slate-400 cursor-pointer">
                <input id="remember_me"
                       type="checkbox"
                       name="remember"
                       class="h-3.5 w-3.5 rounded border-slate-300 text-amber-500 focus:ring-amber-500/30 dark:border-slate-700 dark:bg-slate-800">
                <span class="ml-1.5 text-[11.5px]">Ingat saya</span>
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit"
                class="group w-full flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-amber-500 via-amber-500 to-amber-600 py-3 text-sm font-bold text-white shadow-md shadow-amber-500/20 transition-all duration-150 hover:brightness-105 active:scale-[0.98]">
            <span>Masuk Sekarang</span>
            <svg class="h-4 w-4 transition-transform duration-150 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
            </svg>
        </button>

        <!-- Register Link -->
        <div class="text-center pt-0.5">
            <p class="text-[11.5px] text-slate-500 dark:text-slate-400">
                Belum memiliki akun?
                <a href="{{ route('register') }}" class="font-bold text-amber-600 hover:text-amber-500 hover:underline dark:text-amber-400 ml-1">
                    Daftar Pelanggan Baru
                </a>
            </p>
        </div>

        <!-- Admin Access Note -->
        <div class="mt-2.5 flex items-center gap-2 rounded-xl bg-slate-50/80 px-3 py-2 text-left text-[11px] text-slate-500 border border-slate-100 dark:border-slate-800 dark:bg-slate-800/40 dark:text-slate-400">
            <div class="flex h-4 w-4 shrink-0 items-center justify-center rounded-full bg-amber-500/15 text-amber-600 dark:text-amber-400">
                <svg class="h-2.5 w-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                </svg>
            </div>
            <div class="leading-tight">
                <strong class="font-semibold text-slate-700 dark:text-slate-300">Akses Tim:</strong>
                Akun owner & staff otomatis diarahkan ke Panel Admin.
            </div>
        </div>
    </form>
</x-guest-layout>
