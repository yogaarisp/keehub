@extends('layouts.storefront')

@section('title', 'KeeHub — Build Your PC. Your Way.')

@section('content')
<div>
    {{-- Hero --}}
    @php
        $heroBgUrl = \App\Models\Setting::heroBackgroundUrl();
        $heroDisplay = \App\Models\Setting::heroDisplayConfig();
        $isAutoRatio = $heroBgUrl && $heroDisplay['isAuto'];
    @endphp
    <section class="relative overflow-hidden {{ $heroBgUrl ? 'bg-gray-950' : 'bg-gradient-to-br from-gray-950 via-gray-900 to-gray-800' }} {{ $isAutoRatio ? 'md:grid md:grid-cols-1 md:grid-rows-1' : 'md:flex md:items-center' }} text-white">
        @if ($heroBgUrl)
            <img src="{{ $heroBgUrl }}" alt="Hero Background" class="pointer-events-none {{ $isAutoRatio ? 'absolute inset-0 h-full w-full object-cover object-[72%_70%] md:static md:col-start-1 md:row-start-1 md:h-auto md:w-full md:self-stretch md:object-cover md:object-center' : 'absolute inset-0 h-full w-full ' . $heroDisplay['fitClass'] . ' ' . $heroDisplay['positionClass'] }}">
            <div class="pointer-events-none {{ $isAutoRatio ? 'absolute inset-0 md:col-start-1 md:row-start-1' : 'absolute inset-0' }} {{ $heroDisplay['overlayClass'] }}"></div>
        @else
            <div class="pointer-events-none absolute -right-24 -top-24 h-96 w-96 rounded-full bg-kee-500/20 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-32 -left-24 h-96 w-96 rounded-full bg-blue-500/10 blur-3xl"></div>
        @endif
        <div class="x-container relative {{ $heroDisplay['paddingClass'] }} {{ $isAutoRatio ? 'md:col-start-1 md:row-start-1 md:z-10 md:self-center' : '' }}">
            <div class="max-w-3xl">
                <span class="x-badge bg-amber-500/15 text-amber-300 ring-1 ring-amber-400/25">PC Parts • PC Builder • IT Service</span>

                <h1 class="mt-4 text-4xl font-extrabold leading-[1.1] tracking-tight sm:text-5xl lg:text-6xl">
                    Build Your PC.<br>
                    <span class="text-amber-400">Your Way.</span>
                </h1>

                <p class="mt-4 max-w-xl text-sm leading-relaxed text-slate-300 sm:text-base lg:text-lg">
                    Temukan komponen PC, buat PC rakitan sesuai budget, dan dapatkan bantuan dari tim KeeHub.
                </p>

                @php
                    $heroHighlights = [
                        [
                            'label' => "Rakit PC\nCustom",
                            'href' => route('builder.index'),
                            'icon' => 'M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-2.25-2.25l3.276-3.276a4.5 4.5 0 00-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437l1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008z',
                        ],
                        [
                            'label' => "Servis\nPC / Laptop",
                            'href' => route('service.create'),
                            'icon' => 'M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25',
                        ],
                        [
                            'label' => "Upgrade\nHardware",
                            'href' => route('shop.index'),
                            'icon' => 'M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941',
                        ],
                        [
                            'label' => "Cek Kompatibel\n& Watt",
                            'href' => route('builder.index'),
                            'icon' => 'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z',
                        ],
                        [
                            'label' => "Komponen\nPC Original",
                            'href' => route('shop.index'),
                            'icon' => 'M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9',
                        ],
                    ];
                @endphp

                <div class="mt-6 grid grid-cols-2 gap-2.5 sm:flex sm:flex-wrap sm:gap-3">
                    @foreach ($heroHighlights as $item)
                        <a href="{{ $item['href'] }}"
                           class="group flex items-center gap-2.5 rounded-2xl border border-white/15 bg-slate-900/70 px-3.5 py-2.5 backdrop-blur-md transition hover:-translate-y-0.5 hover:border-amber-400/50 hover:bg-slate-900/90">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-white/10 text-amber-400 transition group-hover:bg-amber-500/20">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" />
                                </svg>
                            </span>
                            <span class="whitespace-pre-line text-xs font-medium leading-tight text-slate-100">{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                </div>

                <div class="mt-7 flex flex-wrap items-center gap-3">
                    <a href="{{ route('builder.index') }}"
                       class="inline-flex items-center gap-2 rounded-full bg-amber-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-amber-600/25 transition hover:bg-amber-500">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12H3m18 0h-1.5m-15 3.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21m-9-1.5h10.5a2.25 2.25 0 002.25-2.25V6.75a2.25 2.25 0 00-2.25-2.25H6.75A2.25 2.25 0 004.5 6.75v10.5a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                        <span>Mulai PC Builder</span>
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>

                    <a href="{{ route('shop.index') }}"
                       class="inline-flex items-center gap-2 rounded-full border border-white/25 bg-slate-900/50 px-6 py-3 text-sm font-semibold text-white backdrop-blur-md transition hover:border-white/40 hover:bg-white/15">
                        <svg class="h-4 w-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007z" />
                        </svg>
                        <span>Belanja Part</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="flex flex-col gap-7 py-6 md:gap-8 md:py-8">
        {{-- Categories --}}
        <section class="x-container">
            <h2 class="x-section-title">Kategori</h2>
            <div class="mt-3.5 grid grid-cols-3 gap-2.5 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-7">
                @foreach ($categories as $category)
                    <a href="{{ route('shop.index', ['category' => $category->slug]) }}" class="x-card group flex flex-col items-center gap-2 p-3 text-center transition hover:-translate-y-0.5 hover:shadow-md">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500/10 text-base font-semibold text-amber-600 transition group-hover:bg-amber-600 group-hover:text-white dark:text-amber-400">{{ strtoupper(mb_substr($category->name, 0, 1)) }}</span>
                        <span class="text-xs font-medium text-slate-700 dark:text-slate-200">{{ $category->name }}</span>
                    </a>
                @endforeach
            </div>
        </section>

        {{-- Builder CTA --}}
        <section class="x-container">
            <div class="overflow-hidden rounded-3xl bg-gradient-to-r from-kee-500 to-kee-600 p-1">
                <div class="grid gap-4 rounded-[calc(1.5rem-1px)] bg-gray-950 p-6 md:grid-cols-[1fr_auto] md:items-center">
                    <div>
                        <h2 class="text-2xl font-bold text-white">Bingung memilih komponen?</h2>
                        <p class="mt-1.5 text-gray-400">Masukkan budget dan kebutuhanmu — sistem cek kompatibilitas otomatis dan hitung daya real-time.</p>
                    </div>
                    <a href="{{ route('builder.index') }}" class="x-btn-primary w-fit whitespace-nowrap">Buat Build PC →</a>
                </div>
            </div>
        </section>

        {{-- Best Seller --}}
        @if ($bestSellers->isNotEmpty())
            <section class="x-container">
                <div class="flex items-center justify-between">
                    <h2 class="x-section-title">Best Seller</h2>
                    <a href="{{ route('shop.index') }}" class="text-sm font-semibold text-kee-600 hover:underline dark:text-kee-400">Lihat semua →</a>
                </div>
                <div class="mt-3.5 grid grid-cols-2 gap-3.5 sm:grid-cols-3 lg:grid-cols-4">
                    @foreach ($bestSellers as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
            </section>
        @endif

        {{-- Newest --}}
        <section class="x-container">
            <h2 class="x-section-title">Produk Terbaru</h2>
            <div class="mt-3.5 grid grid-cols-2 gap-3.5 sm:grid-cols-3 lg:grid-cols-4">
                @foreach ($newest as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </section>

        {{-- Service CTA --}}
        <section class="x-container">
            <div class="x-card grid gap-4 p-6 md:grid-cols-[1fr_auto] md:items-center">
                <div>
                    <h2 class="x-section-title">Punya PC bermasalah?</h2>
                    <p class="mt-1.5 text-gray-600 dark:text-gray-400">Service PC, rakit PC, cleaning, thermal paste, install Windows — dikerjakan teknisi berpengalaman dengan QC menyeluruh.</p>
                </div>
                <a href="{{ route('service.create') }}" class="x-btn-dark w-fit whitespace-nowrap">Request Service</a>
            </div>
        </section>
    </div>
</div>
@endsection
