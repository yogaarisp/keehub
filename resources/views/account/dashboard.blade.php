@extends('layouts.storefront')

@section('title', 'Account — KeeHub')

@section('content')
<div class="x-container py-8">
    <div class="x-card p-6">
        <div class="flex items-center gap-4">
            <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-amber-500 to-amber-600 text-xl font-bold text-white shadow-sm shadow-amber-500/20">{{ strtoupper(mb_substr($user->name, 0, 1)) }}</span>
            <div>
                <h1 class="text-lg font-semibold text-slate-900 dark:text-slate-100">{{ $user->name }}</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">{{ $user->email }}</p>
            </div>
        </div>
    </div>

    <div class="mt-6 grid gap-4 sm:grid-cols-3">
        <a href="{{ route('account.orders') }}" class="x-card p-5 transition hover:shadow-md">
            <p class="text-3xl font-bold tabular-nums text-amber-600 dark:text-amber-400">{{ $totalOrders }}</p>
            <p class="mt-1 text-sm font-medium text-slate-600 dark:text-slate-400">Total Order</p>
        </a>
        <a href="{{ route('account.builds') }}" class="x-card p-5 transition hover:shadow-md">
            <p class="text-3xl font-bold tabular-nums text-amber-600 dark:text-amber-400">{{ $builds->count() }}</p>
            <p class="mt-1 text-sm font-medium text-slate-600 dark:text-slate-400">PC Build Tersimpan</p>
        </a>
        <form method="POST" action="{{ route('logout') }}" class="contents">
            @csrf
            <button type="submit" class="x-card flex flex-col justify-center p-5 text-left transition hover:shadow-md">
                <p class="font-semibold text-rose-600 dark:text-rose-400">Logout</p>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Keluar dari akun</p>
            </button>
        </form>
    </div>

    <div class="mt-8">
        <div class="flex items-center justify-between">
            <h2 class="x-section-title">Order Terakhir</h2>
            <a href="{{ route('account.orders') }}" class="text-sm font-medium text-amber-600 hover:underline dark:text-amber-400">Semua →</a>
        </div>
        @if ($orders->isEmpty())
            <div class="x-card mt-4 p-10 text-center text-sm text-slate-500 dark:text-slate-400">Belum ada order.</div>
        @else
            <div class="mt-4 space-y-3">
                @foreach ($orders as $order)
                    <a href="{{ route('account.orders.show', $order) }}" class="x-card flex items-center justify-between gap-3 p-4 transition hover:shadow-md">
                        <div>
                            <span class="font-mono text-sm font-semibold text-slate-800 dark:text-slate-100">{{ $order->code }}</span>
                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ $order->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-semibold tabular-nums text-slate-900 dark:text-slate-100">Rp{{ number_format($order->total, 0, ',', '.') }}</p>
                            <span class="x-badge bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300">{{ ucfirst($order->status) }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
