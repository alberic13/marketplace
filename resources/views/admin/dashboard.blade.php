@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Admin Dashboard</h1>
            <p class="text-gray-600">Welcome back, {{ auth()->user()->name }}</p>
        </div>
        <div class="flex space-x-4">
            <a href="{{ route('admin.users.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                Manage Users
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                        <span class="text-white text-sm">👥</span>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Users</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_users']) }}</p>
                </div>
            </div>
        </div>

        <!-- Total Listings -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                        <span class="text-white text-sm">📝</span>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Listings</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_listings']) }}</p>
                </div>
            </div>
        </div>

        <!-- Active Listings -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center">
                        <span class="text-white text-sm">✅</span>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Active Listings</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['active_listings']) }}</p>
                </div>
            </div>
        </div>

        <!-- Total Games -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                        <span class="text-white text-sm">🎮</span>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Games</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total_games']) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Users -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Recent Users</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($stats['recent_users'] as $user)
                        <div class="flex items-center justify-between py-2">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-medium">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($user->role === 'admin') bg-red-100 text-red-800
                                    @elseif($user->role === 'seller') bg-green-100 text-green-800
                                    @else bg-blue-100 text-blue-800 @endif">
                                    {{ ucfirst($user->role) }}
                                </span>
                                <p class="text-xs text-gray-500 mt-1">{{ $user->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        View all users →
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Listings -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Recent Listings</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($stats['recent_listings'] as $listing)
                        <div class="flex items-center justify-between py-2">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <span class="text-xs">🎮</span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ Str::limit($listing->title, 30) }}</p>
                                    <p class="text-sm text-gray-500">by {{ $listing->user->name }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-green-600">${{ number_format((float)$listing->price, 2) }}</p>
                                <p class="text-xs text-gray-500">{{ $listing->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    <a href="{{ route('listings.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        View all listings →
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8 bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('admin.users.index') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                    <span class="text-white text-sm">👥</span>
                </div>
                <div>
                    <p class="text-sm font-medium">Manage Users</p>
                    <p class="text-xs text-gray-500">View and edit users</p>
                </div>
            </a>
            
            <a href="{{ route('listings.index') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-3">
                    <span class="text-white text-sm">📝</span>
                </div>
                <div>
                    <p class="text-sm font-medium">View Listings</p>
                    <p class="text-xs text-gray-500">Browse all listings</p>
                </div>
            </a>
            
            <a href="{{ route('games.index') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center mr-3">
                    <span class="text-white text-sm">🎮</span>
                </div>
                <div>
                    <p class="text-sm font-medium">View Games</p>
                    <p class="text-xs text-gray-500">Browse game catalog</p>
                </div>
            </a>
            
            <a href="{{ route('categories.index') }}" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center mr-3">
                    <span class="text-white text-sm">📂</span>
                </div>
                <div>
                    <p class="text-sm font-medium">Categories</p>
                    <p class="text-xs text-gray-500">Manage categories</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
