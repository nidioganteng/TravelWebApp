<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\App;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // <--- WAJIB IMPORT INI

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. BUAT AKUN ADMIN (Ini yang akan kamu pakai login nanti)
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@travel.com', // Email Admin
            'status' => 'active',
            'password' => Hash::make('password'), // Password: password
            'role' => 'admin', // <--- KUNCI UTAMA: Role admin
        ]);

        // 2. User Lama (Saya perbaiki passwordnya pakai Hash biar bisa login)
        User::create([
            'name' => 'Risma',
            'email' => 'jagungbakar@gmail.com',
            'status' => 'active',
            'password' => Hash::make('rismaCantik23'), // Harus di-Hash
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Benedito',
            'email' => 'nidio.shop24@gmail.com',
            'status' => 'active',
            'password' => Hash::make('beneditoCantik24'), // Harus di-Hash
            'role' => 'user',
        ]);
    }
}
