<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('SEED_ADMIN_EMAIL');
        $password = env('SEED_ADMIN_PASSWORD');

        if (App::isProduction()) {
            if (empty($email) || empty($password)) {
                $this->command->error(
                    'SEED_ADMIN_EMAIL dan SEED_ADMIN_PASSWORD harus diisi di .env sebelum seeding di production.'
                );

                return;
            }
        } else {
            $email = $email ?: 'admin@example.com';
            $password = $password ?: 'password';
        }

        User::firstOrCreate(
            ['email' => $email],
            [
                'name' => 'Admin',
                'email_verified_at' => now(),
                'status' => 'active',
                'password' => Hash::make($password),
                'role' => 'admin',
            ]
        );
    }
}
