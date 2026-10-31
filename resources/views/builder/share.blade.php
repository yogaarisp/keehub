@extends('layouts.storefront')

@section('title', 'Spesifikasi Rakitan '.$build->code.' — KeeHub')

@section('content')
<div class="x-container py-6 sm:py-8 pb-28 md:pb-12">
    {{-- Header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between border-b border-gray-100 pb-5 dark:border-gray-800">
        <div>
            <div class="flex items-center gap-2">
                <span class="rounded bg-gray-100 px-2 py-0.5 font-mono text-xs font-bold text-gray-700 dark:bg-gray-800 dark:text-gray-300">{{ $build->code }}</span>
                <span class="text-xs text-gray-400">• Build Publik</span>
            </div>
            <h1 class="mt-1 text-2xl font-extrabold text-gray-900 sm:text-3xl dark:text-white">{{ $build->name ?: 'Rakitan PC '.$build->code }}</h1>
            <p class="mt-1 text-xs sm:text-sm text-gray-500">
                @if ($build->purpose) Kebutuhan: <span class="font-semibold text-gray-700 dark:text-gray-300 capitalize">{{ $build->purpose }}</span> • @endif
                Disusun via KeeHub PC Builder
            </p>
        </div>

        <div>
            @if ($compatibility['overall'] === 'compatible')
                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3.5 py-1.5 text-xs font-bold text-emerald-700 ring-1 ring-emerald-600/20 dark:bg-emerald-950/40 dark:text-emerald-400">
                    <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd"/></svg>
                    Semua Kompatibel
                </span>
            @elseif ($compatibility['overall'] === 'warning')
                <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-3.5 py-1.5 text-xs font-bold text-amber-700 ring-1 ring-amber-600/20 dark:bg-amber-950/40 dark:text-amber-400">
                    <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/></svg>
                    Perlu Perhatian
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-50 px-3.5 py-1.5 text-xs font-bold text-rose-700 ring-1 ring-rose-600/20 dark:bg-rose-950/40 dark:text-rose-400">
                    <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd"/></svg>
                    Tidak Kompatibel
                </span>
            @endif
        </div>
    </div>

    {{-- Content Layout --}}
    <div class="mt-6 grid gap-6 lg:grid-cols-[1fr_20rem]">
        {{-- Components List --}}
        <div class="x-card divide-y divide-gray-100 overflow-hidden dark:divide-gray-800">
            @forelse ($build->items as $item)
                @if ($item->product)
                    <div class="flex items-center justify-between gap-3 p-3.5 sm:p-4 hover:bg-gray-50/50 dark:hover:bg-gray-800/40 transition">
                        <div class="min-w-0 flex-1">
                            <span class="rounded bg-gray-100 px-1.5 py-0.5 text-[10px] font-bold text-gray-500 uppercase tracking-wider dark:bg-gray-800 dark:text-gray-400">{{ $item->slot }}</span>
                            <h4 class="mt-1 truncate text-sm font-bold text-gray-900 dark:text-white">{{ $item->product->name }}</h4>
                            <p class="text-xs text-gray-400">{{ $item->product->brand?->name }}</p>
                        </div>
                        <span class="shrink-0 text-sm sm:text-base font-extrabold text-kee-600 dark:text-kee-400">Rp{{ number_format($item->price, 0, ',', '.') }}</span>
                    </div>
                @endif
            @empty
                <div class="py-12 text-center text-gray-400">
                    <p class="text-sm">Tidak ada komponen dalam rakitan ini.</p>
                </div>
            @endforelse
        </div>

        {{-- Sidebar Summary --}}
        <div class="h-fit space-y-4">
            <div class="x-card p-5">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Total Harga</span>
                    <p class="text-2xl font-extrabold text-kee-600 dark:text-kee-400">Rp{{ number_format($build->total_price, 0, ',', '.') }}</p>
                </div>

                @if ($power['total'] > 0)
                    <div class="mt-4 rounded-xl bg-gray-50 p-3.5 text-xs dark:bg-gray-800/60">
                        <div class="flex items-center justify-between font-bold">
                            <span class="uppercase tracking-wider text-[10px] text-gray-400">Estimasi Daya</span>
                            <span>{{ $power['total'] }} Watt</span>
                        </div>
                    </div>
                @endif

                <a href="{{ route('builder.index', ['build' => $build->id]) }}" class="x-btn-primary mt-4 w-full !py-2.5 text-xs font-bold">
                    Kustomisasi Build Ini →
                </a>
            </div>

            @if (!empty($compatibility['checks']))
                <div class="x-card p-5">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400">Status Kompatibilitas</h3>
                    <div class="mt-3 space-y-2 text-xs">
                        @foreach ($compatibility['checks'] as $check)
                            <div class="flex items-start gap-2">
                                <span class="shrink-0 mt-0.5 font-bold {{ $check['status'] === 'compatible' ? 'text-emerald-500' : ($check['status'] === 'warning' ? 'text-amber-500' : 'text-rose-500') }}">
                                    {{ $check['status'] === 'compatible' ? '✓' : ($check['status'] === 'warning' ? '⚠' : '✕') }}
                                </span>
                                <div>
                                    <p class="font-semibold text-gray-800 dark:text-gray-200">{{ $check['title'] }}</p>
                                    <p class="text-[11px] text-gray-500 dark:text-gray-400">{{ $check['message'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
