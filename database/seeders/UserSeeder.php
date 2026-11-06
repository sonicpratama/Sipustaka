<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@sipustaka.test'],
            ['name' => 'Petugas Perpustakaan', 'password' => 'password123', 'role' => 'admin']
        );

        User::updateOrCreate(
            ['email' => 'user@sipustaka.test'],
            ['name' => 'Anggota Perpustakaan', 'password' => 'password123', 'role' => 'user']
        );
    }
}