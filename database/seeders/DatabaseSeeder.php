<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        // 2. Akun Siswa / User 1
        User::create([
            'name' => 'Siswa Contoh',
            'email' => 'siswa@gmail.com',
            'password' => bcrypt('siswa123'),
            'role' => 'user',
        ]);

        // 3. Akun Siswa / User 2 (Opsional jika butuh akun contoh lain)
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'user',
        ]);
    }
}