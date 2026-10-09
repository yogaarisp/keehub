<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-xl font-bold tracking-tight text-gray-900 sm:text-2xl dark:text-white">
            Masuk ke Akun
        </h2>
        <p class="mt-1 text-xs text-gray-500 sm:text-sm dark:text-gray-400">
            Akses dashboard, riwayat order, PC build, atau panel back-office.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4" x-data="{ showPass: false }">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">
                Alamat Email
            </label>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
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
                       class="x-input pl-10 text-sm">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs text-red-500" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1">
                <label for="password" class="text-xs font-semibold text-gray-700 dark:text-gray-300">
                    Kata Sandi
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs font-medium text-amber-600 hover:text-amber-500 hover:underline dark:text-amber-400">
                        Lupa sandi?
                    </a>
                @endif
            </div>
            <div class="relative">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-400">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input id="password"
                       :type="showPass ? 'text' : 'password'"
                       name="password"
                       required
                       autocomplete="current-password"
                       placeholder="••••••••"
                       class="x-input pl-10 pr-10 text-sm">
                <button type="button"
                        @click="showPass = !showPass"
                        class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                    <svg x-show="!showPass" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="showPass" x-cloak class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-red-500" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input id="remember_me"
                   type="checkbox"
                   name="remember"
                   class="h-4 w-4 rounded border-gray-300 text-amber-500 focus:ring-amber-500 dark:border-gray-700 dark:bg-gray-800">
            <label for="remember_me" class="ml-2 text-xs text-gray-600 dark:text-gray-400">
                Ingat sesi saya di perangkat ini
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="x-btn-primary w-full !py-3 text-sm font-bold shadow-md shadow-amber-500/20">
            Masuk Sekarang
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </button>

        <!-- Register Link -->
        <p class="text-center text-xs text-gray-500 dark:text-gray-400">
            Belum memiliki akun?
            <a href="{{ route('register') }}" class="font-bold text-amber-600 hover:text-amber-500 hover:underline dark:text-amber-400">
                Daftar Pelanggan Baru
            </a>
        </p>

        <!-- Admin Access Note -->
        <div class="mt-6 rounded-xl border border-gray-100 bg-gray-50/70 p-3 text-center text-[11px] text-gray-500 dark:border-gray-800 dark:bg-gray-900/50 dark:text-gray-400">
            <span class="font-semibold text-gray-700 dark:text-gray-300">Akses Tim / Admin:</span>
            Akun owner & staff akan otomatis diarahkan ke Panel Admin Filament setelah login.
        </div>
    </form>
</x-guest-layout>
