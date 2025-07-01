@extends('layouts.app')

@section('title', 'Dashboard - GameMarket')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome back, {{ auth()->user()->name }}!</h1>
        <p class="text-lg text-gray-600">Manage your listings and explore the marketplace</p>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                    <i class="fas fa-list text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">My Listings</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ auth()->user()->listings()->count() }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                    <i class="fas fa-dollar-sign text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Balance</p>
                    <p class="text-2xl font-bold text-gray-900">
                        ${{ number_format(auth()->user()->balance, 2) }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                    <i class="fas fa-star text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Reviews</p>
                    <p class="text-2xl font-bold text-gray-900">0</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 text-orange-600 mr-4">
                    <i class="fas fa-shopping-cart text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Orders</p>
                    <p class="text-2xl font-bold text-gray-900">0</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('my-listings.create') }}" 
               class="bg-blue-600 text-white p-4 rounded-lg hover:bg-blue-700 transition duration-200 text-center">
                <i class="fas fa-plus text-2xl mb-2 block"></i>
                <span class="font-semibold">Create New Listing</span>
            </a>

            <a href="{{ route('my-listings.index') }}" 
               class="bg-gray-600 text-white p-4 rounded-lg hover:bg-gray-700 transition duration-200 text-center">
                <i class="fas fa-list text-2xl mb-2 block"></i>
                <span class="font-semibold">Manage Listings</span>
            </a>

            <a href="{{ route('listings.index') }}" 
               class="bg-green-600 text-white p-4 rounded-lg hover:bg-green-700 transition duration-200 text-center">
                <i class="fas fa-search text-2xl mb-2 block"></i>
                <span class="font-semibold">Browse Marketplace</span>
            </a>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Listings -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Recent Listings</h2>
            @php
                $recentListings = auth()->user()->listings()->with('game')->latest()->take(5)->get();
            @endphp
            
            @if($recentListings->count() > 0)
                <div class="space-y-4">
                    @foreach($recentListings as $listing)
                        <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $listing->title }}</h3>
                                <p class="text-sm text-gray-600">{{ $listing->game->title }}</p>
                                <span class="text-xs bg-{{ $listing->type === 'sell' ? 'green' : 'blue' }}-100 text-{{ $listing->type === 'sell' ? 'green' : 'blue' }}-800 px-2 py-1 rounded-full">
                                    {{ ucfirst($listing->type) }}
                                </span>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-green-600">${{ number_format($listing->price, 2) }}</p>
                                <p class="text-xs text-gray-500">{{ $listing->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('my-listings.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                        View All Listings <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-list text-4xl text-gray-300 mb-3"></i>
                    <p class="text-gray-600 mb-4">You haven't created any listings yet</p>
                    <a href="{{ route('my-listings.create') }}" 
                       class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                        Create Your First Listing
                    </a>
                </div>
            @endif
        </div>

        <!-- Account Info -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Account Information</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600">Name</label>
                    <p class="text-gray-900">{{ auth()->user()->name }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-600">Email</label>
                    <p class="text-gray-900">{{ auth()->user()->email }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-600">Role</label>
                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-sm font-semibold">
                        {{ ucfirst(auth()->user()->role) }}
                    </span>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-600">Account Status</label>
                    <span class="bg-{{ auth()->user()->is_verified ? 'green' : 'yellow' }}-100 text-{{ auth()->user()->is_verified ? 'green' : 'yellow' }}-800 px-2 py-1 rounded-full text-sm font-semibold">
                        {{ auth()->user()->is_verified ? 'Verified' : 'Pending Verification' }}
                    </span>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-600">Member Since</label>
                    <p class="text-gray-900">{{ auth()->user()->created_at->format('F j, Y') }}</p>
                </div>
            </div>
            
            <div class="mt-6">
                <a href="{{ route('profile.edit') }}" 
                   class="w-full bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition duration-200 text-center block">
                    Edit Profile
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
