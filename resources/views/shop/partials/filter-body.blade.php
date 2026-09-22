<form method="GET" action="{{ route('shop.index') }}" class="space-y-6">
    <div class="x-card p-4">
        <h3 class="mb-3 text-sm font-bold uppercase tracking-wide text-gray-500">Cari</h3>
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari produk / SKU..." class="x-input !py-2 text-sm">
    </div>

    <div class="x-card p-4">
        <h3 class="mb-3 text-sm font-bold uppercase tracking-wide text-gray-500">Kategori</h3>
        <div class="space-y-1.5">
            <label class="flex items-center gap-2 text-sm">
                <input type="radio" name="category" value="" @checked(! request('category')) class="text-kee-600 focus:ring-kee-500">
                <span class="text-gray-700 dark:text-gray-300">Semua</span>
            </label>
            @foreach ($categories as $category)
                <label class="flex items-center gap-2 text-sm">
                    <input type="radio" name="category" value="{{ $category->slug }}" @checked(request('category') === $category->slug) class="text-kee-600 focus:ring-kee-500">
                    <span class="text-gray-700 dark:text-gray-300">{{ $category->name }}</span>
                </label>
            @endforeach
        </div>
    </div>

    <div class="x-card p-4">
        <h3 class="mb-3 text-sm font-bold uppercase tracking-wide text-gray-500">Brand</h3>
        <div class="max-h-52 space-y-1.5 overflow-y-auto">
            @foreach ($brands as $brand)
                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" name="brand[]" value="{{ $brand->slug }}" @checked(in_array($brand->slug, (array) request('brand'))) class="rounded text-kee-600 focus:ring-kee-500">
                    <span class="text-gray-700 dark:text-gray-300">{{ $brand->name }}</span>
                </label>
            @endforeach
        </div>
    </div>

    <div class="flex gap-2">
        <button type="submit" class="x-btn-primary flex-1">Terapkan</button>
        <a href="{{ route('shop.index') }}" class="x-btn-outline">Reset</a>
    </div>
</form>
