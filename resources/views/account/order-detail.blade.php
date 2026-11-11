@extends('layouts.storefront')

@section('title', 'Order '.$order->code.' — KeeHub')

@section('content')
<div class="x-container py-8">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="x-section-title font-mono">{{ $order->code }}</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">{{ $order->created_at->format('d M Y H:i') }}</p>
        </div>
        <span class="x-badge px-4 py-1.5 text-xs {{ ['pending' => 'bg-amber-50 text-amber-700 ring-1 ring-amber-600/20', 'confirmed' => 'bg-blue-50 text-blue-700', 'processing' => 'bg-blue-50 text-blue-700', 'ready' => 'bg-indigo-50 text-indigo-700', 'shipped' => 'bg-indigo-50 text-indigo-700', 'completed' => 'bg-emerald-50 text-emerald-700', 'cancelled' => 'bg-rose-50 text-rose-700'][$order->status] }}">{{ ucfirst($order->status) }}</span>
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-[1fr_20rem]">
        <div class="space-y-5">
            <div class="x-card p-5">
                <h2 class="font-semibold text-slate-800 dark:text-slate-100">Items</h2>
                <div class="mt-3 divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach ($order->items as $item)
                        <div class="flex justify-between gap-3 py-3 text-sm">
                            <div>
                                <span class="font-medium text-slate-800 dark:text-slate-100">{{ $item->name }}</span>
                                <span class="ml-2 text-xs text-slate-400">× {{ $item->quantity }}</span>
                                @if ($item->item_type === 'customer_owned')
                                    <span class="x-badge ml-1 bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400">Customer Owned</span>
                                @endif
                            </div>
                            <span class="font-semibold tabular-nums">Rp{{ number_format($item->total, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            @if ($order->statusHistory->isNotEmpty())
                <div class="x-card p-5">
                    <h2 class="font-semibold text-slate-800 dark:text-slate-100">Riwayat Status</h2>
                    <div class="mt-3 space-y-3">
                        @foreach ($order->statusHistory as $history)
                            <div class="flex items-center gap-3 text-sm">
                                <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                                <span class="font-medium capitalize text-slate-700 dark:text-slate-200">{{ ucfirst($history->to_status) }}</span>
                                <span class="text-xs text-slate-400">{{ $history->created_at->format('d M Y H:i') }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div class="h-fit space-y-5">
            @if ($order->invoice)
                <div class="x-card p-5">
                    <h2 class="font-semibold text-slate-800 dark:text-slate-100">Invoice</h2>
                    <p class="mt-1 font-mono text-sm text-slate-500 dark:text-slate-400">{{ $order->invoice->code }}</p>
                    <div class="mt-4 space-y-2 text-sm">
                        <div class="flex justify-between"><span class="text-slate-500 dark:text-slate-400">Total</span><span class="font-medium tabular-nums">Rp{{ number_format($order->invoice->total, 0, ',', '.') }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-500 dark:text-slate-400">Dibayar</span><span class="font-medium tabular-nums">Rp{{ number_format($order->invoice->paid_amount, 0, ',', '.') }}</span></div>
                        <div class="flex justify-between border-t border-slate-100 pt-2 dark:border-slate-800"><span class="font-semibold">Sisa</span><span class="font-semibold tabular-nums {{ $order->invoice->remainingAmount() > 0 ? 'text-rose-600 dark:text-rose-400' : 'text-emerald-600 dark:text-emerald-400' }}">Rp{{ number_format($order->invoice->remainingAmount(), 0, ',', '.') }}</span></div>
                    </div>
                    <span class="x-badge mt-3 {{ ['unpaid' => 'bg-rose-50 text-rose-700 dark:bg-rose-950/50 dark:text-rose-400', 'partial' => 'bg-amber-50 text-amber-700 dark:bg-amber-950/50 dark:text-amber-400', 'paid' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/50 dark:text-emerald-400', 'void' => 'bg-slate-100 text-slate-500'][$order->invoice->status] ?? '' }}">{{ strtoupper($order->invoice->status) }}</span>
                </div>
            @endif

            @if ($order->shipment)
                <div class="x-card p-5">
                    <h2 class="font-semibold text-slate-800 dark:text-slate-100">Pengiriman</h2>
                    @if ($order->shipment->is_pickup)
                        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Pickup at Store</p>
                    @else
                        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">{{ $order->shipment->courier }}</p>
                        @if ($order->shipment->tracking_number)
                            <p class="mt-1 font-mono text-sm font-medium">Resi: {{ $order->shipment->tracking_number }}</p>
                        @endif
                    @endif
                    <span class="x-badge mt-3 bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300">{{ ucfirst($order->shipment->status) }}</span>
                </div>
            @endif

            <a href="{{ route('account.orders') }}" class="x-btn-outline w-full">← Kembali ke Orders</a>
        </div>
    </div>
</div>
@endsection
