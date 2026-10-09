<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateAdminCommand extends Command
{
    protected $signature = 'keehub:admin 
                            {email=admin@keetech.my.id : Email untuk akun admin} 
                            {password=admin123 : Password untuk akun admin} 
                            {--name=Owner KeeHub : Nama admin} 
                            {--role=owner : Role akun (owner atau staff)}';

    protected $description = 'Buat atau reset akun administrator / owner KeeHub';

    public function handle(): int
    {
        $email = (string) $this->argument('email');
        $password = (string) $this->argument('password');
        $name = (string) $this->option('name');
        $role = (string) $this->option('role');

        $user = User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => $password,
                'role' => $role,
                'phone' => '081234567890',
            ]
        );

        $this->info('Berhasil! Akun Admin KeeHub siap digunakan:');
        $this->table(
            ['Field', 'Value'],
            [
                ['Nama', $user->name],
                ['Email', $user->email],
                ['Password', $password],
                ['Role', $user->role],
                ['URL Login Admin', url('/admin/login')],
                ['URL Login Web', url('/login')],
            ]
        );

        return self::SUCCESS;
    }
}
