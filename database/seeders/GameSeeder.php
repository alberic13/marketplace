<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $games = [
            [
                'category_id' => 1, // Action
                'title' => 'Cyberpunk 2077',
                'description' => 'An open-world, action-adventure story set in Night City.',
                'developer' => 'CD Projekt RED',
                'publisher' => 'CD Projekt',
                'release_date' => '2020-12-10',
                'platform' => 'Multiple',
                'genre' => 'Action RPG',
                'base_price' => 59.99,
            ],
            [
                'category_id' => 3, // RPG
                'title' => 'The Witcher 3: Wild Hunt',
                'description' => 'A story-driven open world RPG set in a visually stunning fantasy universe.',
                'developer' => 'CD Projekt RED',
                'publisher' => 'CD Projekt',
                'release_date' => '2015-05-19',
                'platform' => 'Multiple',
                'genre' => 'Action RPG',
                'base_price' => 39.99,
            ],
            [
                'category_id' => 7, // Shooter
                'title' => 'Call of Duty: Modern Warfare',
                'description' => 'The stakes have never been higher as players take on the role of lethal Tier One operators.',
                'developer' => 'Infinity Ward',
                'publisher' => 'Activision',
                'release_date' => '2019-10-25',
                'platform' => 'Multiple',
                'genre' => 'First-Person Shooter',
                'base_price' => 59.99,
            ],
            [
                'category_id' => 4, // Strategy
                'title' => 'Age of Empires IV',
                'description' => 'Real-time strategy game featuring both familiar and innovative new ways to expand your empire.',
                'developer' => 'Relic Entertainment',
                'publisher' => 'Xbox Game Studios',
                'release_date' => '2021-10-28',
                'platform' => 'PC',
                'genre' => 'Real-Time Strategy',
                'base_price' => 59.99,
            ],
            [
                'category_id' => 5, // Sports
                'title' => 'FIFA 24',
                'description' => 'The world\'s game featuring HyperMotionV technology for authentic football experience.',
                'developer' => 'EA Sports',
                'publisher' => 'Electronic Arts',
                'release_date' => '2023-09-29',
                'platform' => 'Multiple',
                'genre' => 'Sports Simulation',
                'base_price' => 69.99,
            ],
            [
                'category_id' => 12, // Indie
                'title' => 'Hollow Knight',
                'description' => 'A challenging 2D action-adventure through a vast ruined kingdom of insects and heroes.',
                'developer' => 'Team Cherry',
                'publisher' => 'Team Cherry',
                'release_date' => '2017-02-24',
                'platform' => 'Multiple',
                'genre' => 'Metroidvania',
                'base_price' => 14.99,
            ],
        ];

        foreach ($games as $game) {
            DB::table('games')->insert([
                'category_id' => $game['category_id'],
                'title' => $game['title'],
                'slug' => Str::slug($game['title']),
                'description' => $game['description'],
                'developer' => $game['developer'],
                'publisher' => $game['publisher'],
                'release_date' => $game['release_date'],
                'platform' => $game['platform'],
                'genre' => $game['genre'],
                'base_price' => $game['base_price'],
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
