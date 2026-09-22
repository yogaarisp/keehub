<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSpec;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'CPU', 'icon' => 'cpu'],
            ['name' => 'Motherboard', 'icon' => 'circuit-board'],
            ['name' => 'GPU', 'icon' => 'video-camera'],
            ['name' => 'RAM', 'icon' => 'memory-chip'],
            ['name' => 'SSD', 'icon' => 'circle-stack'],
            ['name' => 'HDD', 'icon' => 'archive-box'],
            ['name' => 'PSU', 'icon' => 'bolt'],
            ['name' => 'Casing', 'icon' => 'squares-2x2'],
            ['name' => 'CPU Cooler', 'icon' => 'fire'],
            ['name' => 'Monitor', 'icon' => 'tv'],
            ['name' => 'Keyboard', 'icon' => 'keyboard'],
            ['name' => 'Mouse', 'icon' => 'cursor-arrow-rays'],
            ['name' => 'Networking', 'icon' => 'wifi'],
        ];

        $categoryIds = [];
        foreach ($categories as $i => $c) {
            $category = Category::query()->create([
                'name' => $c['name'],
                'slug' => Str::slug($c['name']),
                'icon' => $c['icon'],
                'sort_order' => $i,
            ]);
            $categoryIds[$c['name']] = $category->id;
        }

        $brands = ['AMD', 'Intel', 'ASUS', 'MSI', 'Gigabyte', 'Corsair', 'Kingston', 'Samsung', 'Lian Li', 'Cooler Master', 'DeepCool', 'NVIDIA'];
        $brandIds = [];
        foreach ($brands as $b) {
            $brandIds[$b] = Brand::query()->create([
                'name' => $b,
                'slug' => Str::slug($b),
            ])->id;
        }

        // CPU — Ryzen 5 5600
        $cpu1 = $this->product([
            'sku' => 'CPU-AMD-5600',
            'name' => 'AMD Ryzen 5 5600',
            'slug' => 'amd-ryzen-5-5600',
            'category_id' => $categoryIds['CPU'],
            'brand_id' => $brandIds['AMD'],
            'price' => 1850000,
            'cost_price' => 1680000,
            'description' => '6 core 12 thread, combo am4 dengan B550M atau A520M, garansi resmi 3 tahun.',
            'warranty' => '3 Tahun Resmi',
        ], [
            ['key' => 'socket', 'value' => 'AM4'],
            ['key' => 'core', 'value' => '6'],
            ['key' => 'thread', 'value' => '12'],
            ['key' => 'base_clock', 'value' => '3.5 GHz'],
            ['key' => 'boost_clock', 'value' => '4.4 GHz'],
            ['key' => 'tdp_watt', 'value' => '65', 'value_numeric' => 65, 'unit' => 'W'],
            ['key' => 'architecture', 'value' => 'Zen 3'],
            ['key' => 'integrated_graphics', 'value' => 'Tidak'],
        ], 15);

        // CPU — Intel i5-12400F
        $cpu2 = $this->product([
            'sku' => 'CPU-INT-12400F',
            'name' => 'Intel Core i5-12400F',
            'slug' => 'intel-core-i5-12400f',
            'category_id' => $categoryIds['CPU'],
            'brand_id' => $brandIds['Intel'],
            'price' => 1750000,
            'cost_price' => 1620000,
            'description' => '6 core 12 thread LGA1700, performa gaming kelas menengah.',
            'warranty' => '3 Tahun Resmi',
        ], [
            ['key' => 'socket', 'value' => 'LGA1700'],
            ['key' => 'core', 'value' => '6'],
            ['key' => 'thread', 'value' => '12'],
            ['key' => 'boost_clock', 'value' => '4.4 GHz'],
            ['key' => 'tdp_watt', 'value' => '65', 'value_numeric' => 65, 'unit' => 'W'],
            ['key' => 'integrated_graphics', 'value' => 'Tidak (F-series)'],
        ], 12);

        // Motherboard — A520M
        $mb1 = $this->product([
            'sku' => 'MB-ASUS-A520M',
            'name' => 'ASUS A520M-K',
            'slug' => 'asus-a520m-k',
            'category_id' => $categoryIds['Motherboard'],
            'brand_id' => $brandIds['ASUS'],
            'price' => 1050000,
            'cost_price' => 950000,
            'description' => 'Micro ATX AM4 DDR4, cocok untuk Ryzen 5000 series.',
            'warranty' => '3 Tahun Resmi',
        ], [
            ['key' => 'socket', 'value' => 'AM4'],
            ['key' => 'chipset', 'value' => 'A520'],
            ['key' => 'ram_type', 'value' => 'DDR4'],
            ['key' => 'ram_slots', 'value' => '2', 'value_numeric' => 2],
            ['key' => 'max_ram_gb', 'value' => '64', 'value_numeric' => 64, 'unit' => 'GB'],
            ['key' => 'm2_slots', 'value' => '1', 'value_numeric' => 1],
            ['key' => 'form_factor', 'value' => 'Micro ATX'],
        ], 10);

        // Motherboard — B550M
        $mb2 = $this->product([
            'sku' => 'MB-MSI-B550M',
            'name' => 'MSI B550M PRO-VDH WiFi',
            'slug' => 'msi-b550m-pro-vdh-wifi',
            'category_id' => $categoryIds['Motherboard'],
            'brand_id' => $brandIds['MSI'],
            'price' => 1550000,
            'cost_price' => 1420000,
            'description' => 'Micro ATX AM4 DDR4, PCIe 4.0, WiFi onboard.',
            'warranty' => '3 Tahun Resmi',
        ], [
            ['key' => 'socket', 'value' => 'AM4'],
            ['key' => 'chipset', 'value' => 'B550'],
            ['key' => 'ram_type', 'value' => 'DDR4'],
            ['key' => 'ram_slots', 'value' => '4', 'value_numeric' => 4],
            ['key' => 'max_ram_gb', 'value' => '128', 'value_numeric' => 128, 'unit' => 'GB'],
            ['key' => 'm2_slots', 'value' => '2', 'value_numeric' => 2],
            ['key' => 'form_factor', 'value' => 'Micro ATX'],
        ], 8);

        // RAM DDR4
        $ram1 = $this->product([
            'sku' => 'RAM-KST-16-3200',
            'name' => 'Kingston Fury Beast DDR4 16GB (2x8GB) 3200MHz',
            'slug' => 'kingston-fury-beast-ddr4-16gb-3200',
            'category_id' => $categoryIds['RAM'],
            'brand_id' => $brandIds['Kingston'],
            'price' => 750000,
            'cost_price' => 680000,
            'description' => 'Kit dual channel 2x8GB DDR4 3200MHz.',
            'warranty' => 'Lifetime',
        ], [
            ['key' => 'generation', 'value' => 'DDR4'],
            ['key' => 'capacity_gb', 'value' => '16', 'value_numeric' => 16, 'unit' => 'GB'],
            ['key' => 'frequency_mhz', 'value' => '3200', 'value_numeric' => 3200, 'unit' => 'MHz'],
            ['key' => 'cas_latency', 'value' => 'CL16'],
            ['key' => 'module_count', 'value' => '2'],
        ], 20);

        // GPU — RTX 4060
        $gpu1 = $this->product([
            'sku' => 'GPU-MSI-4060',
            'name' => 'MSI RTX 4060 Ventus 2X 8GB',
            'slug' => 'msi-rtx-4060-ventus-2x-8gb',
            'category_id' => $categoryIds['GPU'],
            'brand_id' => $brandIds['MSI'],
            'price' => 5350000,
            'cost_price' => 5050000,
            'description' => 'RTX 4060 8GB GDDR6, dual fan, 1080p gaming ray tracing.',
            'warranty' => '3 Tahun Resmi',
        ], [
            ['key' => 'vram_gb', 'value' => '8', 'value_numeric' => 8, 'unit' => 'GB'],
            ['key' => 'memory_type', 'value' => 'GDDR6'],
            ['key' => 'power_consumption_watt', 'value' => '115', 'value_numeric' => 115, 'unit' => 'W'],
            ['key' => 'length_mm', 'value' => '199', 'value_numeric' => 199, 'unit' => 'mm'],
            ['key' => 'recommended_psu_watt', 'value' => '550', 'value_numeric' => 550, 'unit' => 'W'],
            ['key' => 'interface', 'value' => 'PCIe 4.0 x8'],
        ], 6);

        // GPU — RTX 3050
        $gpu2 = $this->product([
            'sku' => 'GPU-GLB-3050',
            'name' => 'Gigabyte RTX 3050 Eagle OC 8GB',
            'slug' => 'gigabyte-rtx-3050-eagle-oc-8gb',
            'category_id' => $categoryIds['GPU'],
            'brand_id' => $brandIds['Gigabyte'],
            'price' => 3200000,
            'cost_price' => 3000000,
            'description' => 'RTX 3050 8GB, entry 1080p gaming.',
            'warranty' => '2 Tahun Resmi',
        ], [
            ['key' => 'vram_gb', 'value' => '8', 'value_numeric' => 8, 'unit' => 'GB'],
            ['key' => 'memory_type', 'value' => 'GDDR6'],
            ['key' => 'power_consumption_watt', 'value' => '130', 'value_numeric' => 130, 'unit' => 'W'],
            ['key' => 'length_mm', 'value' => '212', 'value_numeric' => 212, 'unit' => 'mm'],
            ['key' => 'recommended_psu_watt', 'value' => '550', 'value_numeric' => 550, 'unit' => 'W'],
            ['key' => 'interface', 'value' => 'PCIe 4.0 x8'],
        ], 9);

        // Storage
        $ssd1 = $this->product([
            'sku' => 'SSD-SMG-1TB',
            'name' => 'Samsung 980 1TB NVMe M.2',
            'slug' => 'samsung-980-1tb-nvme',
            'category_id' => $categoryIds['SSD'],
            'brand_id' => $brandIds['Samsung'],
            'price' => 950000,
            'cost_price' => 870000,
            'description' => 'NVMe PCIe 3.0 x4, read up to 3500MB/s.',
            'warranty' => '5 Tahun Resmi',
        ], [
            ['key' => 'capacity_gb', 'value' => '1000', 'value_numeric' => 1000, 'unit' => 'GB'],
            ['key' => 'form_factor', 'value' => 'M.2 2280'],
            ['key' => 'interface', 'value' => 'PCIe 3.0 x4 NVMe'],
        ], 18);

        // PSU
        $psu1 = $this->product([
            'sku' => 'PSU-CM-550W',
            'name' => 'Cooler Master MWE 550W 80+ Bronze',
            'slug' => 'cooler-master-mwe-550w-bronze',
            'category_id' => $categoryIds['PSU'],
            'brand_id' => $brandIds['Cooler Master'],
            'price' => 750000,
            'cost_price' => 670000,
            'description' => '550W 80+ Bronze, non modular.',
            'warranty' => '5 Tahun',
        ], [
            ['key' => 'wattage', 'value' => '550', 'value_numeric' => 550, 'unit' => 'W'],
            ['key' => 'efficiency', 'value' => '80+ Bronze'],
            ['key' => 'modular', 'value' => 'Non-Modular'],
            ['key' => 'form_factor', 'value' => 'ATX'],
        ], 14);

        $psu2 = $this->product([
            'sku' => 'PSU-CRS-650W',
            'name' => 'Corsair CV650 650W 80+ Bronze',
            'slug' => 'corsair-cv650-650w-bronze',
            'category_id' => $categoryIds['PSU'],
            'brand_id' => $brandIds['Corsair'],
            'price' => 950000,
            'cost_price' => 860000,
            'description' => '650W 80+ Bronze.',
            'warranty' => '3 Tahun',
        ], [
            ['key' => 'wattage', 'value' => '650', 'value_numeric' => 650, 'unit' => 'W'],
            ['key' => 'efficiency', 'value' => '80+ Bronze'],
            ['key' => 'modular', 'value' => 'Non-Modular'],
            ['key' => 'form_factor', 'value' => 'ATX'],
        ], 7);

        // Casing
        $case1 = $this->product([
            'sku' => 'CASE-LL-Q58',
            'name' => 'Lian Li Q58 White (ITX)',
            'slug' => 'lian-li-q58-white',
            'category_id' => $categoryIds['Casing'],
            'brand_id' => $brandIds['Lian Li'],
            'price' => 1750000,
            'cost_price' => 1600000,
            'description' => 'Mini ITX, dual chamber, tempered glass.',
            'warranty' => '1 Tahun',
        ], [
            ['key' => 'form_factor', 'value' => 'Mini ITX'],
            ['key' => 'supported_form_factors', 'value' => 'Mini ITX'],
            ['key' => 'gpu_clearance_mm', 'value' => '325', 'value_numeric' => 325, 'unit' => 'mm'],
            ['key' => 'cooler_clearance_mm', 'value' => '70', 'value_numeric' => 70, 'unit' => 'mm'],
        ], 4);

        $case2 = $this->product([
            'sku' => 'CASE-CM-MB600',
            'name' => 'Cooler Master MasterBox MB600L V2',
            'slug' => 'cooler-master-masterbox-mb600l-v2',
            'category_id' => $categoryIds['Casing'],
            'brand_id' => $brandIds['Cooler Master'],
            'price' => 720000,
            'cost_price' => 650000,
            'description' => 'Micro ATX / ATX, mesh front.',
            'warranty' => '1 Tahun',
        ], [
            ['key' => 'form_factor', 'value' => 'ATX'],
            ['key' => 'supported_form_factors', 'value' => 'ATX, Micro ATX, Mini ITX'],
            ['key' => 'gpu_clearance_mm', 'value' => '360', 'value_numeric' => 360, 'unit' => 'mm'],
            ['key' => 'cooler_clearance_mm', 'value' => '161', 'value_numeric' => 161, 'unit' => 'mm'],
        ], 11);

        // Cooler
        $cooler1 = $this->product([
            'sku' => 'CLR-DC-AG400',
            'name' => 'DeepCool AG400',
            'slug' => 'deepcool-ag400',
            'category_id' => $categoryIds['CPU Cooler'],
            'brand_id' => $brandIds['DeepCool'],
            'price' => 420000,
            'cost_price' => 370000,
            'description' => 'Tower cooler single fan, height 155mm.',
            'warranty' => '1 Tahun',
        ], [
            ['key' => 'height_mm', 'value' => '155', 'value_numeric' => 155, 'unit' => 'mm'],
            ['key' => 'socket_support', 'value' => 'AM4/AM5/LGA1700'],
            ['key' => 'tdp_rating_watt', 'value' => '220', 'value_numeric' => 220, 'unit' => 'W'],
        ], 13);

        $cooler2 = $this->product([
            'sku' => 'CLR-DC-AK400',
            'name' => 'DeepCool AK400',
            'slug' => 'deepcool-ak400',
            'category_id' => $categoryIds['CPU Cooler'],
            'brand_id' => $brandIds['DeepCool'],
            'price' => 520000,
            'cost_price' => 460000,
            'description' => 'Tower cooler, height 160mm.',
            'warranty' => '1 Tahun',
        ], [
            ['key' => 'height_mm', 'value' => '160', 'value_numeric' => 160, 'unit' => 'mm'],
            ['key' => 'socket_support', 'value' => 'AM4/AM5/LGA1700'],
            ['key' => 'tdp_rating_watt', 'value' => '220', 'value_numeric' => 220, 'unit' => 'W'],
        ], 9);

        $this->attachImage($cpu1);
        $this->attachImage($cpu2);
        $this->attachImage($mb1);
        $this->attachImage($mb2);
        $this->attachImage($ram1);
        $this->attachImage($gpu1);
        $this->attachImage($gpu2);
        $this->attachImage($ssd1);
        $this->attachImage($psu1);
        $this->attachImage($psu2);
        $this->attachImage($case1);
        $this->attachImage($case2);
        $this->attachImage($cooler1);
        $this->attachImage($cooler2);

        $stockData = [
            [$cpu1, 15, 3], [$cpu2, 12, 3], [$mb1, 10, 2], [$mb2, 8, 2],
            [$ram1, 20, 5], [$gpu1, 6, 2], [$gpu2, 9, 2], [$ssd1, 18, 4],
            [$psu1, 14, 3], [$psu2, 7, 2], [$case1, 4, 1], [$case2, 11, 3],
            [$cooler1, 13, 3], [$cooler2, 9, 2],
        ];

        foreach ($stockData as [$product, $stock, $min]) {
            Inventory::query()->create([
                'product_id' => $product->id,
                'current_stock' => $stock,
                'min_stock' => $min,
            ]);
        }
    }

    private function product(array $attributes, array $specs, int $soldCount = 0): Product
    {
        $product = Product::query()->create($attributes + [
            'is_active' => true,
            'sold_count' => $soldCount,
            'is_featured' => $soldCount >= 10,
        ]);

        foreach ($specs as $i => $spec) {
            ProductSpec::query()->create($spec + ['product_id' => $product->id, 'sort_order' => $i]);
        }

        return $product;
    }

    private function attachImage(Product $product): void
    {
        ProductImage::query()->create([
            'product_id' => $product->id,
            'path' => 'products/placeholder.svg',
            'is_primary' => true,
        ]);
    }
}
