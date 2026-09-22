<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;

class ReportExport implements FromArray, WithTitle
{
    public function __construct(
        private array $summary,
        private $bestSellers
    ) {}

    public function array(): array
    {
        $rows = [
            ['KEEHUB — LAPORAN PERIODE'],
            [],
            ['Metrik', 'Nilai'],
            ['Pendapatan (payment tercatat)', 'Rp'.number_format($this->summary['revenue'], 0, ',', '.')],
            ['Jumlah Order', $this->summary['orders']],
            ['Nilai Order', 'Rp'.number_format($this->summary['order_value'], 0, ',', '.')],
            ['Jumlah Service', $this->summary['services']],
            ['Piutang Belum Dibayar', 'Rp'.number_format($this->summary['unpaid'], 0, ',', '.')],
            [],
            ['Best Seller'],
            ['SKU', 'Nama', 'Terjual', 'Stok'],
        ];

        foreach ($this->bestSellers as $product) {
            $rows[] = [$product->sku, $product->name, $product->sold_count, $product->inventory?->current_stock ?? 0];
        }

        return $rows;
    }

    public function title(): string
    {
        return 'Laporan';
    }
}
