<x-guest-layout>
    <div class="mb-6">
        <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-500/10 px-2.5 py-0.5 text-[10px] font-bold tracking-wide text-amber-600 dark:bg-amber-400/10 dark:text-amber-400">
            <span class="h-1.5 w-1.5 rounded-full bg-amber-500 animate-pulse"></span>
            PENDAFTARAN AKUN
        </span>
        <h2 class="mt-2 text-2xl font-black tracking-tight text-slate-900 sm:text-3xl dark:text-white">
            Daftar Akun Baru
        </h2>
        <p class="mt-1 text-xs text-slate-500 sm:text-sm dark:text-slate-400">
            Simpan racikan PC Builder, lacak pesanan, dan dapatkan garansi resmi.
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="mb-1.5 block text-xs font-semibold text-slate-700 dark:text-slate-300">
                Nama Lengkap
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 dark:text-slate-500">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                </div>
                <input id="name"
                       type="text"
                       name="name"
                       value="{{ old('name') }}"
                       required
                       autofocus
                       autocomplete="name"
                       placeholder="Nama lengkap Anda"
                       class="w-full rounded-2xl border border-slate-200/90 bg-slate-50/70 py-3 pl-10 pr-4 text-sm text-slate-900 placeholder-slate-400 transition-all duration-150 focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-amber-500/15 dark:border-slate-700/80 dark:bg-slate-800/60 dark:text-white dark:placeholder-slate-500 dark:focus:bg-slate-900">
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-1.5 text-xs text-red-500" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="mb-1.5 block text-xs font-semibold text-slate-700 dark:text-slate-300">
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
                       autocomplete="username"
                       placeholder="nama@email.com"
                       class="w-full rounded-2xl border border-slate-200/90 bg-slate-50/70 py-3 pl-10 pr-4 text-sm text-slate-900 placeholder-slate-400 transition-all duration-150 focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-amber-500/15 dark:border-slate-700/80 dark:bg-slate-800/60 dark:text-white dark:placeholder-slate-500 dark:focus:bg-slate-900">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs text-red-500" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="mb-1.5 block text-xs font-semibold text-slate-700 dark:text-slate-300">
                Kata Sandi
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 dark:text-slate-500">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input id="password"
                       type="password"
                       name="password"
                       required
                       autocomplete="new-password"
                       placeholder="Minimal 8 karakter"
                       class="w-full rounded-2xl border border-slate-200/90 bg-slate-50/70 py-3 pl-10 pr-4 text-sm text-slate-900 placeholder-slate-400 transition-all duration-150 focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-amber-500/15 dark:border-slate-700/80 dark:bg-slate-800/60 dark:text-white dark:placeholder-slate-500 dark:focus:bg-slate-900">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-red-500" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="mb-1.5 block text-xs font-semibold text-slate-700 dark:text-slate-300">
                Konfirmasi Kata Sandi
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 dark:text-slate-500">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                    </svg>
                </div>
                <input id="password_confirmation"
                       type="password"
                       name="password_confirmation"
                       required
                       autocomplete="new-password"
                       placeholder="Ulangi kata sandi"
                       class="w-full rounded-2xl border border-slate-200/90 bg-slate-50/70 py-3 pl-10 pr-4 text-sm text-slate-900 placeholder-slate-400 transition-all duration-150 focus:border-amber-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-amber-500/15 dark:border-slate-700/80 dark:bg-slate-800/60 dark:text-white dark:placeholder-slate-500 dark:focus:bg-slate-900">
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5 text-xs text-red-500" />
        </div>

        <!-- Submit Button -->
        <button type="submit"
                class="group w-full flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-amber-500 via-amber-500 to-amber-600 py-3.5 text-sm font-bold text-white shadow-lg shadow-amber-500/25 transition-all duration-150 hover:brightness-105 active:scale-[0.98]">
            <span>Daftar Sekarang</span>
            <svg class="h-4 w-4 transition-transform duration-150 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
            </svg>
        </button>

        <!-- Login Link -->
        <div class="text-center pt-2">
            <p class="text-xs text-slate-500 dark:text-slate-400">
                Sudah memiliki akun?
                <a href="{{ route('login') }}" class="font-bold text-amber-600 hover:text-amber-500 hover:underline dark:text-amber-400 ml-1">
                    Masuk di Sini
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
