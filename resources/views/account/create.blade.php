@extends('layouts.app')

@section('title', 'Create Account - Start Selling Games')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-12">
    <div class="container mx-auto px-6">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-700 px-6 py-8 text-center">
                <div class="text-white">
                    <div class="text-4xl mb-2">🎮</div>
                    <h1 class="text-2xl font-bold mb-2">Join GameMarket</h1>
                    <p class="text-blue-100">Create your account to start buying and selling games</p>
                </div>
            </div>

            <!-- Form -->
            <div class="p-6">
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

                <form method="POST" action="{{ route('my-listings.store') }}">>
                    @csrf

                    <!-- Name -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Enter your full name">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Enter your email address">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="mb-4">
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Phone Number
                        </label>
                        <input id="phone" type="tel" name="phone" value="{{ old('phone') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Enter your phone number (optional)">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="mb-4">
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                            Address
                        </label>
                        <textarea id="address" name="address" rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Enter your address (optional)">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input id="password" type="password" name="password" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Create a strong password">
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Confirm Password <span class="text-red-500">*</span>
                        </label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Confirm your password">
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="mb-6">
                        <label class="flex items-start">
                            <input type="checkbox" name="terms" value="1" required 
                                   class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <span class="ml-3 text-sm text-gray-700">
                                I agree to the 
                                <a href="#" class="text-blue-600 hover:text-blue-800 underline">Terms of Service</a> 
                                and 
                                <a href="#" class="text-blue-600 hover:text-blue-800 underline">Privacy Policy</a>
                                <span class="text-red-500">*</span>
                            </span>
                        </label>
                        @error('terms')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-blue-600 to-purple-700 hover:from-blue-700 hover:to-purple-800 text-white font-semibold py-3 px-6 rounded-lg transition duration-300 transform hover:scale-105">
                        Create Account
                    </button>
                </form>

                <!-- Login Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                            Sign in here
                        </a>
                    </p>
                </div>

                <!-- Features -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h3 class="text-sm font-medium text-gray-700 mb-4">Why join GameMarket?</h3>
                    <div class="space-y-3">
                        <div class="flex items-center text-sm text-gray-600">
                            <div class="w-5 h-5 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                <span class="text-white text-xs">✓</span>
                            </div>
                            Buy and sell games with trusted gamers
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <div class="w-5 h-5 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                <span class="text-white text-xs">✓</span>
                            </div>
                            Secure transactions and messaging
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <div class="w-5 h-5 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                <span class="text-white text-xs">✓</span>
                            </div>
                            Easy listing management tools
                        </div>
                        <div class="flex items-center text-sm text-gray-600">
                            <div class="w-5 h-5 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                <span class="text-white text-xs">✓</span>
                            </div>
                            Connect with gaming community
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="max-w-md mx-auto mt-8 text-center">
            <p class="text-sm text-gray-500">
                By creating an account, you can start listing your games for sale, 
                browse exclusive deals, and connect with fellow gamers worldwide.
            </p>
        </div>
    </div>
</div>

<script>
// Simple form validation enhancement
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('password_confirmation');
    
    function validatePasswords() {
        if (password.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Passwords do not match');
        } else {
            confirmPassword.setCustomValidity('');
        }
    }
    
    password.addEventListener('input', validatePasswords);
    confirmPassword.addEventListener('input', validatePasswords);
    
    // Form submission animation
    form.addEventListener('submit', function(e) {
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.innerHTML = '<span class="inline-block animate-spin mr-2">⏳</span> Creating Account...';
        submitBtn.disabled = true;
    });
});
</script>
@endsection
