@extends('layouts.storefront')

@section('title', 'Account — KeeHub')

@section('content')
<div class="x-container py-8">
    <div class="x-card p-6">
        <div class="flex items-center gap-4">
            <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-kee-500 text-xl font-extrabold text-gray-950">{{ strtoupper(mb_substr($user->name, 0, 1)) }}</span>
            <div>
                <h1 class="text-lg font-extrabold text-gray-900 dark:text-white">{{ $user->name }}</h1>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>
            </div>
        </div>
    </div>

    <div class="mt-6 grid gap-4 sm:grid-cols-3">
        <a href="{{ route('account.orders') }}" class="x-card p-5 transition hover:shadow-md">
            <p class="text-3xl font-extrabold text-kee-600 dark:text-kee-400">{{ $totalOrders }}</p>
            <p class="mt-1 text-sm font-medium text-gray-600 dark:text-gray-400">Total Order</p>
        </a>
        <a href="{{ route('account.builds') }}" class="x-card p-5 transition hover:shadow-md">
            <p class="text-3xl font-extrabold text-kee-600 dark:text-kee-400">{{ $builds->count() }}</p>
            <p class="mt-1 text-sm font-medium text-gray-600 dark:text-gray-400">PC Build Tersimpan</p>
        </a>
        <form method="POST" action="{{ route('logout') }}" class="contents">
            @csrf
            <button type="submit" class="x-card flex flex-col justify-center p-5 text-left transition hover:shadow-md">
                <p class="font-semibold text-red-500">Logout</p>
                <p class="mt-1 text-sm text-gray-500">Keluar dari akun</p>
            </button>
        </form>
    </div>

    <div class="mt-8">
        <div class="flex items-center justify-between">
            <h2 class="x-section-title">Order Terakhir</h2>
            <a href="{{ route('account.orders') }}" class="text-sm font-semibold text-kee-600 hover:underline dark:text-kee-400">Semua →</a>
        </div>
        @if ($orders->isEmpty())
            <div class="x-card mt-4 p-10 text-center text-sm text-gray-500">Belum ada order.</div>
        @else
            <div class="mt-4 space-y-3">
                @foreach ($orders as $order)
                    <a href="{{ route('account.orders.show', $order) }}" class="x-card flex items-center justify-between gap-3 p-4 transition hover:shadow-md">
                        <div>
                            <span class="font-mono text-sm font-semibold text-gray-900 dark:text-white">{{ $order->code }}</span>
                            <p class="text-xs text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-gray-900 dark:text-white">Rp{{ number_format($order->total, 0, ',', '.') }}</p>
                            <span class="x-badge bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300">{{ ucfirst($order->status) }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
