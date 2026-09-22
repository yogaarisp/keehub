@extends('layouts.storefront')

@section('title', 'Orders — KeeHub Account')

@section('content')
<div class="x-container py-8">
    <div class="flex items-center justify-between">
        <h1 class="x-section-title">Order Saya</h1>
        <a href="{{ route('account.dashboard') }}" class="text-sm text-gray-500 hover:text-kee-600">← Dashboard</a>
    </div>

    @if ($orders->isEmpty())
        <div class="x-card mt-6 p-10 text-center text-sm text-gray-500">Belum ada order. <a href="{{ route('shop.index') }}" class="font-semibold text-kee-600 hover:underline">Mulai belanja →</a></div>
    @else
        <div class="mt-6 space-y-3">
            @foreach ($orders as $order)
                <a href="{{ route('account.orders.show', $order) }}" class="x-card flex flex-wrap items-center justify-between gap-3 p-4 transition hover:shadow-md">
                    <div>
                        <span class="font-mono text-sm font-semibold text-gray-900 dark:text-white">{{ $order->code }}</span>
                        <p class="text-xs text-gray-500">{{ $order->created_at->format('d M Y H:i') }} • {{ $order->items->count() }} item</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="x-badge bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300">{{ ucfirst($order->status) }}</span>
                        <span class="font-bold text-gray-900 dark:text-white">Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="mt-6">{{ $orders->links() }}</div>
    @endif
</div>
@endsection
