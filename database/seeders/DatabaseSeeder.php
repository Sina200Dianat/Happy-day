<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create or update a single seeded user with the magic password
        User::updateOrCreate(
            ['email' => 'you@love.local'],
            [
                'name' => 'My Love',
                'password' => Hash::make('mypassion'),
            ]
        );
    }
}
