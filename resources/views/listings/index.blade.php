@extends('layouts.app')

@section('title', 'Listings - GameMarket')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Browse Listings</h1>
        <p class="text-lg text-gray-600">Find games for sale or players looking to buy</p>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <form method="GET" action="{{ route('listings.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" name="search" id="search" 
                           value="{{ request('search') }}" 
                           placeholder="Search listings..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <select name="type" id="type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Types</option>
                        <option value="sell" {{ request('type') === 'sell' ? 'selected' : '' }}>For Sale</option>
                        <option value="buy" {{ request('type') === 'buy' ? 'selected' : '' }}>Looking to Buy</option>
                    </select>
                </div>

                <!-- Condition -->
                <div>
                    <label for="condition" class="block text-sm font-medium text-gray-700 mb-1">Condition</label>
                    <select name="condition" id="condition" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Conditions</option>
                        <option value="new" {{ request('condition') === 'new' ? 'selected' : '' }}>New</option>
                        <option value="like_new" {{ request('condition') === 'like_new' ? 'selected' : '' }}>Like New</option>
                        <option value="good" {{ request('condition') === 'good' ? 'selected' : '' }}>Good</option>
                        <option value="fair" {{ request('condition') === 'fair' ? 'selected' : '' }}>Fair</option>
                        <option value="digital" {{ request('condition') === 'digital' ? 'selected' : '' }}>Digital</option>
                    </select>
                </div>

                <!-- Price Range -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Price Range</label>
                    <div class="flex space-x-2">
                        <input type="number" name="min_price" placeholder="Min" 
                               value="{{ request('min_price') }}"
                               class="w-full px-2 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        <input type="number" name="max_price" placeholder="Max" 
                               value="{{ request('max_price') }}"
                               class="w-full px-2 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    </div>
                </div>

                <!-- Submit -->
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200">
                        <i class="fas fa-search mr-2"></i>Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Results Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-lg font-semibold text-gray-900">{{ $listings->total() }} listings found</p>
            @if(request()->hasAny(['search', 'type', 'condition', 'min_price', 'max_price']))
                <p class="text-sm text-gray-600">
                    Filtered results - 
                    <a href="{{ route('listings.index') }}" class="text-blue-600 hover:text-blue-800">Clear filters</a>
                </p>
            @endif
        </div>
        
        @auth
            <a href="{{ route('my-listings.create') }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200">
                <i class="fas fa-plus mr-2"></i>Create Listing
            </a>
        @endauth
    </div>

    <!-- Listings Grid -->
<<<<<<< HEAD
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($listings as $listing)
            <div class="listing-card bg-white rounded-lg shadow-md overflow-hidden hover:shadow-2xl hover:-translate-y-1 transition duration-200">
=======
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($listings as $listing)
            <div class="listing-card bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
>>>>>>> 7e327ca25780d6043a71a16d2ba1e325c59e1d84
                <!-- Listing Header -->
                <div class="p-6">
                    <div class="flex items-center justify-between mb-3">
                        <span class="bg-{{ $listing->type === 'sell' ? 'green' : 'blue' }}-100 text-{{ $listing->type === 'sell' ? 'green' : 'blue' }}-800 px-3 py-1 rounded-full text-sm font-semibold">
                            {{ $listing->type === 'sell' ? 'For Sale' : 'Wanted' }}
                        </span>
                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">
                            {{ ucfirst(str_replace('_', ' ', $listing->condition)) }}
                        </span>
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $listing->title }}</h3>
                    
                    <div class="mb-3">
                        <p class="text-sm text-blue-600 font-semibold">{{ $listing->game->title }}</p>
                        <p class="text-xs text-gray-500">{{ $listing->game->category->name }} • {{ $listing->game->platform }}</p>
                    </div>
                    
                    <p class="text-gray-600 text-sm mb-4">{{ Str::limit($listing->description, 100) }}</p>
                    
                    <!-- Price and Views -->
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-2xl font-bold text-green-600 price-display">${{ number_format($listing->price, 2) }}</span>
                        <span class="text-xs text-gray-500">
                            <i class="fas fa-eye mr-1"></i>{{ $listing->views }} views
                        </span>
                    </div>
                    
                    <!-- Seller Info and Actions -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-user text-gray-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $listing->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $listing->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-2">
                            @auth
                                @if(auth()->id() !== $listing->user_id && $listing->status === 'active' && $listing->type === 'sell')
                                    <form action="{{ route('cart.store') }}" method="POST" class="inline add-to-cart-form">
                                        @csrf
                                        <input type="hidden" name="listing_id" value="{{ $listing->id }}">
                                        <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-3 py-2 rounded-md text-sm transition duration-200">
                                            <i class="fas fa-shopping-cart mr-1"></i>
                                            <span class="add-to-cart-text">Cart</span>
                                        </button>
                                    </form>
                                @endif
                            @endauth
                            
                            <a href="{{ route('listings.show', $listing) }}" 
                               class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200 text-sm">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
