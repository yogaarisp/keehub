<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        Customer::query()->create([
            'name' => 'Budi Santoso',
            'whatsapp' => '6281234567800',
            'email' => 'budi@example.test',
        ]);

        Customer::query()->create([
            'name' => 'Siti Rahma',
            'whatsapp' => '6281234567801',
            'email' => 'siti@example.test',
        ]);
    }
}
