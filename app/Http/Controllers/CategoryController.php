<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Listing;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->withCount(['games', 'listings' => function ($query) {
                $query->where('status', 'active');
            }])
            ->paginate(12);

        return \Inertia\Inertia::render('categories/Index', [
            'categories' => $categories
        ]);
    }

    public function show(Category $category, Request $request)
    {
        // Load games count
        $category->loadCount('games');

        $tab = $request->get('tab', 'listings');

        if ($tab === 'games') {
            // Show games in this category
            $query = $category->games()->where('is_active', true);

            if ($request->has('search')) {
                $query->where('title', 'like', '%' . $request->search . '%');
            }

            if ($request->has('platform')) {
                $query->where('platform', $request->platform);
            }

            $games = $query->withCount(['listings' => function ($q) {
                $q->where('status', 'active');
            }])->get();

            return \Inertia\Inertia::render('categories/Show', [
                'category' => $category,
                'games' => $games,
                'listings' => collect(),
                'totalListings' => $category->listings()->where('status', 'active')->count()
            ]);
        } else {
            // Show listings in this category
            $query = Listing::query()
                ->whereHas('game', function ($q) use ($category) {
                    $q->where('category_id', $category->id);
                })
                ->where('status', 'active')
                ->with(['game', 'user']);

            // Apply filters
            if ($request->has('search')) {
                $query->where(function ($q) use ($request) {
                    $q->where('title', 'like', '%' . $request->search . '%')
                      ->orWhereHas('game', function ($gameQuery) use ($request) {
                          $gameQuery->where('title', 'like', '%' . $request->search . '%');
                      });
                });
            }

            if ($request->has('platform')) {
                $query->whereHas('game', function ($q) use ($request) {
                    $q->where('platform', $request->platform);
                });
            }

            // Apply sorting
            switch ($request->get('sort', 'newest')) {
                case 'oldest':
                    $query->oldest();
                    break;
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'popular':
                    $query->orderBy('views', 'desc');
                    break;
                default:
                    $query->latest();
                    break;
            }

            $listings = $query->paginate(12);
            $totalListings = $category->listings()->where('status', 'active')->count();

            return \Inertia\Inertia::render('categories/Show', [
                'category' => $category,
                'listings' => $listings,
                'totalListings' => $totalListings
            ]);
        }
    }
}
