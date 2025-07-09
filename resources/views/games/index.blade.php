@extends('layouts.app')

@section('title', 'Games - GameMarket')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Browse Games</h1>
        <p class="text-lg text-gray-600">Discover and explore games available in our marketplace</p>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-md p-8 mb-8">
        <form method="GET" action="{{ route('games.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" name="search" id="search" 
                           value="{{ request('search') }}" 
                           placeholder="Search games..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select name="category" id="category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->slug }}" {{ request('category') === $category->slug ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Platform -->
                <div>
                    <label for="platform" class="block text-sm font-medium text-gray-700 mb-1">Platform</label>
                    <select name="platform" id="platform" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Platforms</option>
                        <option value="PC" {{ request('platform') === 'PC' ? 'selected' : '' }}>PC</option>
                        <option value="PlayStation" {{ request('platform') === 'PlayStation' ? 'selected' : '' }}>PlayStation</option>
                        <option value="Xbox" {{ request('platform') === 'Xbox' ? 'selected' : '' }}>Xbox</option>
                        <option value="Nintendo Switch" {{ request('platform') === 'Nintendo Switch' ? 'selected' : '' }}>Nintendo Switch</option>
                        <option value="Mobile" {{ request('platform') === 'Mobile' ? 'selected' : '' }}>Mobile</option>
                        <option value="Multiple" {{ request('platform') === 'Multiple' ? 'selected' : '' }}>Multiple</option>
                    </select>
                </div>

                <!-- Submit -->
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200">
                        <i class="fas fa-search mr-2"></i>Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Games Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @forelse($games as $game)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-2xl hover:-translate-y-1 transition duration-200 relative group">
                <!-- Game Image with Skeleton Loader -->
                <div class="h-48 bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center relative">
                    @if($game->cover_image)
                        <img src="{{ $game->cover_image }}" alt="{{ $game->title }}" class="w-full h-full object-cover transition-opacity duration-300 group-hover:opacity-90">
                    @else
                        <div class="animate-pulse w-full h-full flex items-center justify-center">
                            <i class="fas fa-gamepad text-6xl text-white opacity-50"></i>
                        </div>
                    @endif
                    @if($game->is_new)
                        <span class="absolute top-2 left-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full font-semibold">New</span>
                    @endif
                    @if($game->is_popular)
                        <span class="absolute top-2 right-2 bg-yellow-400 text-white text-xs px-2 py-1 rounded-full font-semibold">Popular</span>
                    @endif
                </div>
                <!-- Game Info -->
                <div class="p-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-blue-600 font-semibold">{{ $game->category->name }}</span>
                        <span class="text-sm text-gray-500">{{ $game->platform }}</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $game->title }}</h3>
                    @if($game->developer)
                        <p class="text-sm text-gray-600 mb-2">
                            <i class="fas fa-user-cog mr-1"></i>{{ $game->developer }}
                        </p>
                    @endif
                    <p class="text-gray-600 text-sm mb-4">{{ Str::limit($game->description, 100) }}</p>
                    <div class="flex items-center justify-between">
                        @if($game->base_price)
                            <span class="text-2xl font-bold text-green-600">${{ number_format($game->base_price, 2) }}</span>
                        @else
                            <span class="text-sm text-gray-500">Price varies</span>
                        @endif
                        <a href="{{ route('games.show', $game) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200 text-sm">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <i class="fas fa-gamepad text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">No games found</h3>
                <p class="text-gray-500">Try adjusting your search criteria</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($games->hasPages())
        <div class="mt-8">
            {{ $games->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection
