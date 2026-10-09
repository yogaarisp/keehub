<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $adminPassword = env('KEEHUB_ADMIN_PASSWORD') ?: 'admin123';
        $staffPassword = env('KEEHUB_STAFF_PASSWORD') ?: 'staff123';

        User::query()->updateOrCreate(
            ['email' => env('KEEHUB_ADMIN_EMAIL', 'admin@keetech.my.id')],
            [
                'name' => 'Owner KeeHub',
                'password' => $adminPassword,
                'role' => 'owner',
                'phone' => '081234567890',
            ]
        );

        User::query()->updateOrCreate(
            ['email' => env('KEEHUB_STAFF_EMAIL', 'staff@keetech.my.id')],
            [
                'name' => 'Staff Gudang',
                'password' => $staffPassword,
                'role' => 'staff',
                'phone' => '081234567891',
            ]
        );

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
