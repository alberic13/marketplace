@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header -->
<<<<<<< HEAD
    <div class="flex items-center justify-between mb-8">
=======
    <div class="flex items                    <div class="space-y-3">
                        <a href="{{ route('checkout.index') }}" 
                           class="checkout-button block w-full text-center bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg font-medium">
                            Proceed to Checkout
                        </a>
                        <a href="{{ route('listings.index') }}" 
                           class="block w-full text-center border border-gray-300 hover:bg-gray-50 text-gray-700 py-3 px-4 rounded-lg">
                            Continue Shopping
                        </a>
                    </div>ustify-between mb-8">
>>>>>>> 7e327ca25780d6043a71a16d2ba1e325c59e1d84
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Shopping Cart</h1>
            <p class="text-gray-600">Review your items before checkout</p>
        </div>
        <a href="{{ route('listings.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            Continue Shopping
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

    @if(session('info'))
        <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex">
                <span class="text-blue-400">ℹ️</span>
                <p class="ml-3 text-sm text-blue-800">{{ session('info') }}</p>
            </div>
        </div>
    @endif

    @if($cartItems->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">
                            Cart Items ({{ $cartItems->count() }})
                        </h3>
                        <form action="{{ route('cart.clear') }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm clear-cart">
                                Clear All
                            </button>
                        </form>
                    </div>
                    
                    <div class="divide-y divide-gray-200">
                        @foreach($cartItems as $item)
                            <div class="p-6 cart-item">
                                <div class="flex items-center space-x-4">
                                    <!-- Item Image -->
                                    <div class="flex-shrink-0">
                                        <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                            @if($item->listing->image_url)
                                                <img src="{{ $item->listing->image_url }}" alt="{{ $item->listing->title }}" 
                                                     class="w-20 h-20 object-cover rounded-lg">
                                            @else
                                                <span class="text-gray-400">🎮</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Item Details -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <h4 class="text-sm font-medium text-gray-900 truncate">
                                                    {{ $item->listing->title }}
                                                </h4>
                                                <p class="text-sm text-gray-500">{{ $item->listing->game->title }}</p>
                                                <p class="text-xs text-gray-400">
                                                    Sold by {{ $item->listing->user->name }}
                                                </p>
                                                <div class="mt-1">
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                        bg-{{ $item->listing->type == 'sell' ? 'green' : 'blue' }}-100 
                                                        text-{{ $item->listing->type == 'sell' ? 'green' : 'blue' }}-800">
                                                        {{ ucfirst($item->listing->type) }}
                                                    </span>
                                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 ml-1">
                                                        {{ ucfirst($item->listing->condition) }}
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            <!-- Price and Actions -->
                                            <div class="text-right">
                                                <p class="text-lg font-medium text-green-600 price-display">
                                                    ${{ number_format((float)$item->price, 2) }}
                                                </p>
                                                @if($item->listing->price != $item->price)
                                                    <p class="text-sm text-gray-500 line-through">
                                                        ${{ number_format((float)$item->listing->price, 2) }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Quantity and Remove -->
                                        <div class="mt-4 flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                <label class="text-sm text-gray-600">Quantity:</label>
                                                <form action="{{ route('cart.update', $item) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <select name="quantity" onchange="this.form.submit()" 
                                                            class="border border-gray-300 rounded px-2 py-1 text-sm quantity-input">
                                                        @for($i = 1; $i <= 10; $i++)
                                                            <option value="{{ $i }}" {{ $item->quantity == $i ? 'selected' : '' }}>
                                                                {{ $i }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </form>
                                            </div>

                                            <div class="flex items-center space-x-4">
                                                <span class="text-sm font-medium text-gray-900 price-display">
                                                    Total: ${{ number_format((float)$item->total, 2) }}
                                                </span>
                                                <form action="{{ route('cart.destroy', $item) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm remove-item">
                                                        Remove
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Items ({{ $cartItems->count() }})</span>
                            <span>${{ number_format((float)$total, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Shipping</span>
                            <span class="text-green-600">Free</span>
                        </div>
                        <div class="border-t pt-3">
                            <div class="flex justify-between text-lg font-medium">
                                <span>Total</span>
                                <span class="text-green-600">${{ number_format((float)$total, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 space-y-3">
                        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg font-medium">
                            Proceed to Checkout
                        </button>
                        <a href="{{ route('listings.index') }}" 
                           class="block w-full text-center border border-gray-300 hover:bg-gray-50 text-gray-700 py-3 px-4 rounded-lg">
                            Continue Shopping
                        </a>
                    </div>

                    <!-- Security Notice -->
                    <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <span class="text-green-600 text-sm">🔒</span>
                            <span class="ml-2 text-sm text-gray-600">
                                Secure checkout with buyer protection
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Empty Cart -->
        <div class="text-center py-16">
            <div class="text-gray-400 text-6xl mb-4">🛒</div>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">Your cart is empty</h3>
            <p class="text-gray-500 mb-6">Add some games to your cart to get started!</p>
            <a href="{{ route('listings.index') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg inline-block">
                Browse Listings
            </a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/cart.js') }}"></script>
@endpush
