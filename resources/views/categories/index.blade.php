@extends('layouts.app')

@section('title', 'Game Categories')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Game Categories</h1>
    </div>

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
                    
                    <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                        <span>{{ $category->games_count }} games</span>
                        <span>{{ $category->listings_count }} listings</span>
                    </div>
                    
                    <div class="space-y-2">
                        <a href="{{ route('categories.show', $category->slug) }}" 
                           class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-lg transition-colors">
                            Browse Category
                        </a>
                        <a href="{{ route('games.index', ['category' => $category->slug]) }}" 
                           class="block w-full border border-gray-300 hover:bg-gray-50 text-gray-700 text-center py-2 px-4 rounded-lg transition-colors">
                            View Games
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($categories->isEmpty())
        <div class="text-center py-12">
            <div class="text-gray-400 text-6xl mb-4">🎮</div>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">No Categories Found</h3>
            <p class="text-gray-500">Check back later for game categories.</p>
        </div>
    @endif

    <!-- Pagination -->
    @if($categories->hasPages())
        <div class="mt-8">
            {{ $categories->links() }}
        </div>
    @endif
</div>
@endsection
