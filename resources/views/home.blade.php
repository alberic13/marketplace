@extends('layouts.app')

@section('title', 'Home - GameMarket')

@section('content')
<!-- Hero Section with SVG Wave -->
<div class="relative bg-gradient-to-r from-blue-600 to-purple-600 dark:from-zinc-900 dark:to-zinc-800 text-white overflow-hidden w-full">
    <div class="w-full px-4 py-24 md:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 drop-shadow-lg">
                Welcome to GameMarket
            </h1>
            <p class="text-xl md:text-2xl mb-8 opacity-90">
                Your ultimate destination for buying and selling games
            </p>
            <div class="space-x-4">
                <a href="{{ route('listings.index') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-100 shadow-lg transition duration-200">
                    Browse Listings
                </a>
                @auth
                    <a href="{{ route('my-listings.create') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 shadow-lg transition duration-200">
                        Sell Your Game
                    </a>
                @else
                    <a href="{{ route('register') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 shadow-lg transition duration-200">
                        Join Now
                    </a>
                @endauth
            </div>
        </div>
    </div>
    <!-- SVG Wave -->
    <svg class="absolute bottom-0 left-0 w-full" height="80" viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill="#f3f4f6" fill-opacity="1" d="M0,32L48,37.3C96,43,192,53,288,58.7C384,64,480,64,576,53.3C672,43,768,21,864,16C960,11,1056,21,1152,32C1248,43,1344,53,1392,58.7L1440,64L1440,80L1392,80C1344,80,1248,80,1152,80C1056,80,960,80,864,80C768,80,672,80,576,80C480,80,384,80,288,80C192,80,96,80,48,80L0,80Z"></path>
    </svg>
</div>

@guest
<!-- Call to Action for Account Creation -->
<div class="bg-gradient-to-r from-green-500 to-blue-600 text-white py-16">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <div class="mb-8">
            <h2 class="text-3xl md:text-4xl font-bold mb-4">Ready to Start Selling?</h2>
            <p class="text-xl opacity-90 mb-8">
                Join thousands of gamers buying and selling on GameMarket. 
                Create your free account and start listing your games today!
            </p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8 mb-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl">📝</span>
                </div>
                <h3 class="text-lg font-semibold mb-2">Create Listings</h3>
                <p class="text-sm opacity-80">List your games with photos and descriptions</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl">💬</span>
                </div>
                <h3 class="text-lg font-semibold mb-2">Connect Safely</h3>
                <p class="text-sm opacity-80">Message buyers and sellers securely</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl">💰</span>
                </div>
                <h3 class="text-lg font-semibold mb-2">Earn Money</h3>
                <p class="text-sm opacity-80">Turn your unused games into cash</p>
            </div>
        </div>
        
        <div class="space-x-4">
            <a href="{{ route('my-listings.create') }}" class="bg-white text-green-600 px-8 py-4 rounded-lg font-bold text-lg hover:bg-gray-100 transition duration-200 inline-block">
                Create Free Account
            </a>
            <a href="{{ route('listings.index') }}" class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold hover:bg-white hover:text-green-600 transition duration-200 inline-block">
                Browse First
            </a>
        </div>
    </div>
</div>
@endguest

<!-- Categories Section with Icons -->
<div class="w-full px-4 py-16 md:px-8 bg-background dark:bg-[#18181b]">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Browse by Category</h2>
        <p class="text-lg text-gray-600 dark:text-gray-300">Discover games from your favorite genres</p>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-6">
        @foreach($categories as $category)
            <a href="{{ route('categories.show', $category) }}" class="group">
                <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-md p-6 text-center hover:shadow-2xl hover:-translate-y-1 transition duration-200 transform group-hover:scale-105">
                    <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-200 transition duration-200">
                        <i class="fas fa-{{ $category->icon ?? 'gamepad' }} text-2xl text-blue-600 dark:text-blue-300"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $category->name }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300">{{ Str::limit($category->description, 50) }}</p>
                </div>
            </a>
        @endforeach
    </div>
    <div class="text-center mt-8">
        <a href="{{ route('categories.index') }}" class="text-blue-600 dark:text-blue-300 hover:text-blue-800 font-semibold">
            View All Categories <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>
</div>

<!-- Featured Games Section -->
<div class="bg-gray-50 dark:bg-zinc-800 py-16 w-full px-4 md:px-8">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Featured Games</h2>
        <p class="text-lg text-gray-600 dark:text-gray-300">Popular games in our marketplace</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($featuredGames as $game)
            <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
                <div class="h-48 bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center">
                    @if($game->cover_image)
                        <img src="{{ $game->cover_image }}" alt="{{ $game->title }}" class="w-full h-full object-cover">
                    @else
                        <i class="fas fa-gamepad text-6xl text-white opacity-50"></i>
                    @endif
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-blue-600 dark:text-blue-300 font-semibold">{{ $game->category->name }}</span>
                        <span class="text-sm text-gray-500 dark:text-gray-300">{{ $game->platform }}</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $game->title }}</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm mb-4">{{ Str::limit($game->description, 100) }}</p>
                    <div class="flex items-center justify-between">
                        @if($game->base_price)
                            <span class="text-2xl font-bold text-green-600 dark:text-green-400">${{ number_format($game->base_price, 2) }}</span>
                        @endif
                        <a href="{{ route('games.show', $game) }}" class="text-blue-600 dark:text-blue-300 hover:text-blue-800 font-semibold">
                            View Details <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="text-center mt-8">
        <a href="{{ route('games.index') }}" class="text-blue-600 dark:text-blue-300 hover:text-blue-800 font-semibold">
            View All Games <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>
