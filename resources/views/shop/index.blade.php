@extends('layouts.storefront')

@section('title', 'KeeHub — Build Your PC. Your Way.')

@section('content')
<div>
    {{-- Hero --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-gray-950 via-gray-900 to-gray-800 text-white">
        <div class="pointer-events-none absolute -right-24 -top-24 h-96 w-96 rounded-full bg-kee-500/20 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-32 -left-24 h-96 w-96 rounded-full bg-blue-500/10 blur-3xl"></div>
        <div class="x-container relative grid gap-10 py-16 md:grid-cols-2 md:items-center md:py-24">
            <div>
                <span class="x-badge bg-kee-500/15 text-kee-300">PC Parts • PC Builder • IT Service</span>
                <h1 class="mt-4 text-4xl font-extrabold leading-tight tracking-tight sm:text-5xl">Build Your PC.<br><span class="text-kee-400">Your Way.</span></h1>
                <p class="mt-4 max-w-md text-base text-gray-300 sm:text-lg">Temukan komponen PC, buat PC rakitan sesuai budget, dan dapatkan bantuan dari tim KeeHub.</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('builder.index') }}" class="x-btn-primary !px-6 !py-3">Mulai PC Builder</a>
                    <a href="{{ route('shop.index') }}" class="x-btn !bg-white/10 !text-white backdrop-blur hover:!bg-white/20">Belanja Part</a>
                </div>
            </div>
            <div class="hidden justify-center md:flex">
                <div class="rounded-3xl border border-white/10 bg-white/5 p-6 backdrop-blur">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Build Summary</p>
                    <div class="mt-3 space-y-2 text-sm">
                        <div class="flex justify-between gap-8"><span class="text-gray-400">CPU</span><span class="font-mono">Ryzen 5 5600</span></div>
                        <div class="flex justify-between gap-8"><span class="text-gray-400">Motherboard</span><span class="font-mono">B550M</span></div>
                        <div class="flex justify-between gap-8"><span class="text-gray-400">GPU</span><span class="font-mono">RTX 4060</span></div>
                        <div class="flex justify-between gap-8"><span class="text-gray-400">RAM</span><span class="font-mono">16GB DDR4</span></div>
                        <div class="mt-3 border-t border-white/10 pt-3 text-lg"><span class="text-gray-400">TOTAL </span><span class="font-bold text-kee-400">Rp9.750.000</span></div>
                    </div>
                    <span class="x-badge mt-4 bg-green-500/15 text-green-400">✓ Compatible</span>
                </div>
            </div>
        </div>
    </section>

    {{-- Categories --}}
    <section class="x-container py-10">
        <h2 class="x-section-title">Kategori</h2>
        <div class="mt-5 grid grid-cols-3 gap-3 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-7">
            @foreach ($categories as $category)
                <a href="{{ route('shop.index', ['category' => $category->slug]) }}" class="x-card group flex flex-col items-center gap-2 p-4 text-center transition hover:-translate-y-0.5 hover:shadow-md">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-kee-500/10 text-base font-bold text-kee-600 group-hover:bg-kee-500 group-hover:text-gray-950 dark:text-kee-400">{{ strtoupper(mb_substr($category->name, 0, 1)) }}</span>
                    <span class="text-xs font-semibold text-gray-800 dark:text-gray-200">{{ $category->name }}</span>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Builder CTA --}}
    <section class="x-container py-6">
        <div class="overflow-hidden rounded-3xl bg-gradient-to-r from-kee-500 to-kee-600 p-1">
            <div class="grid gap-6 rounded-[calc(1.5rem-1px)] bg-gray-950 p-8 md:grid-cols-[1fr_auto] md:items-center">
                <div>
                    <h2 class="text-2xl font-bold text-white">Bingung memilih komponen?</h2>
                    <p class="mt-2 text-gray-400">Masukkan budget dan kebutuhanmu — sistem cek kompatibilitas otomatis dan hitung daya real-time.</p>
                </div>
                <a href="{{ route('builder.index') }}" class="x-btn-primary w-fit whitespace-nowrap">Buat Build PC →</a>
            </div>
        </div>
    </section>

    {{-- Best Seller --}}
    @if ($bestSellers->isNotEmpty())
        <section class="x-container py-10">
            <div class="flex items-center justify-between">
                <h2 class="x-section-title">Best Seller</h2>
                <a href="{{ route('shop.index') }}" class="text-sm font-semibold text-kee-600 hover:underline dark:text-kee-400">Lihat semua →</a>
            </div>
            <div class="mt-5 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                @foreach ($bestSellers as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </section>
    @endif

    {{-- Newest --}}
    <section class="x-container py-10">
        <h2 class="x-section-title">Produk Terbaru</h2>
        <div class="mt-5 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
            @foreach ($newest as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </section>

    {{-- Service CTA --}}
    <section class="x-container py-10">
        <div class="x-card grid gap-6 p-8 md:grid-cols-[1fr_auto] md:items-center">
            <div>
                <h2 class="x-section-title">Punya PC bermasalah?</h2>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Service PC, rakit PC, cleaning, thermal paste, install Windows — dikerjakan teknisi berpengalaman dengan QC menyeluruh.</p>
            </div>
            <a href="{{ route('service.create') }}" class="x-btn-dark w-fit whitespace-nowrap">Request Service</a>
        </div>
    </section>
</div>
@endsection
