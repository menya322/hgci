<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@example.com')],
            [
                'name' => env('ADMIN_NAME', 'HGCI Administrator'),
                'password' => env('ADMIN_PASSWORD', 'password'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ],
        );
    }
}
