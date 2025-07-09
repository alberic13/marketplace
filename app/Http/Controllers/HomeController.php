<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Game;
use App\Models\Listing;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)->take(8)->get();
        $featuredGames = Game::where('is_active', true)
            ->with('category')
            ->take(6)
            ->get();
        $recentListings = Listing::where('status', 'active')
            ->with(['game.category', 'user'])
            ->latest()
            ->take(8)
            ->get();

        return view('home', [
            'categories' => $categories,
            'featuredGames' => $featuredGames,
            'recentListings' => $recentListings
        ]);
    }
}
