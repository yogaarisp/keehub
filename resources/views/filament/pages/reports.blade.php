@php
    $summary = $this->getSummary();
    $bestSellers = $this->getBestSellers(6);
    $lowStock = $this->getLowStock();

    $presets = [
        'today' => 'Hari Ini',
        'week' => '7 Hari',
        'month' => 'Bulan Ini',
        'last30' => '30 Hari',
        'year' => 'Tahun Ini',
    ];

    $methodLabels = [
        'cash' => 'Tunai / Cash',
        'transfer' => 'Transfer Bank',
        'qris' => 'QRIS',
        'ewallet' => 'E-Wallet',
        'debit' => 'Kartu Debit',
        'credit' => 'Kartu Kredit',
        'other' => 'Lainnya',
    ];

    $statusLabels = [
        'received' => ['label' => 'Masuk', 'color' => 'gray', 'bar' => '#94a3b8'],
        'checking' => ['label' => 'Pengecekan', 'color' => 'warning', 'bar' => '#f59e0b'],
        'waiting_approval' => ['label' => 'Approval', 'color' => 'info', 'bar' => '#0ea5e9'],
        'processing' => ['label' => 'Dikerjakan', 'color' => 'primary', 'bar' => '#d97706'],
        'testing' => ['label' => 'QC Test', 'color' => 'info', 'bar' => '#6366f1'],
        'ready' => ['label' => 'Siap Ambil', 'color' => 'success', 'bar' => '#14b8a6'],
        'completed' => ['label' => 'Selesai', 'color' => 'success', 'bar' => '#10b981'],
        'cancelled' => ['label' => 'Dibatalkan', 'color' => 'danger', 'bar' => '#f43f5e'],
    ];

    $totalPaymentAmount = max(1, collect($summary['payments_by_method'])->sum('total'));
    $totalServiceCount = max(1, collect($summary['services_by_status'])->sum('count'));
@endphp

