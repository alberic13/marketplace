<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Game;
use App\Models\Category;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Listing::query()
            ->where('status', 'active')
            ->with(['game.category', 'user']);

        // Filter by type (sell/buy)
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // Filter by condition
        if ($request->has('condition')) {
            $query->where('condition', $request->condition);
        }

        // Filter by price range
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Search by title
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $listings = $query->latest()->paginate(12);
        $categories = Category::where('is_active', true)->get();

        return view('listings.index', [
            'listings' => $listings,
            'categories' => $categories,
            'filters' => $request->only(['type', 'condition', 'min_price', 'max_price', 'search'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $games = Game::where('is_active', true)->with('category')->get();
        
        return view('listings.create', [
            'games' => $games
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'game_id' => 'required|exists:games,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'type' => 'required|in:sell,buy',
            'condition' => 'required|in:new,like_new,good,fair,digital',
            'game_key' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        $listing = Listing::create([
            ...$validated,
            'user_id' => auth()->id(),
            'status' => 'active'
        ]);

        return redirect()->route('listings.show', $listing)
            ->with('success', 'Listing created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        $listing->load(['game.category', 'user']);
        $listing->increment('views');

        // Get related listings from the same game
        $relatedListings = Listing::where('game_id', $listing->game_id)
            ->where('id', '!=', $listing->id)
            ->where('status', 'active')
            ->with('user')
            ->take(4)
            ->get();

        return view('listings.show', [
            'listing' => $listing,
            'relatedListings' => $relatedListings
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        $games = Game::where('is_active', true)->with('category')->get();
        
        return view('listings.edit', [
            'listing' => $listing,
            'games' => $games
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Listing $listing)
    {
        $validated = $request->validate([
            'game_id' => 'required|exists:games,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'type' => 'required|in:sell,buy',
            'condition' => 'required|in:new,like_new,good,fair,digital',
            'status' => 'required|in:active,sold,inactive',
            'game_key' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        $listing->update($validated);

        return redirect()->route('listings.show', $listing)
            ->with('success', 'Listing updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        $listing->delete();

        return redirect()->route('my-listings.index')
            ->with('success', 'Listing deleted successfully!');
    }

    /**
     * Display user's own listings.
     */
    public function myListings()
    {
        $listings = Listing::where('user_id', auth()->id())
            ->with(['game.category'])
            ->latest()
            ->paginate(10);

        return view('listings.my-listings', [
            'listings' => $listings
        ]);
    }
}
