<!DOCTYPE html>
<html lang="id" x-data="{ dark: localStorage.getItem('theme') === 'dark' }" x-bind:class="dark ? 'dark' : ''" x-init="$watch('dark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#f59e0b">
    <link rel="manifest" href="/manifest.json">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/logo-96.png">
    <link rel="apple-touch-icon" href="/logo-192.png">
    <title>@yield('title', 'KeeHub — Build. Buy. Upgrade.')</title>
    <meta name="description" content="@yield('meta_description', 'KeeHub — toko PC parts, PC builder, PC rakitan, dan IT service. Build Your PC. Your Way.')">
    @stack('meta')
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans text-gray-900 antialiased dark:bg-gray-950 dark:text-gray-100">
    <div class="flex min-h-screen flex-col">
        <header class="sticky top-0 z-40 border-b border-gray-100 bg-white/90 backdrop-blur dark:border-gray-800 dark:bg-gray-950/90">
            @include('shop.partials.navbar')
        </header>

        <main class="flex-1 pb-20 md:pb-0">
            @yield('content')
        </main>

        <footer class="border-t border-gray-100 bg-white dark:border-gray-800 dark:bg-gray-950">
            @include('shop.partials.footer')
        </footer>

        @include('shop.partials.mobile-nav')
    </div>

    @if (app()->environment('production'))
        <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', () => navigator.serviceWorker.register('/sw.js'));
            }
        </script>
    @endif
</body>
</html>
