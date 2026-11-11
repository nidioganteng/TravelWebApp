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

        $user = User::firstOrNew(['email' => $email]);

        if (! $user->exists) {
            $user->name = 'Admin';
            $user->email_verified_at = now();
            $user->status = 'active';
            $user->password = Hash::make($password);
            $user->role = 'admin';
            $user->save();
        }
    }
}
