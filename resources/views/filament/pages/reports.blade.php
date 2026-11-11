<x-filament-panels::page>
    <div class="space-y-6">
        <form wire:submit.prevent="$refresh" class="flex flex-col sm:flex-row sm:flex-wrap sm:items-end gap-3 sm:gap-4">
            {{ $this->form }}
            <x-filament::button type="submit" icon="heroicon-m-arrow-path">Terapkan Periode</x-filament::button>
        </form>

        <div class="grid gap-3 grid-cols-2 sm:gap-4 lg:grid-cols-5">
            <x-filament::card>
                <p class="text-[10px] sm:text-xs font-medium uppercase tracking-wide text-slate-500 dark:text-slate-400">Pendapatan</p>
                <p class="mt-1 text-base sm:text-xl font-bold tabular-nums text-emerald-600 dark:text-emerald-400 break-all">Rp{{ number_format($this->getSummary()['revenue'], 0, ',', '.') }}</p>
            </x-filament::card>
            <x-filament::card>
                <p class="text-[10px] sm:text-xs font-medium uppercase tracking-wide text-slate-500 dark:text-slate-400">Orders</p>
                <p class="mt-1 text-base sm:text-xl font-bold tabular-nums text-slate-900 dark:text-slate-100">{{ $this->getSummary()['orders'] }}</p>
            </x-filament::card>
            <x-filament::card>
                <p class="text-[10px] sm:text-xs font-medium uppercase tracking-wide text-slate-500 dark:text-slate-400">Nilai Order</p>
                <p class="mt-1 text-base sm:text-xl font-bold tabular-nums text-slate-900 dark:text-slate-100 break-all">Rp{{ number_format($this->getSummary()['order_value'], 0, ',', '.') }}</p>
            </x-filament::card>
            <x-filament::card>
                <p class="text-[10px] sm:text-xs font-medium uppercase tracking-wide text-slate-500 dark:text-slate-400">Service</p>
                <p class="mt-1 text-base sm:text-xl font-bold tabular-nums text-slate-900 dark:text-slate-100">{{ $this->getSummary()['services'] }}</p>
            </x-filament::card>
            <x-filament::card>
                <p class="text-[10px] sm:text-xs font-medium uppercase tracking-wide text-slate-500 dark:text-slate-400">Piutang</p>
                <p class="mt-1 text-base sm:text-xl font-bold tabular-nums text-rose-600 dark:text-rose-400 break-all">Rp{{ number_format($this->getSummary()['unpaid'], 0, ',', '.') }}</p>
            </x-filament::card>
        </div>

        <div class="grid gap-4 lg:grid-cols-2">
            <x-filament::card>
                <h3 class="mb-3 font-bold">Best Seller</h3>
                <div class="overflow-x-auto -mx-2 px-2">
                    <table class="w-full text-sm">
                        <tr class="text-left text-xs uppercase text-gray-400"><th class="pb-2">Produk</th><th class="pb-2">Terjual</th><th class="pb-2">Stok</th></tr>
                        @foreach ($this->getBestSellers(5) as $product)
                            <tr class="border-t border-gray-100 dark:border-gray-800">
                                <td class="py-1.5">{{ \Illuminate\Support\Str::limit($product->name, 30) }}</td>
                                <td>{{ $product->sold_count }}</td>
                                <td>{{ $product->inventory?->current_stock ?? 0 }}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </x-filament::card>

            <x-filament::card>
                <h3 class="mb-3 font-bold">Low Stock</h3>
                @if ($this->getLowStock()->isEmpty())
                    <p class="text-sm text-gray-400">Tidak ada produk low stock. 🎉</p>
                @else
                    <div class="overflow-x-auto -mx-2 px-2">
                        <table class="w-full text-sm">
                            <tr class="text-left text-xs uppercase text-gray-400"><th class="pb-2">Produk</th><th class="pb-2">Stok</th><th class="pb-2">Min</th></tr>
                            @foreach ($this->getLowStock()->take(6) as $inventory)
                                <tr class="border-t border-gray-100 dark:border-gray-800">
                                    <td class="py-1.5">{{ \Illuminate\Support\Str::limit($inventory->product->name, 30) }}</td>
                                    <td class="font-bold text-danger-600">{{ $inventory->current_stock }}</td>
                                    <td>{{ $inventory->min_stock }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @endif
            </x-filament::card>
        </div>
    </div>
</x-filament-panels::page>
