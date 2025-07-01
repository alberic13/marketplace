@extends('layouts.app')

@section('title', $listing->title)

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Listing Images -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                <div class="aspect-video bg-gray-200 flex items-center justify-center">
                    @if($listing->image_url)
                        <img src="{{ $listing->image_url }}" alt="{{ $listing->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="text-center">
                            <svg class="w-24 h-24 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-gray-500 mt-2">No image available</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Listing Details -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $listing->title }}</h1>
                        <div class="flex items-center space-x-4 text-sm text-gray-600">
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full">{{ $listing->game->title }}</span>
                            <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full">{{ ucfirst($listing->type) }}</span>
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full">{{ ucfirst($listing->status) }}</span>
                        </div>
                    </div>
                    @auth
                        @if(auth()->id() === $listing->user_id)
                            <div class="flex space-x-2">
                                <a href="{{ route('listings.edit', $listing) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
                                    Edit
                                </a>
                                <form action="{{ route('listings.destroy', $listing) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg" onclick="return confirm('Are you sure?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>

                <div class="prose max-w-none">
                    <p class="text-gray-700 leading-relaxed">{{ $listing->description }}</p>
                </div>

                <!-- Game Information -->
                <div class="mt-6 pt-6 border-t">
                    <h3 class="text-lg font-semibold mb-3">Game Details</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Category</p>
                            <p class="font-medium">{{ $listing->game->category->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Platform</p>
                            <p class="font-medium">{{ $listing->game->platform }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Release Date</p>
                            <p class="font-medium">{{ $listing->game->release_date ? $listing->game->release_date->format('Y') : 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Developer</p>
                            <p class="font-medium">{{ $listing->game->developer ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Price & Action -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="text-center mb-6">
                    <div class="text-3xl font-bold text-green-600 mb-2">
                        ${{ number_format($listing->price, 2) }}
                    </div>
                    @if($listing->original_price && $listing->original_price > $listing->price)
                        <div class="text-sm text-gray-500 line-through">
                            ${{ number_format($listing->original_price, 2) }}
                        </div>
                    @endif
                </div>

                @auth
                    @if(auth()->id() !== $listing->user_id && $listing->status === 'active')
                        <div class="space-y-3">
                            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg font-medium">
                                Buy Now
                            </button>
                            <button class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 py-3 px-4 rounded-lg font-medium">
                                Add to Cart
                            </button>
                            <button class="w-full border border-gray-300 hover:bg-gray-50 text-gray-700 py-2 px-4 rounded-lg">
                                ❤️ Add to Favorites
                            </button>
                        </div>
                    @elseif(auth()->id() === $listing->user_id)
                        <div class="text-center text-gray-600">
                            This is your listing
                        </div>
                    @else
                        <div class="text-center text-gray-600">
                            This listing is {{ $listing->status }}
                        </div>
                    @endif
                @else
                    <div class="text-center">
                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800">
                            Login to purchase
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Seller Information -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Seller Information</h3>
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center">
                        <span class="text-lg font-medium">{{ substr($listing->user->name, 0, 1) }}</span>
                    </div>
                    <div>
                        <p class="font-medium">{{ $listing->user->name }}</p>
                        <p class="text-sm text-gray-600">Member since {{ $listing->user->created_at->format('M Y') }}</p>
                    </div>
                </div>
                
                @auth
                    @if(auth()->id() !== $listing->user_id)
                        <button class="w-full bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 px-4 rounded-lg">
                            Message Seller
                        </button>
                    @endif
                @endauth
            </div>

            <!-- Listing Stats -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold mb-4">Listing Details</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Posted</span>
                        <span>{{ $listing->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Updated</span>
                        <span>{{ $listing->updated_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Views</span>
                        <span>{{ $listing->views ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Listings -->
    @if($relatedListings->count() > 0)
        <div class="mt-12">
            <h2 class="text-2xl font-bold mb-6">More from this game</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedListings as $related)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                        <div class="aspect-video bg-gray-200 flex items-center justify-center">
                            @if($related->image_url)
                                <img src="{{ $related->image_url }}" alt="{{ $related->title }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-gray-400">No Image</span>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-medium mb-2 truncate">{{ $related->title }}</h3>
                            <p class="text-green-600 font-bold">${{ number_format($related->price, 2) }}</p>
                            <a href="{{ route('listings.show', $related) }}" class="mt-3 block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-2 rounded">
                                View Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
