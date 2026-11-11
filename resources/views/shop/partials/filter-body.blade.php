<form id="{{ $formId ?? 'filter-form' }}" method="GET" action="{{ route('shop.index') }}" class="space-y-4">
    @if (request('sort'))
        <input type="hidden" name="sort" value="{{ request('sort') }}">
    @endif

    <div class="x-card p-4">
        <label for="{{ ($formId ?? 'filter-form').'-q' }}" class="mb-2.5 block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">
            Cari Produk
        </label>
        <div class="relative">
            <svg class="pointer-events-none absolute inset-y-0 left-3 my-auto h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
            <input id="{{ ($formId ?? 'filter-form').'-q' }}"
                   type="text"
                   name="q"
                   value="{{ request('q') }}"
                   placeholder="Nama produk atau SKU..."
                   class="x-input !py-2 !pl-9 text-sm">
        </div>
    </div>

    <div class="x-card p-4">
        <h3 class="mb-2.5 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Kategori</h3>
        <div class="max-h-56 space-y-1.5 overflow-y-auto pr-1">
            <label class="flex cursor-pointer items-center gap-2.5 rounded-lg px-2 py-1 text-sm transition hover:bg-slate-50 dark:hover:bg-slate-800/60">
                <input type="radio" name="category" value="" @checked(! request('category')) class="text-amber-600 focus:ring-amber-500">
                <span class="{{ ! request('category') ? 'font-semibold text-amber-600 dark:text-amber-400' : 'text-slate-700 dark:text-slate-300' }}">Semua Kategori</span>
            </label>
            @foreach ($categories as $category)
                <label class="flex cursor-pointer items-center gap-2.5 rounded-lg px-2 py-1 text-sm transition hover:bg-slate-50 dark:hover:bg-slate-800/60">
                    <input type="radio" name="category" value="{{ $category->slug }}" @checked(request('category') === $category->slug) class="text-amber-600 focus:ring-amber-500">
                    <span class="{{ request('category') === $category->slug ? 'font-semibold text-amber-600 dark:text-amber-400' : 'text-slate-700 dark:text-slate-300' }}">{{ $category->name }}</span>
                </label>
            @endforeach
        </div>
    </div>

    <div class="x-card p-4">
        <h3 class="mb-2.5 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Brand</h3>
        <div class="max-h-48 space-y-1.5 overflow-y-auto pr-1">
            @foreach ($brands as $brand)
                <label class="flex cursor-pointer items-center gap-2.5 rounded-lg px-2 py-1 text-sm transition hover:bg-slate-50 dark:hover:bg-slate-800/60">
                    <input type="checkbox" name="brand[]" value="{{ $brand->slug }}" @checked(in_array($brand->slug, (array) request('brand'), true)) class="rounded text-amber-600 focus:ring-amber-500">
                    <span class="text-slate-700 dark:text-slate-300">{{ $brand->name }}</span>
                </label>
            @endforeach
        </div>
    </div>

    <div class="x-card p-4">
        <h3 class="mb-2.5 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Rentang Harga (Rp)</h3>
        <div class="grid grid-cols-[1fr_auto_1fr] items-center gap-2">
            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="x-input min-w-0 !py-2 text-sm" min="0">
            <span class="text-slate-400">—</span>
            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" class="x-input min-w-0 !py-2 text-sm" min="0">
        </div>
    </div>

    <div class="x-card p-4">
        <label class="flex cursor-pointer items-center gap-2.5 text-sm">
            <input type="checkbox" name="availability" value="in_stock" @checked(request('availability') === 'in_stock') class="rounded text-amber-600 focus:ring-amber-500">
            <span class="font-medium text-slate-700 dark:text-slate-300">Hanya stok tersedia</span>
        </label>
    </div>

    <div class="flex gap-2">
        <button type="submit" class="x-btn-primary flex-1">Terapkan</button>
        <a href="{{ route('shop.index') }}" class="x-btn-outline">Reset</a>
    </div>
</form>
