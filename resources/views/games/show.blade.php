@extends('layouts.app')

@section('title', $game->title . ' - GameMarket')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-8">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li><a href="{{ route('home') }}" class="hover:text-blue-600">Home</a></li>
            <li><i class="fas fa-chevron-right mx-2"></i></li>
            <li><a href="{{ route('games.index') }}" class="hover:text-blue-600">Games</a></li>
            <li><i class="fas fa-chevron-right mx-2"></i></li>
            <li class="text-gray-900">{{ $game->title }}</li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Game Details -->
        <div class="lg:col-span-2">
            <!-- Game Header -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
                <div class="h-64 bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center">
                    @if($game->cover_image)
                        <img src="{{ $game->cover_image }}" alt="{{ $game->title }}" class="w-full h-full object-cover">
                    @else
                        <i class="fas fa-gamepad text-8xl text-white opacity-50"></i>
                    @endif
                </div>
                
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                            {{ $game->category->name }}
                        </span>
                        <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm">
                            {{ $game->platform }}
                        </span>
                    </div>
                    
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $game->title }}</h1>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        @if($game->developer)
                            <div>
                                <span class="text-sm font-medium text-gray-500">Developer:</span>
                                <p class="text-gray-900">{{ $game->developer }}</p>
                            </div>
                        @endif
                        
                        @if($game->publisher)
                            <div>
                                <span class="text-sm font-medium text-gray-500">Publisher:</span>
                                <p class="text-gray-900">{{ $game->publisher }}</p>
                            </div>
                        @endif
                        
                        @if($game->release_date)
                            <div>
                                <span class="text-sm font-medium text-gray-500">Release Date:</span>
                                <p class="text-gray-900">{{ $game->release_date->format('F j, Y') }}</p>
                            </div>
                        @endif
                        
                        @if($game->genre)
                            <div>
                                <span class="text-sm font-medium text-gray-500">Genre:</span>
                                <p class="text-gray-900">{{ $game->genre }}</p>
                            </div>
                        @endif
                    </div>

                    @if($game->base_price)
                        <div class="mb-6">
                            <span class="text-sm font-medium text-gray-500">Base Price:</span>
                            <p class="text-3xl font-bold text-green-600">${{ number_format($game->base_price, 2) }}</p>
                        </div>
                    @endif
                    
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Description</h3>
                        <p class="text-gray-700 leading-relaxed">{{ $game->description }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    @auth
                        <a href="{{ route('my-listings.create', ['game_id' => $game->id]) }}" 
                           class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200 text-center block">
                            <i class="fas fa-plus mr-2"></i>Create Listing
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200 text-center block">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login to Create Listing
                        </a>
                    @endauth
                    
                    <a href="{{ route('listings.index', ['search' => $game->title]) }}" 
                       class="w-full border border-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-50 transition duration-200 text-center block">
                        <i class="fas fa-search mr-2"></i>Find Listings
                    </a>
                </div>
            </div>

            <!-- Game Stats -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistics</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Listings:</span>
                        <span class="font-semibold">{{ $listings->total() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Active Listings:</span>
                        <span class="font-semibold">{{ $listings->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Listings Section -->
    <div class="mt-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Available Listings</h2>
            <span class="text-sm text-gray-500">{{ $listings->total() }} listings found</span>
        </div>

        @if($listings->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($listings as $listing)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-3">
                                <span class="bg-{{ $listing->type === 'sell' ? 'green' : 'blue' }}-100 text-{{ $listing->type === 'sell' ? 'green' : 'blue' }}-800 px-2 py-1 rounded-full text-xs font-semibold">
                                    {{ ucfirst($listing->type) }}
                                </span>
                                <span class="text-xs text-gray-500">{{ ucfirst($listing->condition) }}</span>
                            </div>
                            
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $listing->title }}</h3>
                            <p class="text-gray-600 text-sm mb-3">{{ Str::limit($listing->description, 80) }}</p>
                            
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-2xl font-bold text-green-600">${{ number_format($listing->price, 2) }}</span>
                                <span class="text-xs text-gray-500">
                                    <i class="fas fa-eye mr-1"></i>{{ $listing->views }} views
                                </span>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-gray-600">
                                    <i class="fas fa-user mr-1"></i>{{ $listing->user->name }}
                                </div>
                                <a href="{{ route('listings.show', $listing) }}" 
                                   class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition duration-200">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($listings->hasPages())
                <div class="mt-8">
                    {{ $listings->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <i class="fas fa-list text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">No listings available</h3>
                <p class="text-gray-500 mb-4">Be the first to create a listing for this game!</p>
                @auth
                    <a href="{{ route('my-listings.create', ['game_id' => $game->id]) }}" 
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
        @endif
    </div>
</div>
@endsection