<x-filament-panels::page>
    <style>
        .kr-stack { display: flex; flex-direction: column; gap: 1.25rem; }
        .kr-preset-row { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 0.75rem; margin-bottom: 1rem; }
        .kr-preset-title { font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b; }
        .dark .kr-preset-title { color: #94a3b8; }
        .kr-preset-pills { display: flex; flex-wrap: wrap; gap: 0.375rem; }
        .kr-pill {
            border-radius: 0.5rem;
            padding: 0.375rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 500;
            border: 1px solid rgba(148, 163, 184, 0.25);
            background: #f8fafc;
            color: #475569;
            transition: all 0.15s ease;
            cursor: pointer;
        }
        .kr-pill:hover { background: #e2e8f0; color: #0f172a; }
        .dark .kr-pill { background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1); color: #cbd5e1; }
        .dark .kr-pill:hover { background: rgba(255,255,255,0.1); color: #ffffff; }
        .kr-pill.is-active {
            background: #d97706 !important;
            border-color: #d97706 !important;
            color: #ffffff !important;
            font-weight: 600;
            box-shadow: 0 1px 3px rgba(217, 119, 6, 0.25);
        }

        .kr-filter-form { display: flex; flex-direction: column; gap: 0.75rem; }
        @media (min-width: 640px) {
            .kr-filter-form { flex-direction: row; align-items: flex-end; }
            .kr-filter-fields { flex: 1 1 auto; }
        }

        .kr-kpi-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0.75rem;
        }
        @media (min-width: 768px) {
            .kr-kpi-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 1rem; }
        }
        @media (min-width: 1280px) {
            .kr-kpi-grid { grid-template-columns: repeat(6, minmax(0, 1fr)); }
        }

        .kr-kpi-label { font-size: 0.6875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em; color: #64748b; }
        .dark .kr-kpi-label { color: #94a3b8; }
        .kr-kpi-value { margin-top: 0.35rem; font-size: 1.15rem; font-weight: 700; font-variant-numeric: tabular-nums; line-height: 1.25; color: #0f172a; word-break: break-word; }
        .dark .kr-kpi-value { color: #f8fafc; }
        @media (min-width: 640px) { .kr-kpi-value { font-size: 1.25rem; } }
        .kr-kpi-value.is-green { color: #059669; }
        .dark .kr-kpi-value.is-green { color: #34d399; }
        .kr-kpi-value.is-amber { color: #d97706; }
        .dark .kr-kpi-value.is-amber { color: #fbbf24; }
        .kr-kpi-value.is-indigo { color: #4f46e5; }
        .dark .kr-kpi-value.is-indigo { color: #818cf8; }
        .kr-kpi-value.is-rose { color: #e11d48; }
        .dark .kr-kpi-value.is-rose { color: #fb7185; }
        .kr-kpi-sub { margin-top: 0.25rem; font-size: 0.6875rem; color: #94a3b8; }
        .dark .kr-kpi-sub { color: #64748b; }

        .kr-two-col {
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            gap: 1rem;
        }
        @media (min-width: 1024px) {
            .kr-two-col { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        .kr-card-head { display: flex; align-items: flex-start; justify-content: space-between; gap: 0.75rem; margin-bottom: 1rem; }
        .kr-card-title { font-size: 0.925rem; font-weight: 600; color: #0f172a; }
        .dark .kr-card-title { color: #f8fafc; }
        .kr-card-sub { font-size: 0.75rem; color: #64748b; margin-top: 0.15rem; }
        .dark .kr-card-sub { color: #94a3b8; }
        .kr-link { font-size: 0.75rem; font-weight: 600; color: #d97706; white-space: nowrap; }
        .kr-link:hover { text-decoration: underline; }
        .dark .kr-link { color: #fbbf24; }

        .kr-bar-list { display: flex; flex-direction: column; gap: 0.85rem; }
        .kr-bar-top { display: flex; align-items: center; justify-content: space-between; gap: 0.5rem; font-size: 0.8rem; margin-bottom: 0.3rem; }
        .kr-bar-track { width: 100%; height: 0.45rem; border-radius: 9999px; background: #f1f5f9; overflow: hidden; }
        .dark .kr-bar-track { background: rgba(255,255,255,0.08); }
        .kr-bar-fill { height: 100%; border-radius: 9999px; transition: width 0.3s ease; }

        .kr-table-wrap { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .kr-table { width: 100% !important; display: table !important; border-collapse: collapse; text-align: left; font-size: 0.85rem; }
        .kr-table th {
            padding: 0 0.5rem 0.65rem 0.5rem;
            font-size: 0.6875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #64748b;
            border-bottom: 1px solid rgba(148, 163, 184, 0.25);
        }
        .kr-table th:first-child, .kr-table td:first-child { padding-left: 0; }
        .kr-table th:last-child, .kr-table td:last-child { padding-right: 0; text-align: right; }
        .kr-table td {
            padding: 0.65rem 0.5rem;
            border-bottom: 1px solid rgba(148, 163, 184, 0.14);
            vertical-align: middle;
        }
        .kr-table tbody tr:last-child td { border-bottom: none; }
        .kr-table tbody tr:hover { background: rgba(148, 163, 184, 0.06); }
        .kr-prod-link { font-weight: 500; color: #0f172a; }
        .kr-prod-link:hover { color: #d97706; }
        .dark .kr-prod-link { color: #f1f5f9; }
        .dark .kr-prod-link:hover { color: #fbbf24; }
        .kr-sku { font-family: ui-monospace, SFMono-Regular, Menlo, monospace; font-size: 0.7rem; color: #94a3b8; margin-top: 0.1rem; }
        .kr-empty { padding: 1.5rem 0; text-align: center; font-size: 0.85rem; color: #94a3b8; }
        .kr-empty.is-ok { color: #059669; }
        .dark .kr-empty.is-ok { color: #34d399; }
    </style>

    <div class="kr-stack">
        {{-- Filter Periode Card --}}
        <x-filament::card>
            <div class="kr-preset-row">
                <span class="kr-preset-title">Filter Cepat Periode</span>
                <div class="kr-preset-pills">
                    @foreach ($presets as $key => $label)
                        <button
                            type="button"
                            wire:click="applyPreset('{{ $key }}')"
                            class="kr-pill {{ $activePreset === $key ? 'is-active' : '' }}"
                        >
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
            </div>

            <form wire:submit.prevent="applyFilter" class="kr-filter-form">
                <div class="kr-filter-fields">
                    {{ $this->form }}
                </div>
                <x-filament::button type="submit" icon="heroicon-m-arrow-path">
                    Terapkan Periode
                </x-filament::button>
            </form>
        </x-filament::card>

        {{-- 6 KPI Cards --}}
        <div class="kr-kpi-grid">
            <x-filament::card>
                <p class="kr-kpi-label">Pendapatan Masuk</p>
                <p class="kr-kpi-value is-green">Rp{{ number_format($summary['revenue'], 0, ',', '.') }}</p>
                <p class="kr-kpi-sub">Payment lunas / DP</p>
            </x-filament::card>

            <x-filament::card>
                <p class="kr-kpi-label">Jumlah Order</p>
                <p class="kr-kpi-value">{{ number_format($summary['orders'], 0, ',', '.') }}</p>
                <p class="kr-kpi-sub">Order non-batal</p>
            </x-filament::card>

            <x-filament::card>
                <p class="kr-kpi-label">Nilai Order</p>
                <p class="kr-kpi-value">Rp{{ number_format($summary['order_value'], 0, ',', '.') }}</p>
                <p class="kr-kpi-sub">Total nilai pesanan</p>
            </x-filament::card>

            <x-filament::card>
                <p class="kr-kpi-label">Unit Servis</p>
                <p class="kr-kpi-value is-amber">{{ number_format($summary['services'], 0, ',', '.') }}</p>
                <p class="kr-kpi-sub">Unit masuk periode</p>
            </x-filament::card>

            <x-filament::card>
                <p class="kr-kpi-label">Nilai Servis</p>
                <p class="kr-kpi-value is-indigo">Rp{{ number_format($summary['service_value'], 0, ',', '.') }}</p>
                <p class="kr-kpi-sub">Total tagihan servis</p>
            </x-filament::card>

            <x-filament::card>
                <p class="kr-kpi-label">Piutang Aktif</p>
                <p class="kr-kpi-value is-rose">Rp{{ number_format($summary['unpaid'], 0, ',', '.') }}</p>
                <p class="kr-kpi-sub">Invoice belum lunas</p>
            </x-filament::card>
        </div>

        {{-- Breakdown Metode Pembayaran & Status Servis --}}
        <div class="kr-two-col">
            <x-filament::card>
                <div class="kr-card-head">
                    <div>
                        <h3 class="kr-card-title">Pembayaran per Metode</h3>
                        <p class="kr-card-sub">Distribusi uang masuk berdasarkan kanal pembayaran</p>
                    </div>
                </div>

                @if (empty($summary['payments_by_method']))
                    <p class="kr-empty">Belum ada pembayaran tercatat pada periode ini.</p>
                @else
                    <div class="kr-bar-list">
                        @foreach ($summary['payments_by_method'] as $row)
                            @php
                                $pct = round(($row['total'] / $totalPaymentAmount) * 100);
                            @endphp
                            <div>
                                <div class="kr-bar-top">
                                    <span style="font-weight: 500;">
                                        {{ $methodLabels[$row['method']] ?? ucfirst($row['method']) }}
                                        <span style="color: #94a3b8; font-weight: 400;">({{ $row['count'] }}x)</span>
                                    </span>
                                    <span style="font-weight: 600; font-variant-numeric: tabular-nums;">
                                        Rp{{ number_format($row['total'], 0, ',', '.') }}
                                    </span>
                                </div>
                                <div class="kr-bar-track">
                                    <div class="kr-bar-fill" style="width: {{ $pct }}%; background: #10b981;"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </x-filament::card>

            <x-filament::card>
                <div class="kr-card-head">
                    <div>
                        <h3 class="kr-card-title">Rekap Status Servis</h3>
                        <p class="kr-card-sub">Sebaran unit servis masuk dalam periode</p>
                    </div>
                </div>

                @if (empty($summary['services_by_status']))
                    <p class="kr-empty">Belum ada unit servis tercatat pada periode ini.</p>
                @else
                    <div class="kr-bar-list">
                        @foreach ($summary['services_by_status'] as $row)
                            @php
                                $meta = $statusLabels[$row['status']] ?? ['label' => ucfirst($row['status']), 'color' => 'gray', 'bar' => '#94a3b8'];
                                $pct = round(($row['count'] / $totalServiceCount) * 100);
                            @endphp
                            <div>
                                <div class="kr-bar-top">
                                    <x-filament::badge :color="$meta['color']" size="sm">
                                        {{ $meta['label'] }}
                                    </x-filament::badge>
                                    <span style="font-weight: 600; font-variant-numeric: tabular-nums;">
                                        {{ $row['count'] }} unit <span style="font-weight: 400; color: #94a3b8;">({{ $pct }}%)</span>
                                    </span>
                                </div>
                                <div class="kr-bar-track">
                                    <div class="kr-bar-fill" style="width: {{ $pct }}%; background: {{ $meta['bar'] }};"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </x-filament::card>
        </div>

        {{-- Best Seller & Low Stock Side-by-Side --}}
        <div class="kr-two-col">
            <x-filament::card>
                <div class="kr-card-head">
                    <div>
                        <h3 class="kr-card-title">Produk Terlaris (Best Seller)</h3>
                        <p class="kr-card-sub">Produk dengan volume penjualan tertinggi</p>
                    </div>
                    <a href="{{ \App\Filament\Resources\ProductResource::getUrl('index') }}" class="kr-link">
                        Semua Produk →
                    </a>
                </div>

                @if ($bestSellers->isEmpty())
                    <p class="kr-empty">Belum ada data penjualan produk.</p>
                @else
                    <div class="kr-table-wrap">
                        <table class="kr-table">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th style="text-align: right;">Terjual</th>
                                    <th>Sisa Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bestSellers as $product)
                                    @php
                                        $stock = $product->inventory?->current_stock ?? 0;
                                    @endphp
                                    <tr>
                                        <td>
                                            <a href="{{ \App\Filament\Resources\ProductResource::getUrl('edit', ['record' => $product]) }}" class="kr-prod-link">
                                                {{ \Illuminate\Support\Str::limit($product->name, 38) }}
                                            </a>
                                            <div class="kr-sku">{{ $product->sku }}</div>
                                        </td>
                                        <td style="text-align: right; font-weight: 600; font-variant-numeric: tabular-nums;">
                                            {{ number_format($product->sold_count, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            <x-filament::badge :color="$stock <= 0 ? 'danger' : 'gray'" size="sm">
                                                {{ $stock }}
                                            </x-filament::badge>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </x-filament::card>

            <x-filament::card>
                <div class="kr-card-head">
                    <div>
                        <h3 class="kr-card-title">Peringatan Stok Menipis</h3>
                        <p class="kr-card-sub">Produk di bawah atau sama dengan batas minimum</p>
                    </div>
                    <a href="{{ \App\Filament\Resources\InventoryResource::getUrl('index') }}" class="kr-link">
                        Kelola Stok →
                    </a>
                </div>

                @if ($lowStock->isEmpty())
                    <p class="kr-empty is-ok">Semua stok produk aman di atas batas minimum.</p>
                @else
                    <div class="kr-table-wrap">
                        <table class="kr-table">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th style="text-align: right;">Stok</th>
                                    <th>Min</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lowStock->take(6) as $inventory)
                                    <tr>
                                        <td>
                                            @if ($inventory->product)
                                                <a href="{{ \App\Filament\Resources\ProductResource::getUrl('edit', ['record' => $inventory->product]) }}" class="kr-prod-link">
                                                    {{ \Illuminate\Support\Str::limit($inventory->product->name, 38) }}
                                                </a>
                                                <div class="kr-sku">{{ $inventory->product->sku }}</div>
                                            @else
                                                <span style="color: #94a3b8;">—</span>
                                            @endif
                                        </td>
                                        <td style="text-align: right;">
                                            <x-filament::badge :color="$inventory->current_stock <= 0 ? 'danger' : 'warning'" size="sm">
                                                {{ $inventory->current_stock }}
                                            </x-filament::badge>
                                        </td>
                                        <td style="font-weight: 500; font-variant-numeric: tabular-nums; color: #64748b;">
                                            {{ $inventory->min_stock }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </x-filament::card>
        </div>
    </div>
</x-filament-panels::page>
