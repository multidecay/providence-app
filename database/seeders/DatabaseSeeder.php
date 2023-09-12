<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'identity' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $recovery_code = 'OwO';

        \App\Models\User::factory()->create([
            'identity' => 'UwU',
            'password' => Hash::make("UwU"),
            'recovery_code' => Hash::make($recovery_code),
        ]);

    }
}
