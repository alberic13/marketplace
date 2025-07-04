@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Checkout</h1>
            <p class="text-gray-600">Review your order and complete purchase</p>
        </div>
        <a href="{{ route('cart.index') }}" class="text-blue-600 hover:text-blue-800">
            ← Back to Cart
        </a>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex">
                <span class="text-green-400">✅</span>
                <p class="ml-3 text-sm text-green-800">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex">
                <span class="text-red-400">⚠️</span>
                <p class="ml-3 text-sm text-red-800">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Order Items -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md">
                <div class="p-6 border-b">
                    <h2 class="text-lg font-semibold">Order Summary</h2>
                </div>
                
                <div class="divide-y divide-gray-200">
                    @foreach($cartItems as $item)
                        <div class="p-6">
                            <div class="flex items-center space-x-4">
                                <!-- Item Image -->
                                <div class="flex-shrink-0">
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                        @if($item->listing->image_url)
                                            <img src="{{ $item->listing->image_url }}" alt="{{ $item->listing->title }}" 
                                                 class="w-16 h-16 object-cover rounded-lg">
                                        @else
                                            <span class="text-gray-400">🎮</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Item Details -->
                                <div class="flex-1">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">
                                                {{ $item->listing->title }}
                                            </h4>
                                            <p class="text-sm text-gray-500">{{ $item->listing->game->title }}</p>
                                            <p class="text-xs text-gray-400">
                                                Sold by {{ $item->listing->user->name }}
                                            </p>
                                            <div class="mt-2 flex items-center space-x-2">
                                                <span class="text-sm text-gray-600">Qty: {{ $item->quantity }}</span>
                                                <span class="text-sm text-gray-600">•</span>
                                                <span class="text-sm text-gray-600">${{ number_format((float)$item->price, 2) }} each</span>
                                            </div>
                                        </div>
                                        
                                        <div class="text-right">
                                            <p class="text-lg font-medium text-green-600">
                                                ${{ number_format((float)$item->total, 2) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Payment Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-lg font-semibold mb-4">Payment Summary</h2>
                
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-medium">${{ number_format((float)$total, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Processing Fee</span>
                        <span class="font-medium">$0.00</span>
                    </div>
                    <div class="border-t pt-3">
                        <div class="flex justify-between">
                            <span class="text-lg font-semibold">Total</span>
                            <span class="text-lg font-bold text-green-600">${{ number_format((float)$total, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Balance Check -->
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600">Your Balance</span>
                        <span class="font-medium text-lg">${{ number_format((float)auth()->user()->balance, 2) }}</span>
                    </div>
                    
                    @if(auth()->user()->balance >= $total)
                        <div class="mt-2 text-sm text-green-600">
                            ✅ Sufficient balance
                        </div>
                    @else
                        <div class="mt-2 text-sm text-red-600">
                            ⚠️ Insufficient balance (Need ${{ number_format((float)($total - auth()->user()->balance), 2) }} more)
                        </div>
                    @endif
                </div>

                <!-- Checkout Button -->
                <div class="space-y-3">
                    @if(auth()->user()->balance >= $total)
                        <form action="{{ route('checkout.process') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg font-medium">
                                Complete Purchase
                            </button>
                        </form>
                    @else
                        <button disabled class="w-full bg-gray-400 text-white py-3 px-4 rounded-lg font-medium cursor-not-allowed">
                            Insufficient Balance
                        </button>
                        <p class="text-sm text-gray-500 text-center">
                            Please top up your account to complete this purchase
                        </p>
                    @endif
                    
                    <a href="{{ route('cart.index') }}" 
                       class="block w-full text-center border border-gray-300 hover:bg-gray-50 text-gray-700 py-3 px-4 rounded-lg">
                        Back to Cart
                    </a>
                </div>

                <!-- Security Notice -->
                <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                    <div class="flex items-center">
                        <span class="text-blue-600 text-sm">🔒</span>
                        <span class="ml-2 text-sm text-blue-800">
                            Secure payment with buyer protection
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
