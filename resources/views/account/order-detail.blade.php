@extends('layouts.storefront')

@section('title', 'Order '.$order->code.' — KeeHub')

@section('content')
<div class="x-container py-8">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="x-section-title font-mono">{{ $order->code }}</h1>
            <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</p>
        </div>
        <span class="x-badge px-4 py-1.5 text-xs {{ ['pending' => 'bg-yellow-100 text-yellow-700', 'confirmed' => 'bg-blue-100 text-blue-700', 'processing' => 'bg-blue-100 text-blue-700', 'ready' => 'bg-indigo-100 text-indigo-700', 'shipped' => 'bg-indigo-100 text-indigo-700', 'completed' => 'bg-green-100 text-green-700', 'cancelled' => 'bg-red-100 text-red-700'][$order->status] }}">{{ ucfirst($order->status) }}</span>
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-[1fr_20rem]">
        <div class="space-y-5">
            <div class="x-card p-5">
                <h2 class="font-bold text-gray-900 dark:text-white">Items</h2>
                <div class="mt-3 divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach ($order->items as $item)
                        <div class="flex justify-between gap-3 py-3 text-sm">
                            <div>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $item->name }}</span>
                                <span class="ml-2 text-xs text-gray-400">× {{ $item->quantity }}</span>
                                @if ($item->item_type === 'customer_owned')
                                    <span class="x-badge ml-1 bg-gray-100 text-gray-500 dark:bg-gray-800">Customer Owned</span>
                                @endif
                            </div>
                            <span class="font-semibold">Rp{{ number_format($item->total, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            @if ($order->statusHistory->isNotEmpty())
                <div class="x-card p-5">
                    <h2 class="font-bold text-gray-900 dark:text-white">Riwayat Status</h2>
                    <div class="mt-3 space-y-3">
                        @foreach ($order->statusHistory as $history)
                            <div class="flex items-center gap-3 text-sm">
                                <span class="h-2 w-2 rounded-full bg-kee-500"></span>
                                <span class="font-semibold capitalize">{{ ucfirst($history->to_status) }}</span>
                                <span class="text-xs text-gray-400">{{ $history->created_at->format('d M Y H:i') }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div class="h-fit space-y-5">
            @if ($order->invoice)
                <div class="x-card p-5">
                    <h2 class="font-bold text-gray-900 dark:text-white">Invoice</h2>
                    <p class="mt-1 font-mono text-sm text-gray-500">{{ $order->invoice->code }}</p>
                    <div class="mt-4 space-y-2 text-sm">
                        <div class="flex justify-between"><span class="text-gray-500">Total</span><span class="font-semibold">Rp{{ number_format($order->invoice->total, 0, ',', '.') }}</span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Dibayar</span><span class="font-semibold">Rp{{ number_format($order->invoice->paid_amount, 0, ',', '.') }}</span></div>
                        <div class="flex justify-between border-t border-gray-100 pt-2 dark:border-gray-800"><span class="font-bold">Sisa</span><span class="font-extrabold {{ $order->invoice->remainingAmount() > 0 ? 'text-red-500' : 'text-green-500' }}">Rp{{ number_format($order->invoice->remainingAmount(), 0, ',', '.') }}</span></div>
                    </div>
                    <span class="x-badge mt-3 {{ ['unpaid' => 'bg-red-100 text-red-700', 'partial' => 'bg-yellow-100 text-yellow-700', 'paid' => 'bg-green-100 text-green-700', 'void' => 'bg-gray-100 text-gray-500'][$order->invoice->status] ?? '' }}">{{ strtoupper($order->invoice->status) }}</span>
                </div>
            @endif

            @if ($order->shipment)
                <div class="x-card p-5">
                    <h2 class="font-bold text-gray-900 dark:text-white">Pengiriman</h2>
                    @if ($order->shipment->is_pickup)
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Pickup at Store</p>
                    @else
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ $order->shipment->courier }}</p>
                        @if ($order->shipment->tracking_number)
                            <p class="mt-1 font-mono text-sm font-semibold">Resi: {{ $order->shipment->tracking_number }}</p>
                        @endif
                    @endif
                    <span class="x-badge mt-3 bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300">{{ ucfirst($order->shipment->status) }}</span>
                </div>
            @endif

            <a href="{{ route('account.orders') }}" class="x-btn-outline w-full">← Kembali ke Orders</a>
        </div>
    </div>
</div>
@endsection
