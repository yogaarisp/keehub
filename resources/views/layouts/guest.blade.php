<!DOCTYPE html>
<html lang="id" x-data="{ dark: localStorage.getItem('theme') === 'dark' }" x-bind:class="dark ? 'dark' : ''" x-init="$watch('dark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ \App\Models\Setting::faviconUrl() }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ \App\Models\Setting::logoUrl() }}">
    <link rel="apple-touch-icon" href="{{ \App\Models\Setting::logoUrl() }}">

    <title>{{ config('app.name', 'KeeHub') }} — Masuk Akun</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans text-gray-900 antialiased dark:bg-gray-950 dark:text-gray-100">
    <div class="relative flex min-h-screen flex-col items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
        <!-- Floating Theme Toggle -->
        <div class="absolute right-4 top-4">
            <button x-on:click="dark = !dark" class="rounded-xl p-2.5 text-gray-500 hover:bg-gray-200/60 dark:text-gray-400 dark:hover:bg-gray-800" aria-label="Toggle dark mode">
                <svg x-show="!dark" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                <svg x-show="dark" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </button>
        </div>

        <!-- Brand Header -->
        <div class="text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5 transition hover:opacity-90">
                <img src="{{ \App\Models\Setting::logoUrl() }}" alt="{{ \App\Models\Setting::get('store_name', 'KeeHub') }}" class="h-11 w-11 object-contain shadow-sm">
                @php $storeName = \App\Models\Setting::get('store_name', 'KeeHub'); @endphp
                @if ($storeName === 'KeeHub')
                    <span class="text-2xl font-black tracking-tight">Kee<span class="text-kee-500">Hub</span></span>
                @else
                    <span class="text-2xl font-black tracking-tight">{{ $storeName }}</span>
                @endif
            </a>
            <p class="mt-1 text-xs font-semibold tracking-wider uppercase text-gray-500 dark:text-gray-400">{{ \App\Models\Setting::get('store_tagline', 'Build • Buy • Upgrade • Service') }}</p>
        </div>

        <!-- Auth Card Container -->
        <div class="x-card mt-8 w-full max-w-md overflow-hidden p-6 sm:p-8">
            {{ $slot }}
        </div>

        <p class="mt-8 text-center text-xs text-gray-400">
            &copy; {{ date('Y') }} KeeHub. Seluruh hak cipta dilindungi.
        </p>
    </div>
</body>
</html>