<<<<<<< HEAD
            <div class="col-span-full text-center py-16">
                <img src="/public/build/assets/app-logo-icon-Bqx0jWkV.svg" alt="No Listings" class="mx-auto h-16 mb-4 opacity-60">
                <h3 class="text-xl font-semibold text-gray-600 mb-2">No listings found</h3>
                <p class="text-gray-500 mb-4">Try adjusting your search criteria or create your own listing</p>
                @auth
                    <a href="{{ route('my-listings.create') }}" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition duration-200">
                        Create Listing
                    </a>
                @else
                    <a href="{{ route('login') }}" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition duration-200">
=======
            <div class="col-span-full text-center py-12">
                <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">No listings found</h3>
                <p class="text-gray-500 mb-4">Try adjusting your search criteria or create your own listing</p>
                @auth
                    <a href="{{ route('my-listings.create') }}" 
                       class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition duration-200">
                        Create Listing
                    </a>
                @else
                    <a href="{{ route('login') }}" 
                       class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition duration-200">
>>>>>>> 7e327ca25780d6043a71a16d2ba1e325c59e1d84
                        Login to Create Listing
                    </a>
                @endauth
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($listings->hasPages())
        <div class="mt-8">
            {{ $listings->withQueryString()->links() }}
        </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const addToCartForms = document.querySelectorAll('.add-to-cart-form');
    
    addToCartForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const button = this.querySelector('button[type="submit"]');
            const textSpan = button.querySelector('.add-to-cart-text');
            
            // Show loading state
            button.disabled = true;
            textSpan.textContent = 'Adding...';
            
            // Send AJAX request
            fetch(this.action, {
                method: 'POST',
                headers: {
<<<<<<< HEAD
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
=======
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
>>>>>>> 7e327ca25780d6043a71a16d2ba1e325c59e1d84
                },
                body: new FormData(this)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Show success message
                    showNotification('Item added to cart!', 'success');
                    
                    // Update cart count in navbar
                    updateCartCount();
                    
                    // Change button text temporarily
                    textSpan.textContent = 'Added!';
                    button.classList.remove('bg-gray-200', 'hover:bg-gray-300');
                    button.classList.add('bg-green-500', 'hover:bg-green-600', 'text-white');
                    
                    setTimeout(() => {
                        textSpan.textContent = 'Cart';
                        button.classList.remove('bg-green-500', 'hover:bg-green-600', 'text-white');
                        button.classList.add('bg-gray-200', 'hover:bg-gray-300');
                    }, 2000);
                } else {
                    showNotification(data.message || 'Failed to add item to cart', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An error occurred. Please try again.', 'error');
            })
            .finally(() => {
                // Reset button state
                button.disabled = false;
                if (textSpan.textContent === 'Adding...') {
                    textSpan.textContent = 'Cart';
                }
            });
        });
    });
    
    function showNotification(message, type) {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 px-6 py-4 rounded-lg shadow-lg z-50 transform transition-all duration-300 ${
            type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
        }`;
        notification.innerHTML = `
            <div class="flex items-center">
                <span class="mr-3">${type === 'success' ? '✅' : '❌'}</span>
                <span>${message}</span>
                <button class="ml-4 hover:opacity-75" onclick="this.parentElement.parentElement.remove()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        `;
        
        // Add to page
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.style.transform = 'translateY(0)';
        }, 100);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.style.transform = 'translateY(-100%)';
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 300);
        }, 3000);
    }
    
    function updateCartCount() {
        fetch('{{ route("cart.count") }}')
            .then(response => response.json())
            .then(data => {
                const cartBadge = document.querySelector('.cart-count');
                if (cartBadge) {
                    cartBadge.textContent = data.count;
                    cartBadge.style.display = data.count > 0 ? 'inline' : 'none';
                }
            })
            .catch(error => console.error('Error updating cart count:', error));
    }
});
</script>
@endpush
@endsection
