@extends('layouts.storefront')

@section('title', 'PC Rakitan — PC Build Siap Beli | KeeHub')

@section('content')
<div class="x-container py-8">
    <h1 class="x-section-title">PC Rakitan</h1>
    <p class="mt-1 text-sm text-gray-500">PC build siap pakai dari tim KeeHub — sudah through QC dan kompatibel 100%.</p>

    <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($categories as $category)
            <div class="x-card p-6 transition hover:shadow-md">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-kee-500/10 text-lg font-bold text-kee-600 dark:text-kee-400">{{ strtoupper(mb_substr($category['name'], 0, 1)) }}</span>
                <h2 class="mt-3 font-bold text-gray-900 dark:text-white">{{ $category['name'] }}</h2>
                <p class="mt-1 text-sm text-gray-500">{{ $category['desc'] }}</p>
                <a href="{{ route('service.create') }}" class="mt-4 inline-block text-sm font-semibold text-kee-600 hover:underline dark:text-kee-400">Minta build kategori ini →</a>
            </div>
        @endforeach
    </div>

    <div class="mt-10">
        <h2 class="x-section-title">Paket Populer</h2>
        <div class="mt-5 grid gap-4 md:grid-cols-3">
            @foreach ($packages as $package)
                <div class="x-card flex flex-col p-6">
                    <span class="x-badge w-fit bg-kee-500/15 text-kee-700 dark:text-kee-400">{{ ucfirst($package['purpose']) }}</span>
                    <h3 class="mt-3 font-bold text-gray-900 dark:text-white">{{ $package['name'] }}</h3>
                    <p class="mt-1 flex-1 text-sm text-gray-500">{{ $package['desc'] }}</p>
                    <div class="mt-4 flex gap-2">
                        <a href="{{ route('service.create') }}" class="x-btn-primary flex-1 !py-2 text-xs">Beli Build</a>
                        <a href="{{ route('builder.index') }}" class="x-btn-outline flex-1 !py-2 text-xs">Customize</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="mt-10">
        <h2 class="x-section-title">Komponen Populer</h2>
        <div class="mt-5 grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
            @foreach ($featured as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </div>
</div>
@endsection
