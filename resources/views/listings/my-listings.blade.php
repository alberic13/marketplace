@extends('layouts.app')

@section('title', 'My Listings')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-800">My Listings</h1>
        <a href="{{ route('listings.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">
            Create New Listing
        </a>
    </div>

    @if($listings->count() > 0)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Listing</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Game</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Views</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($listings as $listing)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12">
                                            @if($listing->image_url)
                                                <img class="h-12 w-12 rounded-lg object-cover" src="{{ $listing->image_url }}" alt="{{ $listing->title }}">
                                            @else
                                                <div class="h-12 w-12 rounded-lg bg-gray-200 flex items-center justify-center">
                                                    <span class="text-gray-400 text-xs">No img</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $listing->title }}</div>
                                            <div class="text-sm text-gray-500">{{ Str::limit($listing->description, 50) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $listing->game->title }}</div>
                                    <div class="text-sm text-gray-500">{{ $listing->game->platform }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-green-600">${{ number_format($listing->price, 2) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $listing->type == 'sell' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst($listing->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        @if($listing->status == 'active') bg-green-100 text-green-800
                                        @elseif($listing->status == 'sold') bg-gray-100 text-gray-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ ucfirst($listing->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $listing->created_at->format('M j, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $listing->views ?? 0 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                    <a href="{{ route('listings.show', $listing) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                    <a href="{{ route('listings.edit', $listing) }}" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                    <form action="{{ route('listings.destroy', $listing) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this listing?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($listings->hasPages())
            <div class="mt-6">
                {{ $listings->links() }}
            </div>
        @endif

        <!-- Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                            <span class="text-white text-sm">📝</span>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Listings</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $listings->total() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                            <span class="text-white text-sm">✅</span>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Active</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ $listings->where('status', 'active')->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-gray-500 rounded-full flex items-center justify-center">
                            <span class="text-white text-sm">💰</span>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Sold</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ $listings->where('status', 'sold')->count() }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                            <span class="text-white text-sm">👁️</span>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Views</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ $listings->sum('views') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

    @else
        <div class="text-center py-12">
            <div class="text-gray-400 text-6xl mb-4">📝</div>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">No Listings Yet</h3>
            <p class="text-gray-500 mb-6">Create your first listing to start selling or looking for games!</p>
            <a href="{{ route('listings.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg inline-block">
                Create Your First Listing
            </a>
        </div>
    @endif
</div>
@endsection
