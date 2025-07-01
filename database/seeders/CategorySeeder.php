<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Action', 'description' => 'Fast-paced games with combat and adventure'],
            ['name' => 'Adventure', 'description' => 'Story-driven games with exploration'],
            ['name' => 'RPG', 'description' => 'Role-playing games with character development'],
            ['name' => 'Strategy', 'description' => 'Games requiring tactical thinking and planning'],
            ['name' => 'Sports', 'description' => 'Sports simulation and arcade games'],
            ['name' => 'Racing', 'description' => 'Car, bike, and other vehicle racing games'],
            ['name' => 'Shooter', 'description' => 'First-person and third-person shooting games'],
            ['name' => 'Simulation', 'description' => 'Life and world simulation games'],
            ['name' => 'Puzzle', 'description' => 'Brain-teasing and logic games'],
            ['name' => 'Horror', 'description' => 'Scary and suspenseful games'],
            ['name' => 'MMORPG', 'description' => 'Massively multiplayer online role-playing games'],
            ['name' => 'Indie', 'description' => 'Independent developer games'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
