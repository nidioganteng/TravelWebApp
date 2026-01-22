<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\App;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create(['name' => 'Risma', 'email' => 'jagungbakar@gmail.com', 'status' => 'active', 'password' => 'rismaCantik23']);
        User::create(['name' => 'Benedito', 'email' => 'nidio.shop24@gmail.com', 'status' => 'active', 'password' => 'beneditoCantik24']);
    }
}
