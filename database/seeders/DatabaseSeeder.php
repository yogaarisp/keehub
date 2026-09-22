<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->create([
            'name' => 'Owner KeeHub',
            'email' => 'admin@ketech.my.id',
            'password' => 'password',
            'role' => 'owner',
            'phone' => '081234567890',
        ]);

        User::query()->create([
            'name' => 'Staff Gudang',
            'email' => 'staff@keetech.my.id',
            'password' => 'password',
            'role' => 'staff',
            'phone' => '081234567891',
        ]);

        Setting::put('whatsapp_number', '6281234567890');
        Setting::put('instagram_url', 'https://instagram.com/keehub');
        Setting::put('tiktok_url', 'https://tiktok.com/@keehub');
        Setting::put('store_name', 'KeeHub');
        Setting::put('store_tagline', 'Build. Buy. Upgrade.');
        Setting::put('store_address', 'Jl. Teknologi No. 1, Jakarta');
        Setting::put('stock_deduct_status', 'confirmed');

        $this->call([
            CatalogSeeder::class,
            CustomerSeeder::class,
        ]);
    }
}
