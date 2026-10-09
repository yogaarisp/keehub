<x-guest-layout>
    <div class="mb-6">
        <h2 class="text-xl font-bold tracking-tight text-gray-900 sm:text-2xl dark:text-white">
            Daftar Akun Baru
        </h2>
        <p class="mt-1 text-xs text-gray-500 sm:text-sm dark:text-gray-400">
            Simpan racikan PC Builder, lacak pesanan, dan dapatkan garansi resmi.
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">
                Nama Lengkap
            </label>
            <input id="name"
                   type="text"
                   name="name"
                   value="{{ old('name') }}"
                   required
                   autofocus
                   autocomplete="name"
                   placeholder="Nama Anda"
                   class="x-input text-sm">
            <x-input-error :messages="$errors->get('name')" class="mt-1.5 text-xs text-red-500" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">
                Alamat Email
            </label>
            <input id="email"
                   type="email"
                   name="email"
                   value="{{ old('email') }}"
                   required
                   autocomplete="username"
                   placeholder="nama@email.com"
                   class="x-input text-sm">
            <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs text-red-500" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">
                Kata Sandi
            </label>
            <input id="password"
                   type="password"
                   name="password"
                   required
                   autocomplete="new-password"
                   placeholder="Minimal 8 karakter"
                   class="x-input text-sm">
            <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-red-500" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="mb-1 block text-xs font-semibold text-gray-700 dark:text-gray-300">
                Konfirmasi Kata Sandi
            </label>
            <input id="password_confirmation"
                   type="password"
                   name="password_confirmation"
                   required
                   autocomplete="new-password"
                   placeholder="Ulangi kata sandi"
                   class="x-input text-sm">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5 text-xs text-red-500" />
        </div>

        <!-- Submit Button -->
        <button type="submit" class="x-btn-primary w-full !py-3 text-sm font-bold shadow-md shadow-amber-500/20">
            Daftar Sekarang
        </button>

        <p class="text-center text-xs text-gray-500 dark:text-gray-400">
            Sudah memiliki akun?
            <a href="{{ route('login') }}" class="font-bold text-amber-600 hover:text-amber-500 hover:underline dark:text-amber-400">
                Masuk di Sini
            </a>
        </p>
    </form>
</x-guest-layout>
