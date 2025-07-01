@extends('layouts.app')

@section('title', 'User Details - ' . $user->name)

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $user->name }}</h1>
            <p class="text-gray-600">User Details and Management</p>
        </div>
        <div class="flex space-x-4">
            <a href="{{ route('admin.users.edit', $user) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg">
                Edit User
            </a>
            <a href="{{ route('admin.users.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                ← Back to Users
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <span class="text-green-400">✅</span>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- User Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Info -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Name</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Email</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Role</label>
                        <span class="mt-1 inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                            @if($user->role === 'admin') bg-red-100 text-red-800
                            @elseif($user->role === 'seller') bg-green-100 text-green-800
                            @else bg-blue-100 text-blue-800 @endif">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Status</label>
                        @if($user->is_verified)
                            <span class="mt-1 inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Verified
                            </span>
                        @else
                            <span class="mt-1 inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Unverified
                            </span>
                        @endif
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Phone</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->phone ?? 'Not provided' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Joined</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('M j, Y g:i A') }}</p>
                    </div>
                </div>
                
                @if($user->address)
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-500">Address</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $user->address }}</p>
                    </div>
                @endif
            </div>

            <!-- User Listings -->
            <div class="bg-white rounded-lg shadow-md">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">User Listings ({{ $user->listings->count() }})</h3>
                </div>
                <div class="p-6">
                    @if($user->listings->count() > 0)
                        <div class="space-y-4">
                            @foreach($user->listings as $listing)
                                <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-b-0">
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center mr-4">
                                            <span class="text-xs">🎮</span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $listing->title }}</p>
                                            <p class="text-sm text-gray-500">{{ $listing->game->title }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-green-600">${{ number_format((float)$listing->price, 2) }}</p>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            @if($listing->status === 'active') bg-green-100 text-green-800
                                            @elseif($listing->status === 'sold') bg-gray-100 text-gray-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                            {{ ucfirst($listing->status) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">This user hasn't created any listings yet.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Balance Management -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Balance Management</h3>
                
                <div class="text-center mb-6">
                    <div class="text-3xl font-bold text-green-600 mb-2">
                        ${{ number_format((float)$user->balance, 2) }}
                    </div>
                    <p class="text-sm text-gray-500">Current Balance</p>
                </div>

                <!-- Add Balance -->
                <form action="{{ route('admin.users.add-balance', $user) }}" method="POST" class="mb-4">
                    @csrf
                    <div class="mb-3">
                        <label for="add_amount" class="block text-sm font-medium text-gray-700 mb-1">Add Balance</label>
                        <input type="number" name="amount" id="add_amount" min="0.01" step="0.01" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500"
                               placeholder="Enter amount">
                    </div>
                    <div class="mb-3">
                        <input type="text" name="note" placeholder="Note (optional)"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    </div>
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg text-sm">
                        Add Balance
                    </button>
                </form>

                <!-- Deduct Balance -->
                <form action="{{ route('admin.users.deduct-balance', $user) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="deduct_amount" class="block text-sm font-medium text-gray-700 mb-1">Deduct Balance</label>
                        <input type="number" name="amount" id="deduct_amount" min="0.01" step="0.01" 
                               max="{{ $user->balance }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500"
                               placeholder="Enter amount">
                    </div>
                    <div class="mb-3">
                        <input type="text" name="note" placeholder="Note (optional)"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                    </div>
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg text-sm">
                        Deduct Balance
                    </button>
                </form>
            </div>

            <!-- User Stats -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">User Statistics</h3>
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Total Listings</span>
                        <span class="text-sm font-medium">{{ $user->listings->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Active Listings</span>
                        <span class="text-sm font-medium">{{ $user->listings->where('status', 'active')->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Sold Listings</span>
                        <span class="text-sm font-medium">{{ $user->listings->where('status', 'sold')->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Account Age</span>
                        <span class="text-sm font-medium">{{ $user->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.users.edit', $user) }}" 
                       class="block w-full bg-yellow-600 hover:bg-yellow-700 text-white text-center py-2 px-4 rounded-lg text-sm">
                        Edit User Details
                    </a>
                    
                    @if($user->role !== 'admin')
                        <form action="{{ route('admin.users.delete', $user) }}" method="POST" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg text-sm"
                                    onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                Delete User
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
