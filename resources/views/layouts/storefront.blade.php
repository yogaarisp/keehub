<!DOCTYPE html>
<html lang="id" x-data="{ dark: localStorage.getItem('theme') === 'dark' }" x-bind:class="dark ? 'dark' : ''" x-init="$watch('dark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#f59e0b" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#0f172a" media="(prefers-color-scheme: dark)">

    {{-- PWA Standalone Fullscreen Metadata --}}
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="{{ \App\Models\Setting::get('store_name', 'KeeHub') }}">
    <meta name="application-name" content="{{ \App\Models\Setting::get('store_name', 'KeeHub') }}">
    <meta name="msapplication-TileColor" content="#0f172a">
    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" sizes="180x180" href="/logo-192.png">
    <link rel="apple-touch-icon" href="/logo.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/logo-96.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/logo-192.png">

    <title>@yield('title', 'KeeHub — Build. Buy. Upgrade.')</title>
    <meta name="description" content="@yield('meta_description', 'KeeHub — toko PC parts, PC builder, PC rakitan, dan IT service. Build Your PC. Your Way.')">
    @stack('meta')
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased dark:bg-slate-950 dark:text-slate-100">
    <div class="flex min-h-screen flex-col">
        <header class="sticky top-0 z-40 w-full px-3 pt-[calc(0.625rem+env(safe-area-inset-top,0px))] pb-1.5 sm:px-6 sm:pt-[calc(0.75rem+env(safe-area-inset-top,0px))] sm:pb-2 lg:px-8 pointer-events-none">
            @include('shop.partials.navbar')
        </header>

        <main class="flex-1 pb-[calc(5rem+env(safe-area-inset-bottom,0px))] md:pb-0">
            @yield('content')
        </main>

        <footer class="border-t border-slate-200/70 bg-white dark:border-slate-800 dark:bg-slate-950">
            @include('shop.partials.footer')
        </footer>

        @include('shop.partials.mobile-nav')
        @include('shop.partials.pwa-install-prompt')
    </div>

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').catch((err) => {
                    console.warn('PWA SW registration failed:', err);
                });
            });
        }
    </script>
</body>
</html>
