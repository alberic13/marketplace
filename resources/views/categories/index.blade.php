@extends('layouts.app')

@section('title', 'Game Categories')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Game Categories</h1>
    </div>
<<<<<<< HEAD
    <!-- Trending Categories -->
    @if(isset($trendingCategories) && count($trendingCategories) > 0)
    <div class="mb-8">
        <h2 class="text-xl font-semibold text-blue-600 mb-4">Trending Categories</h2>
        <div class="flex flex-wrap gap-4">
            @foreach($trendingCategories as $category)
                <a href="{{ route('categories.show', $category->slug) }}" class="flex items-center bg-blue-100 hover:bg-blue-200 text-blue-800 px-4 py-2 rounded-full font-semibold transition-colors">
                    <svg class="h-6 w-6 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" /></svg>
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </div>
    @endif
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @foreach($categories as $category)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-2xl hover:-translate-y-1 transition duration-200">
                <div class="aspect-video bg-gradient-to-br from-blue-400 to-purple-600 flex items-center justify-center">
                    <div class="text-center text-white">
                        <svg class="h-10 w-10 mx-auto mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="16" rx="4" /></svg>
                        <h3 class="text-xl font-bold">{{ $category->name }}</h3>
                    </div>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 mb-4 text-sm">{{ $category->description ?? 'Explore games in this category' }}</p>
=======

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($categories as $category)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <div class="aspect-video bg-gradient-to-br from-blue-400 to-purple-600 flex items-center justify-center">
                    <div class="text-center text-white">
                        <div class="text-4xl mb-2">🎮</div>
                        <h3 class="text-xl font-bold">{{ $category->name }}</h3>
                    </div>
                </div>
                
                <div class="p-6">
                    <p class="text-gray-600 mb-4 text-sm">{{ $category->description ?? 'Explore games in this category' }}</p>
                    
>>>>>>> 7e327ca25780d6043a71a16d2ba1e325c59e1d84
                    <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                        <span>{{ $category->games_count }} games</span>
                        <span>{{ $category->listings_count }} listings</span>
                    </div>
<<<<<<< HEAD
                    <div class="space-y-2">
                        <a href="{{ route('categories.show', $category->slug) }}" class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-lg transition-colors">
                            Browse Category
                        </a>
                        <a href="{{ route('games.index', ['category' => $category->slug]) }}" class="block w-full border border-gray-300 hover:bg-gray-50 text-gray-700 text-center py-2 px-4 rounded-lg transition-colors">
=======
                    
                    <div class="space-y-2">
                        <a href="{{ route('categories.show', $category->slug) }}" 
                           class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-lg transition-colors">
                            Browse Category
                        </a>
                        <a href="{{ route('games.index', ['category' => $category->slug]) }}" 
                           class="block w-full border border-gray-300 hover:bg-gray-50 text-gray-700 text-center py-2 px-4 rounded-lg transition-colors">
>>>>>>> 7e327ca25780d6043a71a16d2ba1e325c59e1d84
                            View Games
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
<<<<<<< HEAD
=======

>>>>>>> 7e327ca25780d6043a71a16d2ba1e325c59e1d84
    @if($categories->isEmpty())
        <div class="text-center py-12">
            <div class="text-gray-400 text-6xl mb-4">🎮</div>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">No Categories Found</h3>
            <p class="text-gray-500">Check back later for game categories.</p>
        </div>
    @endif
<<<<<<< HEAD
=======

>>>>>>> 7e327ca25780d6043a71a16d2ba1e325c59e1d84
    <!-- Pagination -->
    @if($categories->hasPages())
        <div class="mt-8">
            {{ $categories->links() }}
        </div>
    @endif
</div>
@endsection
