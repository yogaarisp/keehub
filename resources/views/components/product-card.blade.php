@php
    $image = $product->primaryImage();
    $cover = $image && ! str_ends_with($image, 'placeholder.svg') ? asset('storage/'.$image) : null;
    $stock = $product->stockStatus();
@endphp

<a href="{{ route('shop.show', $product->slug) }}" class="x-card group flex flex-col overflow-hidden transition hover:-translate-y-0.5 hover:shadow-md">
    <div class="relative aspect-square bg-gray-100 dark:bg-gray-800">
        @if ($cover)
            <img src="{{ $cover }}" alt="{{ $product->name }}" loading="lazy" class="h-full w-full object-cover">
        @else
            <div class="flex h-full w-full items-center justify-center text-4xl text-gray-300 dark:text-gray-600">
                <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17.25l.75-3.75m5.25 3.75l-.75-3.75M4.875 8.25h14.25M12 4.5a8.25 8.25 0 00-8.25 8.25c0 2.04.74 3.9 1.97 5.34.2.24.5.36.8.36h10.96c.3 0 .6-.12.8-.36a8.22 8.22 0 001.97-5.34A8.25 8.25 0 0012 4.5z"/></svg>
            </div>
        @endif

        <div class="absolute left-2 top-2 flex flex-col gap-1">
            @if ($product->sold_count >= 10)
                <span class="x-badge bg-kee-500 text-gray-950">Best Seller</span>
            @endif
            @if ($stock === 'out_of_stock')
                <span class="x-badge bg-gray-900 text-white">Out of Stock</span>
            @elseif ($stock === 'low_stock')
                <span class="x-badge bg-orange-500 text-white">Low Stock</span>
            @endif
        </div>
    </div>

    <div class="flex flex-1 flex-col gap-1 p-3.5">
        <span class="text-[11px] font-medium uppercase tracking-wide text-gray-400">{{ $product->brand?->name ?? $product->category->name }}</span>
        <h3 class="line-clamp-2 text-sm font-semibold text-gray-900 group-hover:text-kee-600 dark:text-white dark:group-hover:text-kee-400">{{ $product->name }}</h3>
        <div class="mt-auto flex items-end justify-between pt-2">
            <span class="text-base font-bold text-kee-600 dark:text-kee-400">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
            <span class="x-badge {{ $stock === 'in_stock' ? 'bg-green-100 text-green-700' : '' }}">
                @if ($stock === 'in_stock') Stok @else {{ $stock === 'low_stock' ? 'Stok Low' : 'Habis' }} @endif
            </span>
        </div>
    </div>
</a>
