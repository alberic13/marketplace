<?php

namespace Database\Seeders;

use App\Models\Listing;
use App\Models\User;
use App\Models\Game;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ListingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $games = Game::all();

        $listings = [
            [
                'user_id' => $users->where('role', 'seller')->first()->id ?? 2,
                'game_id' => 1, // Cyberpunk 2077
                'title' => 'Cyberpunk 2077 - Like New Condition',
                'description' => 'Excellent condition copy of Cyberpunk 2077. Played once, no scratches on disc. Includes original case and manual.',
                'price' => 45.99,
                'type' => 'sell',
                'condition' => 'like_new',
                'status' => 'active',
                'notes' => 'Smoke-free home, adult owned.'
            ],
            [
                'user_id' => $users->where('role', 'seller')->first()->id ?? 2,
                'game_id' => 2, // The Witcher 3
                'title' => 'The Witcher 3: Wild Hunt - Complete Edition',
                'description' => 'Complete edition with all DLCs. Physical copy in excellent condition. One of the best RPGs ever made!',
                'price' => 29.99,
                'type' => 'sell',
                'condition' => 'good',
                'status' => 'active',
                'notes' => 'Includes Blood and Wine & Hearts of Stone DLCs'
            ],
            [
                'user_id' => $users->where('role', 'buyer')->first()->id ?? 3,
                'game_id' => 3, // Call of Duty
                'title' => 'Looking for Call of Duty: Modern Warfare',
                'description' => 'Searching for a good condition copy of Call of Duty: Modern Warfare for PS4. Willing to pay fair price.',
                'price' => 35.00,
                'type' => 'buy',
                'condition' => 'good',
                'status' => 'active',
                'notes' => 'Prefer physical copy, but open to digital codes too.'
            ],
            [
                'user_id' => $users->where('role', 'seller')->first()->id ?? 2,
                'game_id' => 4, // Age of Empires IV
                'title' => 'Age of Empires IV - Digital Key',
                'description' => 'Unused digital key for Age of Empires IV on Steam. Perfect for RTS fans!',
                'price' => 39.99,
                'type' => 'sell',
                'condition' => 'digital',
                'status' => 'active',
                'game_key' => 'XXXXX-XXXXX-XXXXX-XXXXX',
                'notes' => 'Will send key immediately after payment confirmation.'
            ],
            [
                'user_id' => $users->where('role', 'seller')->first()->id ?? 2,
                'game_id' => 6, // Hollow Knight
                'title' => 'Hollow Knight - Indie Masterpiece',
                'description' => 'Amazing indie metroidvania game. Digital copy on Nintendo eShop. Great for portable gaming!',
                'price' => 12.99,
                'type' => 'sell',
                'condition' => 'digital',
                'status' => 'active',
                'notes' => 'One of the best indie games ever made!'
            ]
        ];

        foreach ($listings as $listing) {
            Listing::create($listing);
        }
    }
}
