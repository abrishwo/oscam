<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Ensure the test user exists and has the expected attributes for login.
        // Use updateOrCreate so the password and verification state are set reliably
        // for development/testing environments.
        User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'email_verified_at' => now(),
                // Set a known password for testing (plaintext: "secret").
                'password' => bcrypt('secret'),
                'remember_token' => Str::random(10),
            ]
        );
    }
}
