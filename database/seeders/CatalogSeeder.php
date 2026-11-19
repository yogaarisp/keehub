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
        $categories = array (
  0 => 
  array (
    'id' => 1,
    'name' => 'CPU',
    'slug' => 'cpu',
    'icon' => 'cpu',
    'sort_order' => 0,
  ),
  1 => 
  array (
    'id' => 2,
    'name' => 'Motherboard',
    'slug' => 'motherboard',
    'icon' => 'circuit-board',
    'sort_order' => 1,
  ),
  2 => 
  array (
    'id' => 3,
    'name' => 'GPU',
    'slug' => 'gpu',
    'icon' => 'video-camera',
    'sort_order' => 2,
  ),
  3 => 
  array (
    'id' => 4,
    'name' => 'RAM',
    'slug' => 'ram',
    'icon' => 'memory-chip',
    'sort_order' => 3,
  ),
  4 => 
  array (
    'id' => 5,
    'name' => 'SSD',
    'slug' => 'ssd',
    'icon' => 'circle-stack',
    'sort_order' => 4,
  ),
  5 => 
  array (
    'id' => 6,
    'name' => 'HDD',
    'slug' => 'hdd',
    'icon' => 'archive-box',
    'sort_order' => 5,
  ),
  6 => 
  array (
    'id' => 7,
    'name' => 'PSU',
    'slug' => 'psu',
    'icon' => 'bolt',
    'sort_order' => 6,
  ),
  7 => 
  array (
    'id' => 8,
    'name' => 'Casing',
    'slug' => 'casing',
    'icon' => 'squares-2x2',
    'sort_order' => 7,
  ),
  8 => 
  array (
    'id' => 9,
    'name' => 'CPU Cooler',
    'slug' => 'cpu-cooler',
    'icon' => 'fire',
    'sort_order' => 8,
  ),
  9 => 
  array (
    'id' => 10,
    'name' => 'Monitor',
    'slug' => 'monitor',
    'icon' => 'tv',
    'sort_order' => 9,
  ),
  10 => 
  array (
    'id' => 11,
    'name' => 'Keyboard',
    'slug' => 'keyboard',
    'icon' => 'keyboard',
    'sort_order' => 10,
  ),
  11 => 
  array (
    'id' => 12,
    'name' => 'Mouse',
    'slug' => 'mouse',
    'icon' => 'cursor-arrow-rays',
    'sort_order' => 11,
  ),
  12 => 
  array (
    'id' => 13,
    'name' => 'Networking',
    'slug' => 'networking',
    'icon' => 'wifi',
    'sort_order' => 12,
  ),
);

        foreach ($categories as $c) {
            Category::query()->updateOrCreate(['slug' => $c['slug']], $c);
        }

        $brands = array (
  0 => 
  array (
    'id' => 1,
    'name' => 'AMD',
    'slug' => 'amd',
  ),
  1 => 
  array (
    'id' => 2,
    'name' => 'Intel',
    'slug' => 'intel',
  ),
  2 => 
  array (
    'id' => 3,
    'name' => 'ASUS',
    'slug' => 'asus',
  ),
  3 => 
  array (
    'id' => 4,
    'name' => 'MSI',
    'slug' => 'msi',
  ),
  4 => 
  array (
    'id' => 5,
    'name' => 'Gigabyte',
    'slug' => 'gigabyte',
  ),
  5 => 
  array (
    'id' => 6,
    'name' => 'Corsair',
    'slug' => 'corsair',
  ),
  6 => 
  array (
    'id' => 7,
    'name' => 'Kingston',
    'slug' => 'kingston',
  ),
  7 => 
  array (
    'id' => 8,
    'name' => 'Samsung',
    'slug' => 'samsung',
  ),
  8 => 
  array (
    'id' => 9,
    'name' => 'Lian Li',
    'slug' => 'lian-li',
  ),
  9 => 
  array (
    'id' => 10,
    'name' => 'Cooler Master',
    'slug' => 'cooler-master',
  ),
  10 => 
  array (
    'id' => 11,
    'name' => 'DeepCool',
    'slug' => 'deepcool',
  ),
  11 => 
  array (
    'id' => 12,
    'name' => 'NVIDIA',
    'slug' => 'nvidia',
  ),
  12 => 
  array (
    'id' => 13,
    'name' => 'VenomRX',
    'slug' => 'venomrx',
  ),
  13 => 
  array (
    'id' => 14,
    'name' => 'V-GeN',
    'slug' => 'v-gen',
  ),
  14 => 
  array (
    'id' => 15,
    'name' => 'TeamGroup',
    'slug' => 'teamgroup',
  ),
  15 => 
  array (
    'id' => 16,
    'name' => 'Apacer',
    'slug' => 'apacer',
  ),
  16 => 
  array (
    'id' => 17,
    'name' => 'Western Digital',
    'slug' => 'western-digital',
  ),
  17 => 
  array (
    'id' => 18,
    'name' => 'Colorful',
    'slug' => 'colorful',
  ),
  18 => 
  array (
    'id' => 19,
    'name' => 'Ocypus',
    'slug' => 'ocypus',
  ),
  19 => 
  array (
    'id' => 20,
    'name' => 'Logitech',
    'slug' => 'logitech',
  ),
  20 => 
  array (
    'id' => 21,
    'name' => 'PC Cooler',
    'slug' => 'pc-cooler',
  ),
);

        foreach ($brands as $b) {
            Brand::query()->updateOrCreate(['slug' => $b['slug']], $b);
        }

        $products = array (
  0 => 
  array (
    'attributes' => 
    array (
      'sku' => 'CPU-AMD-5600',
      'name' => 'AMD Ryzen 5 5600',
      'slug' => 'amd-ryzen-5-5600',
      'category_id' => 1,
      'brand_id' => 1,
      'variant_group' => NULL,
      'variant_label' => NULL,
      'variant_type' => 'Kapasitas',
      'description' => '6 core 12 thread, combo am4 dengan B550M atau A520M, garansi resmi 3 tahun',
      'cost_price' => 2100000,
      'price' => 2350000,
      'warranty' => '3 Tahun Resmi',
      'dimensions' => NULL,
      'is_active' => true,
      'is_featured' => true,
    ),
    'specs' => 
    array (
      0 => 
      array (
        'key' => 'socket',
        'value' => 'AM4',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 0,
      ),
      1 => 
      array (
        'key' => 'core',
        'value' => '6',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 1,
      ),
      2 => 
      array (
        'key' => 'thread',
        'value' => '12',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 2,
      ),
      3 => 
      array (
        'key' => 'base_clock',
        'value' => '3.5 GHz',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 3,
      ),
      4 => 
      array (
        'key' => 'boost_clock',
        'value' => '4.4 GHz',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 4,
      ),
      5 => 
      array (
        'key' => 'tdp_watt',
        'value' => '65',
        'value_numeric' => 65.0,
        'unit' => 'W',
        'sort_order' => 5,
      ),
      6 => 
      array (
        'key' => 'architecture',
        'value' => 'Zen 3',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 6,
      ),
      7 => 
      array (
        'key' => 'integrated_graphics',
        'value' => 'Tidak',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 7,
      ),
    ),
    'stock' => 15,
    'min_stock' => 3,
    'images' => 
    array (
      0 => 
      array (
        'path' => 'products/01M776RB35B2WRWVGM3KVQKFFQ.jpg',
        'is_primary' => true,
        'sort_order' => 0,
      ),
    ),
  ),
  1 => 
  array (
    'attributes' => 
    array (
      'sku' => 'CPU-INT-12400F',
      'name' => 'Intel Core i5-12400F',
      'slug' => 'intel-core-i5-12400f',
      'category_id' => 1,
      'brand_id' => 2,
      'variant_group' => NULL,
      'variant_label' => NULL,
      'variant_type' => 'Kapasitas',
      'description' => '6 core 12 thread LGA1700, performa gaming kelas menengah.',
      'cost_price' => 2050000,
      'price' => 2250000,
      'warranty' => '3 Tahun Resmi',
      'dimensions' => NULL,
      'is_active' => true,
      'is_featured' => true,
    ),
    'specs' => 
    array (
      0 => 
      array (
        'key' => 'socket',
        'value' => 'LGA1700',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 0,
      ),
      1 => 
      array (
        'key' => 'core',
        'value' => '6',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 1,
      ),
      2 => 
      array (
        'key' => 'thread',
        'value' => '12',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 2,
      ),
      3 => 
      array (
        'key' => 'boost_clock',
        'value' => '4.4 GHz',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 3,
      ),
      4 => 
      array (
        'key' => 'tdp_watt',
        'value' => '65',
        'value_numeric' => 65.0,
        'unit' => 'W',
        'sort_order' => 4,
      ),
      5 => 
      array (
        'key' => 'integrated_graphics',
        'value' => 'Tidak (F-series)',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 5,
      ),
    ),
    'stock' => 12,
    'min_stock' => 3,
    'images' => 
    array (
      0 => 
      array (
        'path' => 'products/placeholder.svg',
        'is_primary' => true,
        'sort_order' => 0,
      ),
    ),
  ),
  2 => 
  array (
    'attributes' => 
    array (
      'sku' => 'MB-ASUS-A520M',
      'name' => 'ASUS A520M-K',
      'slug' => 'asus-a520m-k',
      'category_id' => 2,
      'brand_id' => 3,
      'variant_group' => NULL,
      'variant_label' => NULL,
      'variant_type' => 'Kapasitas',
      'description' => 'Micro ATX AM4 DDR4, cocok untuk Ryzen 5000 series.',
      'cost_price' => 950000,
      'price' => 1050000,
      'warranty' => '3 Tahun Resmi',
      'dimensions' => NULL,
      'is_active' => true,
      'is_featured' => true,
    ),
    'specs' => 
    array (
      0 => 
      array (
        'key' => 'socket',
        'value' => 'AM4',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 0,
      ),
      1 => 
      array (
        'key' => 'chipset',
        'value' => 'A520',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 1,
      ),
      2 => 
      array (
        'key' => 'ram_type',
        'value' => 'DDR4',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 2,
      ),
      3 => 
      array (
        'key' => 'ram_slots',
        'value' => '2',
        'value_numeric' => 2.0,
        'unit' => NULL,
        'sort_order' => 3,
      ),
      4 => 
      array (
        'key' => 'max_ram_gb',
        'value' => '64',
        'value_numeric' => 64.0,
        'unit' => 'GB',
        'sort_order' => 4,
      ),
      5 => 
      array (
        'key' => 'm2_slots',
        'value' => '1',
        'value_numeric' => 1.0,
        'unit' => NULL,
        'sort_order' => 5,
      ),
      6 => 
      array (
        'key' => 'form_factor',
        'value' => 'Micro ATX',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 6,
      ),
    ),
    'stock' => 10,
    'min_stock' => 2,
    'images' => 
    array (
      0 => 
      array (
        'path' => 'products/placeholder.svg',
        'is_primary' => true,
        'sort_order' => 0,
      ),
    ),
  ),
  3 => 
  array (
    'attributes' => 
    array (
      'sku' => 'MB-MSI-B550M',
      'name' => 'MSI B550M PRO-VDH WiFi',
      'slug' => 'msi-b550m-pro-vdh-wifi',
      'category_id' => 2,
      'brand_id' => 4,
      'variant_group' => NULL,
      'variant_label' => NULL,
      'variant_type' => 'Kapasitas',
      'description' => 'Micro ATX AM4 DDR4, PCIe 4.0, WiFi onboard.',
      'cost_price' => 1420000,
      'price' => 1550000,
      'warranty' => '3 Tahun Resmi',
      'dimensions' => NULL,
      'is_active' => true,
      'is_featured' => false,
    ),
    'specs' => 
    array (
      0 => 
      array (
        'key' => 'socket',
        'value' => 'AM4',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 0,
      ),
      1 => 
      array (
        'key' => 'chipset',
        'value' => 'B550',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 1,
      ),
      2 => 
      array (
        'key' => 'ram_type',
        'value' => 'DDR4',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 2,
      ),
      3 => 
      array (
        'key' => 'ram_slots',
        'value' => '4',
        'value_numeric' => 4.0,
        'unit' => NULL,
        'sort_order' => 3,
      ),
      4 => 
      array (
        'key' => 'max_ram_gb',
        'value' => '128',
        'value_numeric' => 128.0,
        'unit' => 'GB',
        'sort_order' => 4,
      ),
      5 => 
      array (
        'key' => 'm2_slots',
        'value' => '2',
        'value_numeric' => 2.0,
        'unit' => NULL,
        'sort_order' => 5,
      ),
      6 => 
      array (
        'key' => 'form_factor',
        'value' => 'Micro ATX',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 6,
      ),
    ),
    'stock' => 8,
    'min_stock' => 2,
    'images' => 
    array (
      0 => 
      array (
        'path' => 'products/placeholder.svg',
        'is_primary' => true,
        'sort_order' => 0,
      ),
    ),
  ),
  4 => 
  array (
    'attributes' => 
    array (
      'sku' => 'RAM-KST-16-3200',
      'name' => 'Kingston Fury Beast DDR4 16GB (2x8GB) 3200MHz',
      'slug' => 'kingston-fury-beast-ddr4-16gb-3200',
      'category_id' => 4,
      'brand_id' => 7,
      'variant_group' => NULL,
      'variant_label' => NULL,
      'variant_type' => 'Kapasitas',
      'description' => 'Kit dual channel 2x8GB DDR4 3200MHz.',
      'cost_price' => 680000,
      'price' => 750000,
      'warranty' => 'Lifetime',
      'dimensions' => NULL,
      'is_active' => true,
      'is_featured' => true,
    ),
    'specs' => 
    array (
      0 => 
      array (
        'key' => 'generation',
        'value' => 'DDR4',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 0,
      ),
      1 => 
      array (
        'key' => 'capacity_gb',
        'value' => '16',
        'value_numeric' => 16.0,
        'unit' => 'GB',
        'sort_order' => 1,
      ),
      2 => 
      array (
        'key' => 'frequency_mhz',
        'value' => '3200',
        'value_numeric' => 3200.0,
        'unit' => 'MHz',
        'sort_order' => 2,
      ),
      3 => 
      array (
        'key' => 'cas_latency',
        'value' => 'CL16',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 3,
      ),
      4 => 
      array (
        'key' => 'module_count',
        'value' => '2',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 4,
      ),
    ),
    'stock' => 20,
    'min_stock' => 5,
    'images' => 
    array (
      0 => 
      array (
        'path' => 'products/placeholder.svg',
        'is_primary' => true,
        'sort_order' => 0,
      ),
    ),
  ),
  5 => 
  array (
    'attributes' => 
    array (
      'sku' => 'GPU-MSI-4060',
      'name' => 'MSI RTX 4060 Ventus 2X 8GB',
      'slug' => 'msi-rtx-4060-ventus-2x-8gb',
      'category_id' => 3,
      'brand_id' => 4,
      'variant_group' => NULL,
      'variant_label' => NULL,
      'variant_type' => 'Kapasitas',
      'description' => 'RTX 4060 8GB GDDR6, dual fan, 1080p gaming ray tracing.',
      'cost_price' => 5250000,
      'price' => 5650000,
      'warranty' => '3 Tahun Resmi',
      'dimensions' => NULL,
      'is_active' => true,
      'is_featured' => false,
    ),
    'specs' => 
    array (
      0 => 
      array (
        'key' => 'vram_gb',
        'value' => '8',
        'value_numeric' => 8.0,
        'unit' => 'GB',
        'sort_order' => 0,
      ),
      1 => 
      array (
        'key' => 'memory_type',
        'value' => 'GDDR6',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 1,
      ),
      2 => 
      array (
        'key' => 'power_consumption_watt',
        'value' => '115',
        'value_numeric' => 115.0,
        'unit' => 'W',
        'sort_order' => 2,
      ),
      3 => 
      array (
        'key' => 'length_mm',
        'value' => '199',
        'value_numeric' => 199.0,
        'unit' => 'mm',
        'sort_order' => 3,
      ),
      4 => 
      array (
        'key' => 'recommended_psu_watt',
        'value' => '550',
        'value_numeric' => 550.0,
        'unit' => 'W',
        'sort_order' => 4,
      ),
      5 => 
      array (
        'key' => 'interface',
        'value' => 'PCIe 4.0 x8',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 5,
      ),
    ),
    'stock' => 6,
    'min_stock' => 2,
    'images' => 
    array (
      0 => 
      array (
        'path' => 'products/placeholder.svg',
        'is_primary' => true,
        'sort_order' => 0,
      ),
    ),
  ),
  6 => 
  array (
    'attributes' => 
    array (
      'sku' => 'GPU-GLB-3050',
      'name' => 'Gigabyte RTX 3050 Eagle OC 8GB',
      'slug' => 'gigabyte-rtx-3050-eagle-oc-8gb',
      'category_id' => 3,
      'brand_id' => 5,
      'variant_group' => NULL,
      'variant_label' => NULL,
      'variant_type' => 'Kapasitas',
      'description' => 'RTX 3050 8GB, entry 1080p gaming.',
      'cost_price' => 3200000,
      'price' => 3500000,
      'warranty' => '2 Tahun Resmi',
      'dimensions' => NULL,
      'is_active' => true,
      'is_featured' => false,
    ),
    'specs' => 
    array (
      0 => 
      array (
        'key' => 'vram_gb',
        'value' => '8',
        'value_numeric' => 8.0,
        'unit' => 'GB',
        'sort_order' => 0,
      ),
      1 => 
      array (
        'key' => 'memory_type',
        'value' => 'GDDR6',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 1,
      ),
      2 => 
      array (
        'key' => 'power_consumption_watt',
        'value' => '130',
        'value_numeric' => 130.0,
        'unit' => 'W',
        'sort_order' => 2,
      ),
      3 => 
      array (
        'key' => 'length_mm',
        'value' => '212',
        'value_numeric' => 212.0,
        'unit' => 'mm',
        'sort_order' => 3,
      ),
      4 => 
      array (
        'key' => 'recommended_psu_watt',
        'value' => '550',
        'value_numeric' => 550.0,
        'unit' => 'W',
        'sort_order' => 4,
      ),
      5 => 
      array (
        'key' => 'interface',
        'value' => 'PCIe 4.0 x8',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 5,
      ),
    ),
    'stock' => 9,
    'min_stock' => 2,
    'images' => 
    array (
      0 => 
      array (
        'path' => 'products/placeholder.svg',
        'is_primary' => true,
        'sort_order' => 0,
      ),
    ),
  ),
  7 => 
  array (
    'attributes' => 
    array (
      'sku' => 'SSD-SMG-1TB',
      'name' => 'Samsung 980 1TB NVMe M.2',
      'slug' => 'samsung-980-1tb-nvme',
      'category_id' => 5,
      'brand_id' => 8,
      'variant_group' => NULL,
      'variant_label' => NULL,
      'variant_type' => 'Kapasitas',
      'description' => 'NVMe PCIe 3.0 x4, read up to 3500MB/s.',
      'cost_price' => 1100000,
      'price' => 1250000,
      'warranty' => '5 Tahun Resmi',
      'dimensions' => NULL,
      'is_active' => true,
      'is_featured' => true,
    ),
    'specs' => 
    array (
      0 => 
      array (
        'key' => 'capacity_gb',
        'value' => '1000',
        'value_numeric' => 1000.0,
        'unit' => 'GB',
        'sort_order' => 0,
      ),
      1 => 
      array (
        'key' => 'form_factor',
        'value' => 'M.2 2280',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 1,
      ),
      2 => 
      array (
        'key' => 'interface',
        'value' => 'PCIe 3.0 x4 NVMe',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 2,
      ),
    ),
    'stock' => 18,
    'min_stock' => 4,
    'images' => 
    array (
      0 => 
      array (
        'path' => 'products/placeholder.svg',
        'is_primary' => true,
        'sort_order' => 0,
      ),
    ),
  ),
  8 => 
  array (
    'attributes' => 
    array (
      'sku' => 'PSU-CM-550W',
      'name' => 'Cooler Master MWE 550W 80+ Bronze',
      'slug' => 'cooler-master-mwe-550w-bronze',
      'category_id' => 7,
      'brand_id' => 10,
      'variant_group' => NULL,
      'variant_label' => NULL,
      'variant_type' => 'Kapasitas',
      'description' => '550W 80+ Bronze, non modular.',
      'cost_price' => 670000,
      'price' => 750000,
      'warranty' => '5 Tahun',
      'dimensions' => NULL,
      'is_active' => true,
      'is_featured' => true,
    ),
    'specs' => 
    array (
      0 => 
      array (
        'key' => 'wattage',
        'value' => '550',
        'value_numeric' => 550.0,
        'unit' => 'W',
        'sort_order' => 0,
      ),
      1 => 
      array (
        'key' => 'efficiency',
        'value' => '80+ Bronze',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 1,
      ),
      2 => 
      array (
        'key' => 'modular',
        'value' => 'Non-Modular',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 2,
      ),
      3 => 
      array (
        'key' => 'form_factor',
        'value' => 'ATX',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 3,
      ),
    ),
    'stock' => 14,
    'min_stock' => 3,
    'images' => 
    array (
      0 => 
      array (
        'path' => 'products/placeholder.svg',
        'is_primary' => true,
        'sort_order' => 0,
      ),
    ),
  ),
  9 => 
  array (
    'attributes' => 
    array (
      'sku' => 'PSU-CRS-650W',
      'name' => 'Corsair CV650 650W 80+ Bronze',
      'slug' => 'corsair-cv650-650w-bronze',
      'category_id' => 7,
      'brand_id' => 6,
      'variant_group' => NULL,
      'variant_label' => NULL,
      'variant_type' => 'Kapasitas',
      'description' => '650W 80+ Bronze.',
      'cost_price' => 860000,
      'price' => 950000,
      'warranty' => '3 Tahun',
      'dimensions' => NULL,
      'is_active' => true,
      'is_featured' => false,
    ),
    'specs' => 
    array (
      0 => 
      array (
        'key' => 'wattage',
        'value' => '650',
        'value_numeric' => 650.0,
        'unit' => 'W',
        'sort_order' => 0,
      ),
      1 => 
      array (
        'key' => 'efficiency',
        'value' => '80+ Bronze',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 1,
      ),
      2 => 
      array (
        'key' => 'modular',
        'value' => 'Non-Modular',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 2,
      ),
      3 => 
      array (
        'key' => 'form_factor',
        'value' => 'ATX',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 3,
      ),
    ),
    'stock' => 7,
    'min_stock' => 2,
    'images' => 
    array (
      0 => 
      array (
        'path' => 'products/placeholder.svg',
        'is_primary' => true,
        'sort_order' => 0,
      ),
    ),
  ),
  10 => 
  array (
    'attributes' => 
    array (
      'sku' => 'CASE-LL-Q58',
      'name' => 'Lian Li Q58 White (ITX)',
      'slug' => 'lian-li-q58-white',
      'category_id' => 8,
      'brand_id' => 9,
      'variant_group' => NULL,
      'variant_label' => NULL,
      'variant_type' => 'Kapasitas',
      'description' => 'Mini ITX, dual chamber, tempered glass.',
      'cost_price' => 2250000,
      'price' => 2490000,
      'warranty' => '1 Tahun',
      'dimensions' => NULL,
      'is_active' => true,
      'is_featured' => false,
    ),
    'specs' => 
    array (
      0 => 
      array (
        'key' => 'form_factor',
        'value' => 'Mini ITX',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 0,
      ),
      1 => 
      array (
        'key' => 'supported_form_factors',
        'value' => 'Mini ITX',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 1,
      ),
      2 => 
      array (
        'key' => 'gpu_clearance_mm',
        'value' => '325',
        'value_numeric' => 325.0,
        'unit' => 'mm',
        'sort_order' => 2,
      ),
      3 => 
      array (
        'key' => 'cooler_clearance_mm',
        'value' => '70',
        'value_numeric' => 70.0,
        'unit' => 'mm',
        'sort_order' => 3,
      ),
    ),
    'stock' => 4,
    'min_stock' => 1,
    'images' => 
    array (
      0 => 
      array (
        'path' => 'products/placeholder.svg',
        'is_primary' => true,
        'sort_order' => 0,
      ),
    ),
  ),
  11 => 
  array (
    'attributes' => 
    array (
      'sku' => 'CASE-CM-MB600',
      'name' => 'Cooler Master MasterBox MB600L V2',
      'slug' => 'cooler-master-masterbox-mb600l-v2',
      'category_id' => 8,
      'brand_id' => 10,
      'variant_group' => NULL,
      'variant_label' => NULL,
      'variant_type' => 'Kapasitas',
      'description' => 'Micro ATX / ATX, mesh front.',
      'cost_price' => 650000,
      'price' => 720000,
      'warranty' => '1 Tahun',
      'dimensions' => NULL,
      'is_active' => true,
      'is_featured' => true,
    ),
    'specs' => 
    array (
      0 => 
      array (
        'key' => 'form_factor',
        'value' => 'ATX',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 0,
      ),
      1 => 
      array (
        'key' => 'supported_form_factors',
        'value' => 'ATX, Micro ATX, Mini ITX',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 1,
      ),
      2 => 
      array (
        'key' => 'gpu_clearance_mm',
        'value' => '360',
        'value_numeric' => 360.0,
        'unit' => 'mm',
        'sort_order' => 2,
      ),
      3 => 
      array (
        'key' => 'cooler_clearance_mm',
        'value' => '161',
        'value_numeric' => 161.0,
        'unit' => 'mm',
        'sort_order' => 3,
      ),
    ),
    'stock' => 11,
    'min_stock' => 3,
    'images' => 
    array (
      0 => 
      array (
        'path' => 'products/placeholder.svg',
        'is_primary' => true,
        'sort_order' => 0,
      ),
    ),
  ),
  12 => 
  array (
    'attributes' => 
    array (
      'sku' => 'CLR-DC-AG400',
      'name' => 'DeepCool AG400',
      'slug' => 'deepcool-ag400',
      'category_id' => 9,
      'brand_id' => 11,
      'variant_group' => NULL,
      'variant_label' => NULL,
      'variant_type' => 'Kapasitas',
      'description' => 'Tower cooler single fan, height 155mm.',
      'cost_price' => 370000,
      'price' => 420000,
      'warranty' => '1 Tahun',
      'dimensions' => NULL,
      'is_active' => true,
      'is_featured' => true,
    ),
    'specs' => 
    array (
      0 => 
      array (
        'key' => 'height_mm',
        'value' => '155',
        'value_numeric' => 155.0,
        'unit' => 'mm',
        'sort_order' => 0,
      ),
      1 => 
      array (
        'key' => 'socket_support',
        'value' => 'AM4/AM5/LGA1700',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 1,
      ),
      2 => 
      array (
        'key' => 'tdp_rating_watt',
        'value' => '220',
        'value_numeric' => 220.0,
        'unit' => 'W',
        'sort_order' => 2,
      ),
    ),
    'stock' => 13,
    'min_stock' => 3,
    'images' => 
    array (
      0 => 
      array (
        'path' => 'products/placeholder.svg',
        'is_primary' => true,
        'sort_order' => 0,
      ),
    ),
  ),
  13 => 
  array (
    'attributes' => 
    array (
      'sku' => 'CLR-DC-AK400',
      'name' => 'DeepCool AK400',
      'slug' => 'deepcool-ak400',
      'category_id' => 9,
      'brand_id' => 11,
      'variant_group' => NULL,
      'variant_label' => NULL,
      'variant_type' => 'Kapasitas',
      'description' => 'Tower cooler, height 160mm.',
      'cost_price' => 460000,
      'price' => 520000,
      'warranty' => '1 Tahun',
      'dimensions' => NULL,
      'is_active' => true,
      'is_featured' => false,
    ),
    'specs' => 
    array (
      0 => 
      array (
        'key' => 'height_mm',
        'value' => '160',
        'value_numeric' => 160.0,
        'unit' => 'mm',
        'sort_order' => 0,
      ),
      1 => 
      array (
        'key' => 'socket_support',
        'value' => 'AM4/AM5/LGA1700',
        'value_numeric' => NULL,
        'unit' => NULL,
        'sort_order' => 1,
      ),
      2 => 
      array (
        'key' => 'tdp_rating_watt',
        'value' => '220',
        'value_numeric' => 220.0,
        'unit' => 'W',
        'sort_order' => 2,
      ),
    ),
    'stock' => 9,
    'min_stock' => 2,
    'images' => 
    array (
      0 => 
      array (
        'path' => 'products/placeholder.svg',
        'is_primary' => true,
        'sort_order' => 0,
      ),
    ),
  ),
  14 => 
  array (
    'attributes' => 
    array (
      'sku' => 'RAM-SMSG-DDR34',
      'name' => 'RAM DDR3 4GB Longdimm',
      'slug' => 'ram-ddr3-4gb-longdimm',
      'category_id' => 4,
      'brand_id' => 8,
      'variant_group' => NULL,
      'variant_label' => NULL,
      'variant_type' => 'Kapasitas',
      'description' => 'RAM DDR3 12800U Longdimm',
      'cost_price' => 120000,
      'price' => 145000,
      'warranty' => NULL,
      'dimensions' => NULL,
      'is_active' => true,
      'is_featured' => false,
    ),
    'specs' => 
    array (
    ),
    'stock' => 4,
    'min_stock' => 2,
    'images' => 
    array (
    ),
  ),
  15 => 
  array (
    'attributes' => 
    array (
      'sku' => 'SSD-VNMRX-128gb',
      'name' => 'SSD SATA VenomRX 128GB',
      'slug' => 'ssd-sata-venomrx-128gb',
      'category_id' => 5,
      'brand_id' => 13,
      'variant_group' => 'ssd-sata-venomrx',
      'variant_label' => '128GB',
      'variant_type' => 'Kapasitas',
      'description' => 'Spesifikasi Produk :



Storage Capacity : 128GB / 256GB / 512GB / 1TB

Form factor : 2.5" SATA III (6Gb/s)

Max sequential read speed : 545MB/s

Max sequential write speed : 435MB/s

Dimensions (L × W × H) : 100 mm x 69 mm x 7 mm

',
      'cost_price' => 400000,
      'price' => 520000,
      'warranty' => '3 Tahun Garansi Resmi',
      'dimensions' => '100 mm x 69 mm x 7 mm',
      'is_active' => true,
      'is_featured' => false,
    ),
    'specs' => 
    array (
    ),
    'stock' => 5,
    'min_stock' => 2,
    'images' => 
    array (
    ),
  ),
  16 => 
  array (
    'attributes' => 
    array (
      'sku' => 'SSD-VNMRX-256GB',
      'name' => 'SSD SATA VenomRX 256GB',
      'slug' => 'ssd-sata-venomrx-256gb',
      'category_id' => 5,
      'brand_id' => 13,
      'variant_group' => 'ssd-sata-venomrx',
      'variant_label' => '256GB',
      'variant_type' => 'Kapasitas',
      'description' => 'Spesifikasi Produk :



Storage Capacity : 128GB / 256GB / 512GB / 1TB

Form factor : 2.5" SATA III (6Gb/s)

Max sequential read speed : 545MB/s

Max sequential write speed : 435MB/s

Dimensions (L × W × H) : 100 mm x 69 mm x 7 mm

',
      'cost_price' => 580000,
      'price' => 754000,
      'warranty' => '3 Tahun Garansi Resmi',
      'dimensions' => '100 mm x 69 mm x 7 mm',
      'is_active' => true,
      'is_featured' => false,
    ),
    'specs' => 
    array (
    ),
    'stock' => 5,
    'min_stock' => 2,
    'images' => 
    array (
    ),
  ),
  17 => 
  array (
    'attributes' => 
    array (
      'sku' => 'SSD-VNMRX-512GB',
      'name' => 'SSD SATA VenomRX 512GB',
      'slug' => 'ssd-sata-venomrx-512gb',
      'category_id' => 5,
      'brand_id' => 13,
      'variant_group' => 'ssd-sata-venomrx',
      'variant_label' => '512GB',
      'variant_type' => 'Kapasitas',
      'description' => 'Spesifikasi Produk :



Storage Capacity : 128GB / 256GB / 512GB / 1TB

Form factor : 2.5" SATA III (6Gb/s)

Max sequential read speed : 545MB/s

Max sequential write speed : 435MB/s

Dimensions (L × W × H) : 100 mm x 69 mm x 7 mm

',
      'cost_price' => 1000000,
      'price' => 1300000,
      'warranty' => '3 Tahun Garansi Resmi',
      'dimensions' => '100 mm x 69 mm x 7 mm',
      'is_active' => true,
      'is_featured' => false,
    ),
    'specs' => 
    array (
    ),
    'stock' => 5,
    'min_stock' => 2,
    'images' => 
    array (
    ),
  ),
  18 => 
  array (
    'attributes' => 
    array (
      'sku' => 'SSD-VNMRX-1TB',
      'name' => 'SSD SATA VenomRX 1TB',
      'slug' => 'ssd-sata-venomrx-1tb',
      'category_id' => 5,
      'brand_id' => 13,
      'variant_group' => 'ssd-sata-venomrx',
      'variant_label' => '1TB',
      'variant_type' => 'Kapasitas',
      'description' => 'Spesifikasi Produk :



Storage Capacity : 128GB / 256GB / 512GB / 1TB

Form factor : 2.5" SATA III (6Gb/s)

Max sequential read speed : 545MB/s

Max sequential write speed : 435MB/s

Dimensions (L × W × H) : 100 mm x 69 mm x 7 mm

',
      'cost_price' => 2100000,
      'price' => 2730000,
      'warranty' => '3 Tahun Garansi Resmi',
      'dimensions' => '100 mm x 69 mm x 7 mm',
      'is_active' => true,
      'is_featured' => false,
    ),
    'specs' => 
    array (
    ),
    'stock' => 3,
    'min_stock' => 2,
    'images' => 
    array (
    ),
  ),
  19 => 
  array (
    'attributes' => 
    array (
      'sku' => 'SSD-VGEN-PLAT-128GB',
      'name' => 'V-GeN PLATINUM SSD SATA III 2.5" 128 GB',
      'slug' => 'v-gen-ssd-platinum-sata-iii-128gb',
      'category_id' => 5,
      'brand_id' => 14,
      'variant_group' => 'vgen-ssd-platinum-sata',
      'variant_label' => '128GB',
      'variant_type' => 'Kapasitas',
      'description' => 'Spesifikasi V-GeN SSD Platinum SATA III SOLID 2.5 Inch:

• Brand: V-GeN
• Model: Platinum SOLID Series
• Form Factor: 2.5 Inch (7mm Ultra Slim)
• Interface: SATA III 6Gb/s (Kompatibel mundur dengan SATA II 3Gb/s)
• Controller: High Quality Controller
• Kecepatan Baca (Read): Up to 550 MB/s
• Kecepatan Tulis (Write): Up to 477 - 520 MB/s
• Dimensi: 100 x 70 x 7 mm
• Garansi: 3 Tahun Garansi Resmi V-GeN (One to One Replacement di Service Center V-GeN Seluruh Indonesia)

Cocok untuk upgrade laptop lama, PC desktop, maupun dijadikan external storage dengan enclosure 2.5.',
      'cost_price' => 498000,
      'price' => 647000,
      'warranty' => '3 Tahun Garansi Resmi V-GeN',
      'dimensions' => '100 x 70 x 7 mm',
      'is_active' => true,
      'is_featured' => true,
    ),
    'specs' => 
    array (
    ),
    'stock' => 5,
    'min_stock' => 2,
    'images' => 
    array (
      0 => 
      array (
        'path' => 'products/vgen-ssd-sata-3.jpg',
        'is_primary' => true,
        'sort_order' => 0,
      ),
      1 => 
      array (
        'path' => 'products/vgen-ssd-platinum-sata.jpg',
        'is_primary' => false,
        'sort_order' => 0,
      ),
    ),
  ),
  20 => 
  array (
    'attributes' => 
    array (
      'sku' => 'SSD-VGEN-PLAT-256GB',
      'name' => 'V-GeN PLATINUM SSD SATA III 2.5" 256 GB',
      'slug' => 'v-gen-ssd-platinum-sata-iii-256gb',
      'category_id' => 5,
      'brand_id' => 14,
      'variant_group' => 'vgen-ssd-platinum-sata',
      'variant_label' => '256GB',
      'variant_type' => 'Kapasitas',
      'description' => 'Spesifikasi V-GeN SSD Platinum SATA III SOLID 2.5 Inch:

• Brand: V-GeN
• Model: Platinum SOLID Series
• Form Factor: 2.5 Inch (7mm Ultra Slim)
• Interface: SATA III 6Gb/s (Kompatibel mundur dengan SATA II 3Gb/s)
• Controller: High Quality Controller
• Kecepatan Baca (Read): Up to 550 MB/s
• Kecepatan Tulis (Write): Up to 477 - 520 MB/s
• Dimensi: 100 x 70 x 7 mm
• Garansi: 3 Tahun Garansi Resmi V-GeN (One to One Replacement di Service Center V-GeN Seluruh Indonesia)

Cocok untuk upgrade laptop lama, PC desktop, maupun dijadikan external storage dengan enclosure 2.5.',
      'cost_price' => 898000,
      'price' => 1167000,
      'warranty' => '3 Tahun Garansi Resmi V-GeN',
      'dimensions' => '100 x 70 x 7 mm',
      'is_active' => true,
      'is_featured' => false,
    ),
    'specs' => 
    array (
    ),
    'stock' => 5,
    'min_stock' => 2,
    'images' => 
    array (
      0 => 
      array (
        'path' => 'products/vgen-ssd-sata-3.jpg',
        'is_primary' => true,
        'sort_order' => 0,
      ),
      1 => 
      array (
        'path' => 'products/vgen-ssd-platinum-sata.jpg',
        'is_primary' => false,
        'sort_order' => 0,
      ),
    ),
  ),
  21 => 
  array (
    'attributes' => 
    array (
      'sku' => 'SSD-VGEN-PLAT-512GB',
      'name' => 'V-GeN PLATINUM SSD SATA III 2.5" 512 GB',
      'slug' => 'v-gen-ssd-platinum-sata-iii-512gb',
      'category_id' => 5,
      'brand_id' => 14,
      'variant_group' => 'vgen-ssd-platinum-sata',
      'variant_label' => '512GB',
      'variant_type' => 'Kapasitas',
      'description' => 'Spesifikasi V-GeN SSD Platinum SATA III SOLID 2.5 Inch:

• Brand: V-GeN
• Model: Platinum SOLID Series
• Form Factor: 2.5 Inch (7mm Ultra Slim)
• Interface: SATA III 6Gb/s (Kompatibel mundur dengan SATA II 3Gb/s)
• Controller: High Quality Controller
• Kecepatan Baca (Read): Up to 550 MB/s
• Kecepatan Tulis (Write): Up to 477 - 520 MB/s
• Dimensi: 100 x 70 x 7 mm
• Garansi: 3 Tahun Garansi Resmi V-GeN (One to One Replacement di Service Center V-GeN Seluruh Indonesia)

Cocok untuk upgrade laptop lama, PC desktop, maupun dijadikan external storage dengan enclosure 2.5.',
      'cost_price' => 1598000,
      'price' => 2077000,
      'warranty' => '3 Tahun Garansi Resmi V-GeN',
      'dimensions' => '100 x 70 x 7 mm',
      'is_active' => true,
      'is_featured' => false,
    ),
    'specs' => 
    array (
    ),
    'stock' => 5,
    'min_stock' => 2,
    'images' => 
    array (
      0 => 
      array (
        'path' => 'products/vgen-ssd-sata-3.jpg',
        'is_primary' => true,
        'sort_order' => 0,
      ),
      1 => 
      array (
        'path' => 'products/vgen-ssd-platinum-sata.jpg',
        'is_primary' => false,
        'sort_order' => 0,
      ),
    ),
  ),
  22 => 
  array (
    'attributes' => 
    array (
      'sku' => 'SSD-VGEN-PLAT-1TB',
      'name' => 'V-GeN PLATINUM SSD SATA III 2.5" 1 TB',
      'slug' => 'v-gen-ssd-platinum-sata-iii-1tb',
      'category_id' => 5,
      'brand_id' => 14,
      'variant_group' => 'vgen-ssd-platinum-sata',
      'variant_label' => '1TB',
      'variant_type' => 'Kapasitas',
      'description' => 'Spesifikasi V-GeN SSD Platinum SATA III SOLID 2.5 Inch:

• Brand: V-GeN
• Model: Platinum SOLID Series
• Form Factor: 2.5 Inch (7mm Ultra Slim)
• Interface: SATA III 6Gb/s (Kompatibel mundur dengan SATA II 3Gb/s)
• Controller: High Quality Controller
• Kecepatan Baca (Read): Up to 550 MB/s
• Kecepatan Tulis (Write): Up to 477 - 520 MB/s
• Dimensi: 100 x 70 x 7 mm
• Garansi: 3 Tahun Garansi Resmi V-GeN (One to One Replacement di Service Center V-GeN Seluruh Indonesia)

Cocok untuk upgrade laptop lama, PC desktop, maupun dijadikan external storage dengan enclosure 2.5.',
      'cost_price' => 3188000,
      'price' => 4144000,
      'warranty' => '3 Tahun Garansi Resmi V-GeN',
      'dimensions' => '100 x 70 x 7 mm',
      'is_active' => true,
      'is_featured' => false,
    ),
    'specs' => 
    array (
    ),
    'stock' => 3,
    'min_stock' => 2,
    'images' => 
    array (
      0 => 
      array (
        'path' => 'products/vgen-ssd-sata-3.jpg',
        'is_primary' => true,
        'sort_order' => 0,
      ),
      1 => 
      array (
        'path' => 'products/vgen-ssd-platinum-sata.jpg',
        'is_primary' => false,
        'sort_order' => 0,
      ),
    ),
  ),
  23 => 
  array (
    'attributes' => 
    array (
      'sku' => 'SSD-VGEN-PLAT-2TB',
      'name' => 'V-GeN PLATINUM SSD SATA III 2.5" 2 TB',
      'slug' => 'v-gen-ssd-platinum-sata-iii-2tb',
      'category_id' => 5,
      'brand_id' => 14,
      'variant_group' => 'vgen-ssd-platinum-sata',
      'variant_label' => '2TB',
      'variant_type' => 'Kapasitas',
      'description' => 'Spesifikasi V-GeN SSD Platinum SATA III SOLID 2.5 Inch:

• Brand: V-GeN
• Model: Platinum SOLID Series
• Form Factor: 2.5 Inch (7mm Ultra Slim)
• Interface: SATA III 6Gb/s (Kompatibel mundur dengan SATA II 3Gb/s)
• Controller: High Quality Controller
• Kecepatan Baca (Read): Up to 550 MB/s
• Kecepatan Tulis (Write): Up to 477 - 520 MB/s
• Dimensi: 100 x 70 x 7 mm
• Garansi: 3 Tahun Garansi Resmi V-GeN (One to One Replacement di Service Center V-GeN Seluruh Indonesia)

Cocok untuk upgrade laptop lama, PC desktop, maupun dijadikan external storage dengan enclosure 2.5.',
      'cost_price' => 5788000,
      'price' => 7524000,
      'warranty' => '3 Tahun Garansi Resmi V-GeN',
      'dimensions' => '100 x 70 x 7 mm',
      'is_active' => true,
      'is_featured' => false,
    ),
    'specs' => 
    array (
    ),
    'stock' => 2,
    'min_stock' => 1,
    'images' => 
    array (
      0 => 
      array (
        'path' => 'products/vgen-ssd-sata-3.jpg',
        'is_primary' => true,
        'sort_order' => 0,
      ),
    ),
  ),
  24 => 
  array (
    'attributes' => 
    array (
      'sku' => 'SSD-VGEN-PLAT-4TB',
      'name' => 'V-GeN PLATINUM SSD SATA III 2.5" 4 TB',
      'slug' => 'v-gen-ssd-platinum-sata-iii-4tb',
      'category_id' => 5,
      'brand_id' => 14,
      'variant_group' => 'vgen-ssd-platinum-sata',
      'variant_label' => '4TB',
      'variant_type' => 'Kapasitas',
      'description' => 'Spesifikasi V-GeN SSD Platinum SATA III SOLID 2.5 Inch:

• Brand: V-GeN
• Model: Platinum SOLID Series
• Form Factor: 2.5 Inch (7mm Ultra Slim)
• Interface: SATA III 6Gb/s (Kompatibel mundur dengan SATA II 3Gb/s)
• Controller: High Quality Controller
• Kecepatan Baca (Read): Up to 550 MB/s
• Kecepatan Tulis (Write): Up to 477 - 520 MB/s
• Dimensi: 100 x 70 x 7 mm
• Garansi: 3 Tahun Garansi Resmi V-GeN (One to One Replacement di Service Center V-GeN Seluruh Indonesia)

Cocok untuk upgrade laptop lama, PC desktop, maupun dijadikan external storage dengan enclosure 2.5.',
      'cost_price' => 9288000,
      'price' => 12074000,
      'warranty' => '3 Tahun Garansi Resmi V-GeN',
      'dimensions' => '100 x 70 x 7 mm',
      'is_active' => true,
      'is_featured' => false,
    ),
    'specs' => 
    array (
    ),
    'stock' => 2,
    'min_stock' => 1,
    'images' => 
    array (
      0 => 
      array (
        'path' => 'products/vgen-ssd-sata-3.jpg',
        'is_primary' => true,
        'sort_order' => 0,
      ),
    ),
  ),
  25 => 
  array (
    'attributes' => 
    array (
      'sku' => 'SSD-VGEN-HYPER-128GB',
      'name' => 'V-GeN HYPER SSD M.2 NVMe 128 GB',
      'slug' => 'v-gen-hyper-ssd-m2-nvme-128gb',
      'category_id' => 5,
      'brand_id' => 14,
      'variant_group' => 'vgen-hyper-nvme',
      'variant_label' => '128GB',
      'variant_type' => 'Kapasitas',
      'description' => 'Spesifikasi V-GeN HYPER SSD M.2 NVMe PCIe Gen 3.0 x4:

• Brand: V-GeN
• Series: HYPER Series
• Form Factor: M.2 2280 (NGFF)
• Interface: PCIe Gen 3.0 x4, NVMe 1.3
• Kecepatan Baca (Read): Up to 3.500 MB/s
• Kecepatan Tulis (Write): Up to 2.500 MB/s
• Controller: High Performance NVMe Controller
• Fitur: TRIM Support, Auto Garbage Collection, S.M.A.R.T, Low Power Management
• Dimensi: 80.15 x 22.15 x 2.38 mm
• Garansi: 5 Tahun Garansi Resmi V-GeN (One to One Replacement di Service Center V-GeN Seluruh Indonesia)

Cocok untuk laptop gaming, PC desktop motherboard modern dengan slot M.2 NVMe, rendering video, dan multitasking berat.',
      'cost_price' => 550000,
      'price' => 715000,
      'warranty' => '5 Tahun Garansi Resmi V-GeN',
      'dimensions' => '80 x 22 x 2.4 mm',
      'is_active' => true,
      'is_featured' => true,
    ),
    'specs' => 
    array (
    ),
    'stock' => 5,
    'min_stock' => 2,
    'images' => 
    array (
      0 => 
      array (
        'path' => 'products/vgen-hyper-nvme.jpg',
        'is_primary' => true,
        'sort_order' => 0,
      ),
    ),
  ),
  26 => 
  array (
    'attributes' => 
    array (
      'sku' => 'SSD-VGEN-HYPER-256GB',
      'name' => 'V-GeN HYPER SSD M.2 NVMe 256 GB',
      'slug' => 'v-gen-hyper-ssd-m2-nvme-256gb',
      'category_id' => 5,
      'brand_id' => 14,
      'variant_group' => 'vgen-hyper-nvme',
      'variant_label' => '256GB',
      'variant_type' => 'Kapasitas',
      'description' => 'Spesifikasi V-GeN HYPER SSD M.2 NVMe PCIe Gen 3.0 x4:

• Brand: V-GeN
• Series: HYPER Series
• Form Factor: M.2 2280 (NGFF)
• Interface: PCIe Gen 3.0 x4, NVMe 1.3
• Kecepatan Baca (Read): Up to 3.500 MB/s
• Kecepatan Tulis (Write): Up to 2.500 MB/s
• Controller: High Performance NVMe Controller
• Fitur: TRIM Support, Auto Garbage Collection, S.M.A.R.T, Low Power Management
• Dimensi: 80.15 x 22.15 x 2.38 mm
• Garansi: 5 Tahun Garansi Resmi V-GeN (One to One Replacement di Service Center V-GeN Seluruh Indonesia)

Cocok untuk laptop gaming, PC desktop motherboard modern dengan slot M.2 NVMe, rendering video, dan multitasking berat.',
      'cost_price' => 950000,
      'price' => 1235000,
      'warranty' => '5 Tahun Garansi Resmi V-GeN',
      'dimensions' => '80 x 22 x 2.4 mm',
      'is_active' => true,
      'is_featured' => false,
    ),
    'specs' => 
    array (
    ),
    'stock' => 5,
    'min_stock' => 2,
    'images' => 
    array (
      0 => 
      array (
        'path' => 'products/vgen-hyper-nvme.jpg',
        'is_primary' => true,
        'sort_order' => 0,
      ),
    ),
  ),
  27 => 
  array (
    'attributes' => 
    array (
      'sku' => 'SSD-VGEN-HYPER-512GB',
      'name' => 'V-GeN HYPER SSD M.2 NVMe 512 GB',
      'slug' => 'v-gen-hyper-ssd-m2-nvme-512gb',
      'category_id' => 5,
      'brand_id' => 14,
      'variant_group' => 'vgen-hyper-nvme',
      'variant_label' => '512GB',
      'variant_type' => 'Kapasitas',
      'description' => 'Spesifikasi V-GeN HYPER SSD M.2 NVMe PCIe Gen 3.0 x4:

• Brand: V-GeN
• Series: HYPER Series
• Form Factor: M.2 2280 (NGFF)
• Interface: PCIe Gen 3.0 x4, NVMe 1.3
• Kecepatan Baca (Read): Up to 3.500 MB/s
• Kecepatan Tulis (Write): Up to 2.500 MB/s
• Controller: High Performance NVMe Controller
• Fitur: TRIM Support, Auto Garbage Collection, S.M.A.R.T, Low Power Management
• Dimensi: 80.15 x 22.15 x 2.38 mm
• Garansi: 5 Tahun Garansi Resmi V-GeN (One to One Replacement di Service Center V-GeN Seluruh Indonesia)

Cocok untuk laptop gaming, PC desktop motherboard modern dengan slot M.2 NVMe, rendering video, dan multitasking berat.',
      'cost_price' => 1650000,
      'price' => 2145000,
      'warranty' => '5 Tahun Garansi Resmi V-GeN',
      'dimensions' => '80 x 22 x 2.4 mm',
      'is_active' => true,
      'is_featured' => false,
    ),
    'specs' => 
    array (
    ),
    'stock' => 5,
    'min_stock' => 2,
    'images' => 
    array (
      0 => 
      array (
        'path' => 'products/vgen-hyper-nvme.jpg',
        'is_primary' => true,
        'sort_order' => 0,
      ),
    ),
  ),
  28 => 
  array (
    'attributes' => 
    array (
      'sku' => 'SSD-VGEN-HYPER-1TB',
      'name' => 'V-GeN HYPER SSD M.2 NVMe 1 TB',
      'slug' => 'v-gen-hyper-ssd-m2-nvme-1tb',
      'category_id' => 5,
      'brand_id' => 14,
      'variant_group' => 'vgen-hyper-nvme',
      'variant_label' => '1TB',
      'variant_type' => 'Kapasitas',
      'description' => 'Spesifikasi V-GeN HYPER SSD M.2 NVMe PCIe Gen 3.0 x4:

• Brand: V-GeN
• Series: HYPER Series
• Form Factor: M.2 2280 (NGFF)
• Interface: PCIe Gen 3.0 x4, NVMe 1.3
• Kecepatan Baca (Read): Up to 3.500 MB/s
• Kecepatan Tulis (Write): Up to 2.500 MB/s
• Controller: High Performance NVMe Controller
• Fitur: TRIM Support, Auto Garbage Collection, S.M.A.R.T, Low Power Management
• Dimensi: 80.15 x 22.15 x 2.38 mm
• Garansi: 5 Tahun Garansi Resmi V-GeN (One to One Replacement di Service Center V-GeN Seluruh Indonesia)

Cocok untuk laptop gaming, PC desktop motherboard modern dengan slot M.2 NVMe, rendering video, dan multitasking berat.',
      'cost_price' => 3250000,
      'price' => 4225000,
      'warranty' => '5 Tahun Garansi Resmi V-GeN',
      'dimensions' => '80 x 22 x 2.4 mm',
      'is_active' => true,
      'is_featured' => false,
    ),
    'specs' => 
    array (
    ),
    'stock' => 3,
    'min_stock' => 2,
    'images' => 
    array (
      0 => 
      array (
        'path' => 'products/vgen-hyper-nvme.jpg',
        'is_primary' => true,
        'sort_order' => 0,
      ),
    ),
  ),
  29 => 
  array (
    'attributes' => 
    array (
      'sku' => 'CPU-INT-I3-6100-TRAY',
      'name' => 'Intel Core i3-6100 Tray',
      'slug' => 'intel-core-i3-6100-tray',
      'category_id' => 1,
      'brand_id' => 2,
      'variant_group' => NULL,
      'variant_label' => NULL,
      'variant_type' => 'Kapasitas',
      'description' => 'Processor Intel Core i3-6100 Skylake (Tray)

Spesifikasi Produk:
• Brand: Intel
• Model: Core i3-6100 (Generasi ke-6 / Skylake)
• Kondisi: Tray (OEM Unit)
• Socket: LGA 1151
• Jumlah Core: 2 Cores
• Jumlah Threads: 4 Threads
• Base Frequency: 3.70 GHz
• Intel Smart Cache: 3 MB
• TDP: 51 Watt
• Integrated Graphics: Intel HD Graphics 530
• Garansi: 1 Bulan Garansi Toko (Tukar Unit)

Kompatibilitas Motherboard:
- Chipset Intel Seri 100 & 200 (H110, B150, B250, H170, Z170, Z270)
- Support Memory DDR4 / DDR3L',
      'cost_price' => 205000,
      'price' => 267000,
      'warranty' => '1 Bulan Garansi Toko',
      'dimensions' => NULL,
      'is_active' => true,
      'is_featured' => true,
    ),
    'specs' => 
    array (
    ),
    'stock' => 5,
    'min_stock' => 1,
    'images' => 
    array (
      0 => 
      array (
        'path' => 'products/intel-core-i3-6100-tray.jpg',
        'is_primary' => true,
        'sort_order' => 0,
      ),
    ),
  ),
  30 => 
  array (
    'attributes' => 
    array (
      'sku' => 'CPU-INT-I5-6500-TRAY',
      'name' => 'Intel Core i5-6500 Tray',
      'slug' => 'intel-core-i5-6500-tray',
      'category_id' => 1,
      'brand_id' => 2,
      'variant_group' => NULL,
      'variant_label' => NULL,
      'variant_type' => 'Kapasitas',
      'description' => 'Processor Intel Core i5-6500 Skylake (Tray)

Spesifikasi Produk:
• Brand: Intel
• Model: Core i5-6500 (Generasi ke-6 / Skylake)
• Kondisi: Tray (OEM Unit)
• Socket: LGA 1151
• Jumlah Core: 4 Cores
• Jumlah Threads: 4 Threads
• Base Frequency: 3.20 GHz
• Max Turbo Frequency: 3.60 GHz
• Intel Smart Cache: 6 MB
• TDP: 65 Watt
• Integrated Graphics: Intel HD Graphics 530
• Garansi: 1 Bulan Garansi Toko (Tukar Unit)

Kompatibilitas Motherboard:
- Chipset Intel Seri 100 & 200 (H110, B150, B250, H170, Z170, Z270)
- Support Memory DDR4 / DDR3L',
      'cost_price' => 510000,
      'price' => 663000,
      'warranty' => '1 Bulan Garansi Toko',
      'dimensions' => NULL,
      'is_active' => true,
      'is_featured' => true,
    ),
    'specs' => 
    array (
    ),
    'stock' => 5,
    'min_stock' => 1,
    'images' => 
    array (
      0 => 
      array (
        'path' => 'products/01M7MGWA7CKJ46W7K4KGY1G4JJ.png',
        'is_primary' => true,
        'sort_order' => 0,
      ),
    ),
  ),
  31 => 
  array (
    'attributes' => 
    array (
      'sku' => 'CPU-INT-I7-6700-TRAY',
      'name' => 'Intel Core i7-6700 Tray',
      'slug' => 'intel-core-i7-6700-tray',
      'category_id' => 1,
      'brand_id' => 2,
      'variant_group' => NULL,
      'variant_label' => NULL,
      'variant_type' => 'Kapasitas',
      'description' => 'Processor Intel Core i7-6700 Skylake (Tray)

Spesifikasi Produk:
• Brand: Intel
• Model: Core i7-6700 (Generasi ke-6 / Skylake)
• Kondisi: Tray (OEM Unit)
• Socket: LGA 1151
• Jumlah Core: 4 Cores
• Jumlah Threads: 8 Threads (Hyper-Threading)
• Base Frequency: 3.40 GHz
• Max Turbo Frequency: 4.00 GHz
• Intel Smart Cache: 8 MB
• TDP: 65 Watt
• Integrated Graphics: Intel HD Graphics 530
• Garansi: 1 Bulan Garansi Toko (Tukar Unit)

Kompatibilitas Motherboard:
- Chipset Intel Seri 100 & 200 (H110, B150, B250, H170, Z170, Z270)
- Support Memory DDR4 / DDR3L',
      'cost_price' => 950000,
      'price' => 1235000,
      'warranty' => '1 Bulan Garansi Toko',
      'dimensions' => NULL,
      'is_active' => true,
      'is_featured' => true,
    ),
    'specs' => 
    array (
    ),
    'stock' => 5,
    'min_stock' => 1,
    'images' => 
    array (
      0 => 
      array (
        'path' => 'products/01M7MH33QTTVBGG49Z4SDWJYMM.jfif',
        'is_primary' => true,
        'sort_order' => 0,
      ),
    ),
  ),
  32 => 
  array (
    'attributes' => 
    array (
      'sku' => 'CPU-INT-I3-7100-TRAY',
      'name' => 'Intel Core i3-7100 Tray',
      'slug' => 'intel-core-i3-7100-tray',
      'category_id' => 1,
      'brand_id' => 2,
      'variant_group' => NULL,
      'variant_label' => NULL,
      'variant_type' => 'Kapasitas',
      'description' => 'Processor Intel Core i3-7100 Kaby Lake (Tray)

Spesifikasi Produk:
• Brand: Intel
• Model: Core i3-7100 (Generasi ke-7 / Kaby Lake)
• Kondisi: Tray (OEM Unit)
• Socket: LGA 1151
• Jumlah Core: 2 Cores
• Jumlah Threads: 4 Threads
• Base Frequency: 3.90 GHz
• Intel Smart Cache: 3 MB
• TDP: 51 Watt
• Integrated Graphics: Intel HD Graphics 630
• Garansi: 1 Bulan Garansi Toko (Tukar Unit)

Kompatibilitas Motherboard:
- Chipset Intel Seri 100 & 200 (H110, B150, B250, H270, Z270)
- Support Memory DDR4 / DDR3L',
      'cost_price' => 240000,
      'price' => 312000,
      'warranty' => '1 Bulan Garansi Toko',
      'dimensions' => NULL,
      'is_active' => true,
      'is_featured' => true,
    ),
    'specs' => 
    array (
    ),
    'stock' => 5,
    'min_stock' => 1,
    'images' => 
    array (
      0 => 
      array (
        'path' => 'products/intel-core-i3-7100-tray.jpg',
        'is_primary' => true,
        'sort_order' => 0,
      ),
    ),
  ),
  33 => 
  array (
    'attributes' => 
    array (
      'sku' => 'CPU-INT-I5-7500-TRAY',
      'name' => 'Intel Core i5-7500 Tray',
      'slug' => 'intel-core-i5-7500-tray',
      'category_id' => 1,
      'brand_id' => 2,
      'variant_group' => NULL,
      'variant_label' => NULL,
      'variant_type' => 'Kapasitas',
      'description' => 'Processor Intel Core i5-7500 Kaby Lake (Tray)

Spesifikasi Produk:
• Brand: Intel
• Model: Core i5-7500 (Generasi ke-7 / Kaby Lake)
• Kondisi: Tray (OEM Unit)
• Socket: LGA 1151
• Jumlah Core: 4 Cores
• Jumlah Threads: 4 Threads
• Base Frequency: 3.40 GHz
• Max Turbo Frequency: 3.80 GHz
• Intel Smart Cache: 6 MB
• TDP: 65 Watt
• Integrated Graphics: Intel HD Graphics 630
• Garansi: 1 Bulan Garansi Toko (Tukar Unit)

Kompatibilitas Motherboard:
- Chipset Intel Seri 100 & 200 (H110, B150, B250, H270, Z270)
- Support Memory DDR4 / DDR3L',
      'cost_price' => 625000,
      'price' => 813000,
      'warranty' => '1 Bulan Garansi Toko',
      'dimensions' => NULL,
      'is_active' => true,
      'is_featured' => true,
    ),
    'specs' => 
    array (
    ),
    'stock' => 5,
    'min_stock' => 1,
    'images' => 
    array (
      0 => 
      array (
        'path' => 'products/01M7MH171XX3SDGWDE5N9N1GHA.jpg',
        'is_primary' => true,
        'sort_order' => 0,
      ),
    ),
  ),
  34 => 
  array (
    'attributes' => 
    array (
      'sku' => 'CPU-INT-I7-14700F',
      'name' => 'Intel Core i7-14700F (20 Core, 28 Thread)',
      'slug' => 'intel-core-i7-14700f',
      'category_id' => 1,
      'brand_id' => 2,
      'variant_group' => NULL,
      'variant_label' => NULL,
      'variant_type' => 'Kapasitas',
      'description' => 'Intel Core i7-14700F Gen 14 Raptor Lake Refresh, 20 Core (8 P-Core + 12 E-Core), 28 Thread, Up to 5.4GHz, 33MB Intel Smart Cache, Socket LGA1700. Performa monster untuk gaming berat dan content creation profesional.',
      'cost_price' => 5350000,
      'price' => 6955000,
      'warranty' => 'Garansi Resmi Distributor 3 Tahun',
      'is_active' => true,
    ),
    'stock' => 5,
    'min_stock' => 1,
    'specs' => 
    array (
      0 => array ('key' => 'Socket', 'value' => 'LGA 1700'),
      1 => array ('key' => 'Jumlah Core / Thread', 'value' => '20 Core / 28 Thread (8 P-Core + 12 E-Core)'),
      2 => array ('key' => 'Base Clock / Boost Clock', 'value' => '2.1 GHz / 5.4 GHz Max Turbo'),
      3 => array ('key' => 'Cache', 'value' => '33 MB Intel Smart Cache + 28 MB L2 Cache'),
      4 => array ('key' => 'TDP / Max Power', 'value' => '65W Base / 219W Turbo'),
      5 => array ('key' => 'Memory Support', 'value' => 'DDR4 up to 3200MHz / DDR5 up to 5600MHz'),
    ),
    'images' => 
    array (
      0 => array ('path' => 'products/intel-core-i7-14700f.png', 'is_primary' => true, 'sort_order' => 0),
    ),
  ),
  35 => 
  array (
    'attributes' => 
    array (
      'sku' => 'MB-GIGA-B760M-DS3H',
      'name' => 'Gigabyte B760M DS3H DDR4',
      'slug' => 'gigabyte-b760m-ds3h-ddr4',
      'category_id' => 2,
      'brand_id' => 5,
      'variant_group' => NULL,
      'variant_label' => NULL,
      'variant_type' => 'Kapasitas',
      'description' => 'Motherboard Gigabyte B760M DS3H DDR4 mendukung prosesor Intel Gen 12, 13, dan 14. Dilengkapi 4 slot RAM DDR4 hingga 128GB, dual PCIe 4.0 x4 M.2 dengan thermal guard, serta Realtek 2.5GbE LAN untuk koneksi super cepat.',
      'cost_price' => 2180000,
      'price' => 2834000,
      'warranty' => 'Garansi Resmi Gigabyte Indonesia 3 Tahun',
      'is_active' => true,
    ),
    'stock' => 4,
    'min_stock' => 1,
    'specs' => 
    array (
      0 => array ('key' => 'Chipset', 'value' => 'Intel B760 Express Chipset'),
      1 => array ('key' => 'Socket', 'value' => 'LGA 1700 (Support Gen 12 / 13 / 14)'),
      2 => array ('key' => 'Slot Memory', 'value' => '4x DDR4 DIMM up to 128GB (5333 O.C.)'),
      3 => array ('key' => 'Storage Interface', 'value' => '2x M.2 PCIe 4.0 x4 NVMe + 4x SATA 6Gb/s'),
      4 => array ('key' => 'Form Factor', 'value' => 'Micro ATX (24.4cm x 24.4cm)'),
      5 => array ('key' => 'LAN', 'value' => 'Realtek 2.5GbE LAN chip'),
    ),
    'images' => 
    array (
      0 => array ('path' => 'products/gigabyte-b760m-ds3h-ddr4.png', 'is_primary' => true, 'sort_order' => 0),
    ),
  ),
  36 => 
  array (
    'attributes' => 
    array (
      'sku' => 'RAM-TF-DELTA-64GB-3200',
      'name' => 'Team T-Force Delta RGB 64GB (2x32GB) DDR4 3200MHz',
      'slug' => 'team-t-force-delta-rgb-64gb-2x32gb-ddr4-3200',
      'category_id' => 4,
      'brand_id' => 15,
      'variant_group' => NULL,
      'variant_label' => '64GB (2x32GB)',
      'variant_type' => 'Kapasitas',
      'description' => 'TeamGroup T-Force Delta RGB DDR4 64GB Kit (2x32GB) 3200MHz CL16. Desain heat spreader geometris aluminium dengan pencahayaan full frame 120° ultra wide angle RGB, support XMP 2.0 untuk performa multitasking dan rendering maksimal.',
      'cost_price' => 2950000,
      'price' => 3835000,
      'warranty' => 'Garansi Resmi Lifetime Warranty (Seumur Hidup)',
      'is_active' => true,
    ),
    'stock' => 6,
    'min_stock' => 1,
    'specs' => 
    array (
      0 => array ('key' => 'Kapasitas', 'value' => '64GB Kit (2x 32GB Dual Channel)'),
      1 => array ('key' => 'Frekuensi / Speed', 'value' => 'DDR4 3200MHz (PC4-25600)'),
      2 => array ('key' => 'Latency', 'value' => 'CL16-20-20-40'),
      3 => array ('key' => 'Tegangan / Voltage', 'value' => '1.35V'),
      4 => array ('key' => 'Pencahayaan', 'value' => 'Full Frame 120° Ultra-Wide Angle RGB (Sync Support)'),
      5 => array ('key' => 'Fitur', 'value' => 'Intel XMP 2.0 One-Click Overclocking'),
    ),
    'images' => 
    array (
      0 => array ('path' => 'products/team-t-force-delta-rgb-64gb.jpg', 'is_primary' => true, 'sort_order' => 0),
    ),
  ),
  37 => 
  array (
    'attributes' => 
    array (
      'sku' => 'SSD-APAC-AS2280P4-512GB',
      'name' => 'Apacer AS2280P4 M.2 NVMe PCIe Gen3x4 SSD 512GB',
      'slug' => 'apacer-as2280p4-m2-nvme-512gb',
      'category_id' => 5,
      'brand_id' => 16,
      'variant_group' => NULL,
      'variant_label' => '512 GB',
      'variant_type' => 'Kapasitas',
      'description' => 'SSD Apacer AS2280P4 M.2 PCIe Gen3 x4 NVMe 1.3 512GB menghadirkan kecepatan ultra tinggi hingga Read 2100MB/s dan Write 1500MB/s. Dilengkapi teknologi 3D NAND Flash serta proteksi data End-to-End untuk kestabilan sistem maksimal.',
      'cost_price' => 610000,
      'price' => 793000,
      'warranty' => 'Garansi Resmi Apacer 3 Tahun',
      'is_active' => true,
    ),
    'stock' => 10,
    'min_stock' => 2,
    'specs' => 
    array (
      0 => array ('key' => 'Kapasitas', 'value' => '512 GB'),
      1 => array ('key' => 'Form Factor', 'value' => 'M.2 2280'),
      2 => array ('key' => 'Interface', 'value' => 'PCIe Gen3 x4 NVMe 1.3'),
      3 => array ('key' => 'Sequential Read', 'value' => 'Hingga 2.100 MB/s'),
      4 => array ('key' => 'Sequential Write', 'value' => 'Hingga 1.500 MB/s'),
      5 => array ('key' => 'NAND Flash Type', 'value' => '3D NAND Flash TLC'),
    ),
    'images' => 
    array (
      0 => array ('path' => 'products/apacer-as2280p4-512gb.jpg', 'is_primary' => true, 'sort_order' => 0),
    ),
  ),
  38 => 
  array (
    'attributes' => 
    array (
      'sku' => 'HDD-WDC-BLUE-8TB',
      'name' => 'Western Digital Blue 8TB SATA 3.5" HDD (WD80EAZZ)',
      'slug' => 'wdc-blue-8tb-sata-3-5-inch-wd80eazz',
      'category_id' => 6,
      'brand_id' => 17,
      'variant_group' => NULL,
      'variant_label' => '8 TB',
      'variant_type' => 'Kapasitas',
      'description' => 'Hard Disk Internal WD Blue 8TB 3.5 inch SATA 6 Gb/s (WD80EAZZ) dengan teknologi CMR (Conventional Magnetic Recording) andal, cache 128MB, dan kecepatan 5640 RPM. Pilihan sempurna untuk arsip data besar, game library, dan backup sistem.',
      'cost_price' => 2650000,
      'price' => 3445000,
      'warranty' => 'Garansi Resmi Western Digital Indonesia 2 Tahun',
      'is_active' => true,
    ),
    'stock' => 3,
    'min_stock' => 1,
    'specs' => 
    array (
      0 => array ('key' => 'Kapasitas', 'value' => '8 TB (8.000 GB)'),
      1 => array ('key' => 'Form Factor', 'value' => '3.5 Inch'),
      2 => array ('key' => 'Interface', 'value' => 'SATA 6.0 Gb/s'),
      3 => array ('key' => 'Kecepatan Putaran', 'value' => '5640 RPM'),
      4 => array ('key' => 'Cache Buffer', 'value' => '128 MB'),
      5 => array ('key' => 'Recording Technology', 'value' => 'CMR (Conventional Magnetic Recording)'),
    ),
    'images' => 
    array (
      0 => array ('path' => 'products/wd-blue-8tb-desktop.png', 'is_primary' => true, 'sort_order' => 0),
    ),
  ),
  39 => 
  array (
    'attributes' => 
    array (
      'sku' => 'VGA-COL-RTX-5070-12GB',
      'name' => 'Colorful GeForce RTX 5070 Gaming 12GB GDDR7',
      'slug' => 'colorful-geforce-rtx-5070-gaming-12gb',
      'category_id' => 3,
      'brand_id' => 18,
      'variant_group' => NULL,
      'variant_label' => '12 GB',
      'variant_type' => 'Kapasitas',
      'description' => 'Colorful GeForce RTX 5070 Gaming 12GB GDDR7 dengan arsitektur generasi terbaru NVIDIA Blackwell. Menghadirkan efisiensi daya luar biasa, Ray Tracing generasi baru, DLSS 4 AI rendering, dan pendingin triple fan kokoh untuk gaming 1440p & 4K maksimal.',
      'cost_price' => 17900000,
      'price' => 23270000,
      'warranty' => 'Garansi Resmi Distributor 3 Tahun',
      'is_active' => true,
    ),
    'stock' => 2,
    'min_stock' => 1,
    'specs' => 
    array (
      0 => array ('key' => 'GPU Engine', 'value' => 'NVIDIA GeForce RTX 5070 (Blackwell Architecture)'),
      1 => array ('key' => 'Memory', 'value' => '12 GB GDDR7, 192-bit'),
      2 => array ('key' => 'Sistem Pendingin', 'value' => 'Triple Fan Air Cooling + Metal Backplate'),
      3 => array ('key' => 'Output Display', 'value' => '3x DisplayPort 2.1, 1x HDMI 2.1b'),
      4 => array ('key' => 'Rekomendasi PSU', 'value' => 'Minimum 750W - 850W Gold'),
      5 => array ('key' => 'Fitur AI', 'value' => '4th Gen RT Cores, 5th Gen Tensor Cores, DLSS 4'),
    ),
    'images' => 
    array (
      0 => array ('path' => 'products/colorful-geforce-rtx-5070-gaming.jpg', 'is_primary' => true, 'sort_order' => 0),
    ),
  ),
  40 => 
  array (
    'attributes' => 
    array (
      'sku' => 'CS-OCY-GAMMA-C50-BK',
      'name' => 'Ocypus Gamma C50 Black Micro-ATX Case (+ 4 Fan)',
      'slug' => 'ocypus-gamma-c50-black-casing',
      'category_id' => 8,
      'brand_id' => 19,
      'variant_group' => NULL,
      'variant_label' => 'Black',
      'variant_type' => 'Warna',
      'description' => 'Casing PC Gaming Ocypus Gamma C50 Black Micro-ATX dengan panel depan mesh high-airflow dan side panel tempered glass tebal. Sudah include 4 unit kipas pendingin (3 front + 1 rear) dengan sirkulasi udara optimal.',
      'cost_price' => 395000,
      'price' => 514000,
      'warranty' => 'Garansi Toko / Pabrik 1 Tahun',
      'is_active' => true,
    ),
    'stock' => 5,
    'min_stock' => 1,
    'specs' => 
    array (
      0 => array ('key' => 'Form Factor', 'value' => 'Micro-ATX, Mini-ITX'),
      1 => array ('key' => 'Bahan', 'value' => 'SPCC Steel Chassis + Tempered Glass Side'),
      2 => array ('key' => 'Kipas Bawaan', 'value' => '4x 120mm Fans Included (3 Depan, 1 Belakang)'),
      3 => array ('key' => 'Dukungan Radiator', 'value' => 'Hingga 240mm Top / Front'),
      4 => array ('key' => 'Maksimal Panjang GPU', 'value' => 'Hingga 340 mm'),
      5 => array ('key' => 'Front I/O', 'value' => '1x USB 3.0, 2x USB 2.0, HD Audio Jack'),
    ),
    'images' => 
    array (
      0 => array ('path' => 'products/ocypus-gamma-c50-black.png', 'is_primary' => true, 'sort_order' => 0),
    ),
  ),
  41 => 
  array (
    'attributes' => 
    array (
      'sku' => 'PSU-CM-MWE-850-GOLD',
      'name' => 'Cooler Master MWE Gold 850W V2 Fully Modular',
      'slug' => 'cooler-master-mwe-gold-850w-v2-full-modular',
      'category_id' => 7,
      'brand_id' => 10,
      'variant_group' => NULL,
      'variant_label' => '850 Watt',
      'variant_type' => 'Daya',
      'description' => 'Power Supply Cooler Master MWE Gold 850 V2 Full Modular dengan sertifikasi 80 PLUS Gold (efisiensi 90%). Dilengkapi kabel pipih flat-black modular rapi, kipas 120mm HDB silent, dan proteksi industri lengkap (OVP, OPP, SCP, OCP, UVP, OTP).',
      'cost_price' => 1550000,
      'price' => 2015000,
      'warranty' => 'Garansi Resmi Cooler Master Indonesia 5 Tahun',
      'is_active' => true,
    ),
    'stock' => 4,
    'min_stock' => 1,
    'specs' => 
    array (
      0 => array ('key' => 'Total Output', 'value' => '850 Watt'),
      1 => array ('key' => 'Efisiensi', 'value' => '80 PLUS Gold Certified (Typ. 90%)'),
      2 => array ('key' => 'Kabel', 'value' => 'Fully Modular Flat Black Cables'),
      3 => array ('key' => 'Ukuran Kipas', 'value' => '120mm HDB Hydro Dynamic Bearing (Silent)'),
      4 => array ('key' => 'Proteksi Listrik', 'value' => 'OVP, OPP, SCP, OCP, UVP, OTP'),
      5 => array ('key' => 'Dimensi', 'value' => '160 x 150 x 86 mm (ATX)'),
    ),
    'images' => 
    array (
      0 => array ('path' => 'products/cooler-master-mwe-850-gold-v2.png', 'is_primary' => true, 'sort_order' => 0),
    ),
  ),
  42 => 
  array (
    'attributes' => 
    array (
      'sku' => 'KB-LOGI-MK120-COMBO',
      'name' => 'Logitech MK120 USB Keyboard & Mouse Combo',
      'slug' => 'logitech-mk120-usb-keyboard-mouse-combo',
      'category_id' => 11,
      'brand_id' => 20,
      'variant_group' => NULL,
      'variant_label' => 'Black Combo',
      'variant_type' => 'Warna',
      'description' => 'Paket keyboard dan mouse kabel USB Logitech MK120 dengan durabilitas tinggi dan kenyamanan kerja seharian. Keyboard full-size tahan tumpahan cairan (spill-resistant) dan tombol low-profile hening dipadukan dengan mouse optik presisi 1000 DPI.',
      'cost_price' => 195000,
      'price' => 254000,
      'warranty' => 'Garansi Resmi Logitech Indonesia 3 Tahun',
      'is_active' => true,
    ),
    'stock' => 15,
    'min_stock' => 3,
    'specs' => 
    array (
      0 => array ('key' => 'Konektivitas', 'value' => 'Kabel USB Plug-and-Play'),
      1 => array ('key' => 'Tata Letak Keyboard', 'value' => 'Full Size dengan Numpad'),
      2 => array ('key' => 'Fitur Keyboard', 'value' => 'Spill-Resistant (Tahan Tumpahan Cairan), Tombol Hening'),
      3 => array ('key' => 'Sensor Mouse', 'value' => 'High-Definition Optical Tracking 1000 DPI'),
      4 => array ('key' => 'Desain Mouse', 'value' => 'Ambidextrous (Nyaman Tangan Kanan & Kiri)'),
      5 => array ('key' => 'Kompatibilitas', 'value' => 'Windows 11 / 10 / 8 / 7, Linux, ChromeOS'),
    ),
    'images' => 
    array (
      0 => array ('path' => 'products/logitech-mk120-combo.png', 'is_primary' => true, 'sort_order' => 0),
    ),
  ),
  43 => 
  array (
    'attributes' => 
    array (
      'sku' => 'CLR-PCC-DA240-BK',
      'name' => 'PCCooler GI-DA240 Black ARGB Dual Fan (240mm AIO Cooler)',
      'slug' => 'pccooler-gi-da240-black-argb-liquid-cooler',
      'category_id' => 9,
      'brand_id' => 21,
      'variant_group' => NULL,
      'variant_label' => '240mm Black',
      'variant_type' => 'Ukuran Radiator',
      'description' => 'AIO Liquid Cooler PCCooler GI-DA240 Black dengan radiator aluminium 240mm berdensitas sirip tinggi dan dual kipas 120mm PWM ARGB. Base plate tembaga murni ultra-presisi memastikan perpindahan panas prosesor Intel Gen 14 dan Ryzen tetap dingin maksimal.',
      'cost_price' => 575000,
      'price' => 748000,
      'warranty' => 'Garansi Resmi PC Cooler Indonesia 2 Tahun',
      'is_active' => true,
    ),
    'stock' => 5,
    'min_stock' => 1,
    'specs' => 
    array (
      0 => array ('key' => 'Ukuran Radiator', 'value' => '240 mm (277 x 120 x 27 mm Aluminium)'),
      1 => array ('key' => 'Kipas Pendingin', 'value' => '2x 120mm PWM Hydraulic Bearing (800-1800 RPM)'),
      2 => array ('key' => 'Pencahayaan', 'value' => 'Addressable RGB (ARGB 5V 3-Pin Sync)'),
      3 => array ('key' => 'Base Plate Material', 'value' => 'Pure Copper Heat Base'),
      4 => array ('key' => 'Noise Level', 'value' => 'Max 31.5 dBA Ultra Quiet'),
      5 => array ('key' => 'Socket Kompatibel', 'value' => 'Intel LGA 1700/1200/115x, AMD AM5/AM4'),
    ),
    'images' => 
    array (
      0 => array ('path' => 'products/pccooler-da240-black-argb.jpg', 'is_primary' => true, 'sort_order' => 0),
    ),
  ),
);

        foreach ($products as $item) {
            $prod = Product::query()->updateOrCreate(['slug' => $item['attributes']['slug']], $item['attributes']);
            if (!empty($item['specs'])) {
                ProductSpec::query()->where('product_id', $prod->id)->delete();
                foreach ($item['specs'] as $spec) {
                    ProductSpec::query()->create($spec + ['product_id' => $prod->id]);
                }
            }
            Inventory::query()->updateOrCreate(['product_id' => $prod->id], [
                'current_stock' => $item['stock'],
                'min_stock' => $item['min_stock'],
            ]);
            if (!empty($item['images'])) {
                ProductImage::query()->where('product_id', $prod->id)->delete();
                foreach ($item['images'] as $img) {
                    ProductImage::query()->create($img + ['product_id' => $prod->id]);
                }
            }
        }
    }
}