</div>

<!-- Recent Listings Section -->
<div class="w-full px-4 py-16 md:px-8 bg-background dark:bg-[#18181b]">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Recent Listings</h2>
        <p class="text-lg text-gray-600 dark:text-gray-300">Latest games available for sale</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($recentListings as $listing)
            <div class="bg-white dark:bg-zinc-900 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
                <div class="h-32 bg-gradient-to-r from-green-400 to-blue-500 flex items-center justify-center">
                    <i class="fas fa-gamepad text-3xl text-white opacity-50"></i>
                </div>
                <div class="p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs bg-{{ $listing->type === 'sell' ? 'green' : 'blue' }}-100 text-{{ $listing->type === 'sell' ? 'green' : 'blue' }}-800 dark:bg-{{ $listing->type === 'sell' ? 'green' : 'blue' }}-900 dark:text-{{ $listing->type === 'sell' ? 'green' : 'blue' }}-300 px-2 py-1 rounded-full font-semibold">
                            {{ ucfirst($listing->type) }}
                        </span>
                        <span class="text-xs text-gray-500 dark:text-gray-300">{{ ucfirst($listing->condition) }}</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">{{ Str::limit($listing->title, 30) }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">{{ $listing->game->title }}</p>
                    <div class="flex items-center justify-between">
                        <span class="text-xl font-bold text-green-600 dark:text-green-400">${{ number_format((float)$listing->price, 2) }}</span>
                        <a href="{{ route('listings.show', $listing) }}" class="text-blue-600 dark:text-blue-300 hover:text-blue-800 text-sm font-semibold">
                            View <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="text-center mt-8">
        <a href="{{ route('listings.index') }}" class="text-blue-600 dark:text-blue-300 hover:text-blue-800 font-semibold">
            View All Listings <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>
</div>

<!-- Call to Action Section -->
<div class="bg-blue-600 dark:bg-blue-900 text-white py-16 w-full px-4 md:px-8">
    <div class="text-center">
        <h2 class="text-3xl font-bold mb-4">Ready to Start Trading?</h2>
        <p class="text-xl mb-8 opacity-90">Join thousands of gamers buying and selling games on our platform</p>
        <div class="space-x-4">
            @auth
                <a href="{{ route('my-listings.create') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-200">
                    Create Your First Listing
                </a>
            @else
                <a href="{{ route('register') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-200">
                    Sign Up Now
                </a>
                <a href="{{ route('login') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition duration-200">
                    Already a Member?
                </a>
            @endauth
        </div>
    </div>
</div>

<!-- Testimonials/Trust Section -->
<div class="bg-white dark:bg-zinc-900 py-16 w-full px-4 md:px-8">
    <div class="text-center">
        <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">Trusted by Gamers Everywhere</h2>
        <div class="flex flex-col md:flex-row justify-center gap-8">
            <div class="bg-gray-50 dark:bg-zinc-800 rounded-lg p-6 shadow-md flex-1">
                <div class="text-3xl mb-2">⭐️⭐️⭐️⭐️⭐️</div>
                <p class="text-gray-700 dark:text-gray-200 mb-2">“GameMarket made it so easy to sell my old games. I got paid fast and met awesome buyers!”</p>
                <div class="text-sm text-gray-500 dark:text-gray-300">— Alex, Seller</div>
            </div>
            <div class="bg-gray-50 dark:bg-zinc-800 rounded-lg p-6 shadow-md flex-1">
                <div class="text-3xl mb-2">⭐️⭐️⭐️⭐️⭐️</div>
                <p class="text-gray-700 dark:text-gray-200 mb-2">“I found rare games at great prices. The checkout was smooth and secure!”</p>
                <div class="text-sm text-gray-500 dark:text-gray-300">— Jamie, Buyer</div>
            </div>
        </div>
        <div class="mt-8 flex justify-center gap-6">
            <img src="/public/build/assets/app-logo-icon-Bqx0jWkV.svg" alt="Secure" class="h-10 inline-block">
            <span class="text-green-600 dark:text-green-400 font-semibold flex items-center"><i class="fas fa-shield-alt mr-2"></i> Buyer Protection</span>
            <span class="text-blue-600 dark:text-blue-300 font-semibold flex items-center"><i class="fas fa-lock mr-2"></i> Secure Payments</span>
        </div>
    </div>
</div>
@endsection
