<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

// Models
use App\Models\User;

// Enums
use App\Enums\RoleEnum;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin user
        User::updateOrCreate([
            'email' => config('admin.email', 'admin@example.com'),
        ], [
            'name' => config('admin.name', 'Admin'),
            'email' => config('admin.email', 'admin@example.com'),
            'password' => config('admin.password', 'Password#123'),
            'role' => RoleEnum::ADMIN,
            'email_verified_at' => now(),
        ]);
    }
}
