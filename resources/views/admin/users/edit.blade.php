@extends('layouts.app')

@section('title', 'Edit User - ' . $user->name)

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Edit User</h1>
                <p class="text-gray-600">Modify user details and permissions</p>
            </div>
            <a href="{{ route('admin.users.show', $user) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                ← Back to User
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <!-- Error Messages -->
            @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <span class="text-red-400">⚠️</span>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Please correct the following errors:</h3>
                            <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.users.update', $user) }}">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input id="name" type="text" name="name" value="{{ old('name') ?? $user->name }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') ?? $user->email }}" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role -->
                <div class="mb-6">
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                        Role <span class="text-red-500">*</span>
                    </label>
                    <select name="role" id="role" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Select Role</option>
                        <option value="user" {{ (old('role') ?? $user->role) == 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ (old('role') ?? $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="seller" {{ (old('role') ?? $user->role) == 'seller' ? 'selected' : '' }}>Seller</option>
                        <option value="buyer" {{ (old('role') ?? $user->role) == 'buyer' ? 'selected' : '' }}>Buyer</option>
                    </select>
                    @error('role')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Balance -->
                <div class="mb-6">
                    <label for="balance" class="block text-sm font-medium text-gray-700 mb-2">
                        Balance ($) <span class="text-red-500">*</span>
                    </label>
                    <input id="balance" type="number" name="balance" value="{{ old('balance') ?? $user->balance }}" 
                           required min="0" step="0.01"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('balance')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div class="mb-6">
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                        Phone Number
                    </label>
                    <input id="phone" type="tel" name="phone" value="{{ old('phone') ?? $user->phone }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div class="mb-6">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                        Address
                    </label>
                    <textarea id="address" name="address" rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('address') ?? $user->address }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Verification Status -->
                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_verified" value="1" 
                               {{ (old('is_verified') ?? $user->is_verified) ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span class="ml-3 text-sm text-gray-700">
                            User is verified
                        </span>
                    </label>
                    @error('is_verified')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-between">
                    <a href="{{ route('admin.users.show', $user) }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
