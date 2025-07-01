@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Category Header -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-700 rounded-lg p-8 mb-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-bold mb-2">{{ $category->name }}</h1>
                @if($category->description)
                    <p class="text-blue-100 text-lg">{{ $category->description }}</p>
                @endif
            </div>
            <div class="text-6xl opacity-50">🎮</div>
        </div>
        
        <div class="flex items-center space-x-6 mt-6 text-blue-100">
            <div>
                <span class="text-2xl font-bold text-white">{{ $category->games->count() }}</span>
                <span class="text-sm">Games</span>
            </div>
            <div>
                <span class="text-2xl font-bold text-white">{{ $totalListings }}</span>
                <span class="text-sm">Listings</span>
            </div>
        </div>
    </div>

    <!-- Filter and Sort -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form method="GET" class="flex flex-wrap items-center gap-4">
            <div class="flex-1 min-w-64">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Search games and listings..."
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <select name="platform" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Platforms</option>
                <option value="PC" {{ request('platform') == 'PC' ? 'selected' : '' }}>PC</option>
                <option value="PlayStation" {{ request('platform') == 'PlayStation' ? 'selected' : '' }}>PlayStation</option>
                <option value="Xbox" {{ request('platform') == 'Xbox' ? 'selected' : '' }}>Xbox</option>
                <option value="Nintendo" {{ request('platform') == 'Nintendo' ? 'selected' : '' }}>Nintendo</option>
                <option value="Mobile" {{ request('platform') == 'Mobile' ? 'selected' : '' }}>Mobile</option>
            </select>
            
            <select name="sort" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
            </select>
            
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                Filter
            </button>
            
            @if(request()->hasAny(['search', 'platform', 'sort']))
                <a href="{{ route('categories.show', $category->slug) }}" class="text-gray-600 hover:text-gray-800">
                    Clear Filters
                </a>
            @endif
        </form>
    </div>

    <!-- Tabs -->
    <div class="mb-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8">
                <a href="{{ route('categories.show', $category->slug) }}" 
                   class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ !request('tab') || request('tab') == 'listings' ? 'border-blue-500 text-blue-600' : '' }}">
                    Listings ({{ $listings->total() }})
                </a>
                <a href="{{ route('categories.show', [$category->slug, 'tab' => 'games']) }}" 
                   class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm {{ request('tab') == 'games' ? 'border-blue-500 text-blue-600' : '' }}">
                    Games ({{ $category->games->count() }})
                </a>
            </nav>
        </div>
    </div>

    @if(!request('tab') || request('tab') == 'listings')
        <!-- Listings Grid -->
        @if($listings->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                @foreach($listings as $listing)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <div class="aspect-video bg-gray-200 flex items-center justify-center">
                            @if($listing->image_url)
                                <img src="{{ $listing->image_url }}" alt="{{ $listing->title }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-gray-400">No Image</span>
                            @endif
                        </div>
                        
                        <div class="p-4">
                            <div class="flex items-start justify-between mb-2">
                                <h3 class="font-medium text-gray-800 truncate flex-1">{{ $listing->title }}</h3>
                                <span class="bg-{{ $listing->type == 'sell' ? 'green' : 'blue' }}-100 text-{{ $listing->type == 'sell' ? 'green' : 'blue' }}-800 text-xs px-2 py-1 rounded-full ml-2">
                                    {{ ucfirst($listing->type) }}
                                </span>
                            </div>
                            
                            <p class="text-sm text-gray-600 mb-2">{{ $listing->game->title }}</p>
                            <p class="text-lg font-bold text-green-600 mb-3">${{ number_format($listing->price, 2) }}</p>
                            
                            <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                                <span>{{ $listing->user->name }}</span>
                                <span>{{ $listing->created_at->diffForHumans() }}</span>
                            </div>
                            
                            <a href="{{ route('listings.show', $listing) }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-2 rounded-lg">
                                View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            {{ $listings->appends(request()->except('page'))->links() }}
        @else
            <div class="text-center py-12">
                <div class="text-gray-400 text-6xl mb-4">📝</div>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">No Listings Found</h3>
                <p class="text-gray-500 mb-4">Be the first to create a listing in this category!</p>
                @auth
                    <a href="{{ route('listings.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg inline-block">
                        Create Listing
                    </a>
                @endauth
            </div>
        @endif
        
    @elseif(request('tab') == 'games')
        <!-- Games Grid -->
        @if($category->games->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
                @foreach($category->games as $game)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        <div class="aspect-video bg-gray-200 flex items-center justify-center">
                            @if($game->image_url)
                                <img src="{{ $game->image_url }}" alt="{{ $game->title }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-gray-400">No Image</span>
                            @endif
                        </div>
                        
                        <div class="p-4">
                            <h3 class="font-medium text-gray-800 mb-2 truncate">{{ $game->title }}</h3>
                            <p class="text-sm text-gray-600 mb-2">{{ $game->platform }}</p>
                            @if($game->release_date)
                                <p class="text-sm text-gray-500 mb-3">Released: {{ $game->release_date->format('Y') }}</p>
                            @endif
                            
                            <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                                <span>{{ $game->listings_count }} listings</span>
                                @if($game->developer)
                                    <span>{{ $game->developer }}</span>
                                @endif
                            </div>
                            
                            <a href="{{ route('games.show', $game) }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-2 rounded-lg">
                                View Game
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <div class="text-gray-400 text-6xl mb-4">🎮</div>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">No Games Found</h3>
                <p class="text-gray-500">No games are available in this category yet.</p>
            </div>
        @endif
    @endif
</div>
@endsection
