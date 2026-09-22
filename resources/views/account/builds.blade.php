@extends('layouts.storefront')

@section('title', 'PC Builds — KeeHub Account')

@section('content')
<div class="x-container py-8">
    <div class="flex items-center justify-between">
        <h1 class="x-section-title">PC Build Saya</h1>
        <a href="{{ route('builder.index') }}" class="x-btn-primary !px-3 !py-1.5 text-xs">+ Build Baru</a>
    </div>

    @if ($builds->isEmpty())
        <div class="x-card mt-6 p-10 text-center text-sm text-gray-500">Belum ada build. Coba <a href="{{ route('builder.index') }}" class="font-semibold text-kee-600 hover:underline">PC Builder →</a></div>
    @else
        <div class="mt-6 space-y-3">
            @foreach ($builds as $build)
                <a href="{{ route('builder.show', $build->share_token ?? $build->id) }}" class="x-card flex flex-wrap items-center justify-between gap-3 p-4 transition hover:shadow-md">
                    <div>
                        <span class="font-mono text-sm font-semibold">{{ $build->code }}</span>
                        @if ($build->purpose)
                            <span class="ml-2 text-xs capitalize text-gray-400">{{ $build->purpose }}</span>
                        @endif
                        <p class="mt-0.5 text-xs text-gray-500">{{ $build->items->count() }} komponen</p>
                    </div>
                    <span class="font-bold text-kee-600 dark:text-kee-400">Rp{{ number_format($build->total_price, 0, ',', '.') }}</span>
                </a>
            @endforeach
        </div>
        <div class="mt-6">{{ $builds->links() }}</div>
    @endif
</div>
@endsection
