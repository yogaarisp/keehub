@extends('layouts.storefront')

@section('title', 'Build '.$build->code.' — KeeHub')

@section('content')
<div class="x-container py-8">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="x-section-title font-mono">{{ $build->code }}</h1>
            <p class="mt-1 text-sm text-gray-500">
                @if ($build->name) {{ $build->name }} • @endif
                @if ($build->purpose) {{ ucfirst($build->purpose) }} • @endif
                Build read-only
            </p>
        </div>
        <span class="x-badge @if ($compatibility['overall'] === 'compatible') bg-green-100 text-green-700 @elseif ($compatibility['overall'] === 'warning') bg-yellow-100 text-yellow-700 @else bg-red-100 text-red-700 @endif px-4 py-1.5 text-xs">
            @if ($compatibility['overall'] === 'compatible') ✓ COMPATIBLE @elseif ($compatibility['overall'] === 'warning') ⚠ WARNING @else ✕ INCOMPATIBLE @endif
        </span>
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-[1fr_20rem]">
        <div class="x-card divide-y divide-gray-100 dark:divide-gray-800">
            @forelse ($build->items as $item)
                @if ($item->product)
                    <div class="flex items-center justify-between gap-3 p-4">
                        <div class="min-w-0">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400">{{ $item->slot }}</p>
                            <p class="truncate font-semibold text-gray-900 dark:text-white">{{ $item->product->name }}</p>
                            <p class="text-xs text-gray-400">{{ $item->product->brand?->name }}</p>
                        </div>
                        <span class="shrink-0 font-bold text-kee-600 dark:text-kee-400">Rp{{ number_format($item->price, 0, ',', '.') }}</span>
                    </div>
                @endif
            @empty
                <p class="p-10 text-center text-sm text-gray-400">Build kosong.</p>
            @endforelse
        </div>

        <div class="h-fit space-y-5">
            <div class="x-card p-5">
                <div class="flex justify-between text-lg"><span class="font-bold">TOTAL</span><span class="font-extrabold text-kee-600 dark:text-kee-400">Rp{{ number_format($build->total_price, 0, ',', '.') }}</span></div>
                @if ($power['total'] > 0)
                    <div class="mt-4 rounded-xl bg-gray-50 p-4 text-sm dark:bg-gray-800/60">
                        <p class="text-xs font-bold uppercase tracking-wide text-gray-400">Estimasi Daya</p>
                        <div class="mt-2 flex justify-between"><span class="text-gray-500">Total</span><span class="font-bold">{{ $power['total'] }}W</span></div>
                    </div>
                @endif
                <a href="{{ route('builder.index', ['build' => $build->id]) }}" class="x-btn-outline mt-4 w-full">Customize Build →</a>
            </div>

            <div class="x-card p-5">
                <h2 class="text-sm font-bold text-gray-900 dark:text-white">Compatibility</h2>
                <div class="mt-3 space-y-2 text-xs">
                    @foreach ($compatibility['checks'] as $check)
                        <div class="flex items-start gap-2">
                            <span class="{{ $check['status'] === 'compatible' ? 'text-green-500' : ($check['status'] === 'warning' ? 'text-yellow-500' : 'text-red-500') }}">
                                {{ $check['status'] === 'compatible' ? '✓' : ($check['status'] === 'warning' ? '⚠' : '✕') }}
                            </span>
                            <div>
                                <p class="font-semibold">{{ $check['title'] }}</p>
                                <p class="text-gray-500">{{ $check['message'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
