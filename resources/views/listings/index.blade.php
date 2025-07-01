@extends('layouts.app')

@section('title', 'Listings - GameMarket')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Browse Listings</h1>
        <p class="text-lg text-gray-600">Find games for sale or players looking to buy</p>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <form method="GET" action="{{ route('listings.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" name="search" id="search" 
                           value="{{ request('search') }}" 
                           placeholder="Search listings..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <select name="type" id="type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Types</option>
                        <option value="sell" {{ request('type') === 'sell' ? 'selected' : '' }}>For Sale</option>
                        <option value="buy" {{ request('type') === 'buy' ? 'selected' : '' }}>Looking to Buy</option>
                    </select>
                </div>

                <!-- Condition -->
                <div>
                    <label for="condition" class="block text-sm font-medium text-gray-700 mb-1">Condition</label>
                    <select name="condition" id="condition" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Conditions</option>
                        <option value="new" {{ request('condition') === 'new' ? 'selected' : '' }}>New</option>
                        <option value="like_new" {{ request('condition') === 'like_new' ? 'selected' : '' }}>Like New</option>
                        <option value="good" {{ request('condition') === 'good' ? 'selected' : '' }}>Good</option>
                        <option value="fair" {{ request('condition') === 'fair' ? 'selected' : '' }}>Fair</option>
                        <option value="digital" {{ request('condition') === 'digital' ? 'selected' : '' }}>Digital</option>
                    </select>
                </div>

                <!-- Price Range -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Price Range</label>
                    <div class="flex space-x-2">
                        <input type="number" name="min_price" placeholder="Min" 
                               value="{{ request('min_price') }}"
                               class="w-full px-2 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        <input type="number" name="max_price" placeholder="Max" 
                               value="{{ request('max_price') }}"
                               class="w-full px-2 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    </div>
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

    <!-- Results Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-lg font-semibold text-gray-900">{{ $listings->total() }} listings found</p>
            @if(request()->hasAny(['search', 'type', 'condition', 'min_price', 'max_price']))
                <p class="text-sm text-gray-600">
                    Filtered results - 
                    <a href="{{ route('listings.index') }}" class="text-blue-600 hover:text-blue-800">Clear filters</a>
                </p>
            @endif
        </div>
        
        @auth
            <a href="{{ route('my-listings.create') }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200">
                <i class="fas fa-plus mr-2"></i>Create Listing
            </a>
        @endauth
    </div>

    <!-- Listings Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($listings as $listing)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
                <!-- Listing Header -->
                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <span class="bg-{{ $listing->type === 'sell' ? 'green' : 'blue' }}-100 text-{{ $listing->type === 'sell' ? 'green' : 'blue' }}-800 px-3 py-1 rounded-full text-sm font-semibold">
                            {{ $listing->type === 'sell' ? 'For Sale' : 'Wanted' }}
                        </span>
                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">
                            {{ ucfirst(str_replace('_', ' ', $listing->condition)) }}
                        </span>
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $listing->title }}</h3>
                    
                    <div class="mb-3">
                        <p class="text-sm text-blue-600 font-semibold">{{ $listing->game->title }}</p>
                        <p class="text-xs text-gray-500">{{ $listing->game->category->name }} • {{ $listing->game->platform }}</p>
                    </div>
                    
                    <p class="text-gray-600 text-sm mb-4">{{ Str::limit($listing->description, 100) }}</p>
                    
                    <!-- Price and Views -->
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-2xl font-bold text-green-600">${{ number_format($listing->price, 2) }}</span>
                        <span class="text-xs text-gray-500">
                            <i class="fas fa-eye mr-1"></i>{{ $listing->views }} views
                        </span>
                    </div>
                    
                    <!-- Seller Info and Actions -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-user text-gray-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $listing->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $listing->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        
                        <a href="{{ route('listings.show', $listing) }}" 
                           class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200 text-sm">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">No listings found</h3>
                <p class="text-gray-500 mb-4">Try adjusting your search criteria or create your own listing</p>
                @auth
                    <a href="{{ route('my-listings.create') }}" 
                       class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition duration-200">
                        Create Listing
                    </a>
                @else
                    <a href="{{ route('login') }}" 
                       class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition duration-200">
                        Login to Create Listing
                    </a>
                @endauth
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($listings->hasPages())
        <div class="mt-8">
            {{ $listings->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection
