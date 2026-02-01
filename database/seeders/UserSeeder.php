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
        // 1. BUAT AKUN ADMIN
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@travel.com', 
            'status' => 'active',
            'password' => Hash::make('password'), 
            'role' => 'admin', 
        ]);

        // 2. User Lama 
        User::create([
            'name' => 'Risma',
            'email' => 'jagungbakar@gmail.com',
            'status' => 'active',
            'password' => Hash::make('rismaCantik23'), 
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Benedito',
            'email' => 'nidio.shop24@gmail.com',
            'status' => 'active',
            'password' => Hash::make('beneditoCantik24'), 
            'role' => 'user',
        ]);
    }
}
