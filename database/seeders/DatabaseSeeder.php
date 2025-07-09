<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create users first
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Seller User',
            'email' => 'seller@example.com',
            'role' => 'seller',
        ]);

        User::factory()->create([
            'name' => 'Buyer User',
            'email' => 'buyer@example.com',
            'role' => 'buyer',
        ]);

        // Then seed other data
        $this->call([
            AdminSeeder::class,
            CategorySeeder::class,
            GameSeeder::class,
            ListingSeeder::class,
        ]);
    }
}
