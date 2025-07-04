@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">My Orders</h1>
            <p class="text-gray-600">View your purchase and sales history</p>
        </div>
        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800">
            ← Back to Dashboard
        </a>
    </div>

    <!-- Tab Navigation -->
    <div class="mb-8">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8">
                <button class="tab-button py-2 px-1 border-b-2 font-medium text-sm" data-tab="purchases">
                    My Purchases ({{ $buyerOrders->count() }})
                </button>
                <button class="tab-button py-2 px-1 border-b-2 font-medium text-sm" data-tab="sales">
                    My Sales ({{ $sellerOrders->count() }})
                </button>
            </nav>
        </div>
    </div>

    <!-- Purchases Tab -->
    <div id="purchases" class="tab-content">
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6 border-b">
                <h2 class="text-lg font-semibold">Purchase History</h2>
            </div>
            
            @if($buyerOrders->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($buyerOrders as $order)
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-medium">{{ $order->listing->title }}</h3>
                                    <p class="text-sm text-gray-500">
                                        Game: {{ $order->listing->game->title }} • 
                                        Seller: {{ $order->seller->name }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-green-600">
                                        ${{ number_format((float)$order->total, 2) }}
                                    </p>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        @if($order->status === 'completed') bg-green-100 text-green-800
                                        @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-gray-600">
                                    <p>Quantity: {{ $order->quantity }}</p>
                                    <p>Order Date: {{ $order->created_at->format('M j, Y g:i A') }}</p>
                                </div>
                                
                                <div class="flex space-x-2">
                                    <a href="{{ route('listings.show', $order->listing) }}" 
                                       class="text-blue-600 hover:text-blue-800 text-sm">
                                        View Item
                                    </a>
                                    @if($order->status === 'completed')
                                        <span class="text-gray-400">•</span>
                                        <button class="text-yellow-600 hover:text-yellow-800 text-sm">
                                            Leave Review
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-8 text-center">
                    <div class="text-gray-400 text-4xl mb-4">📦</div>
                    <h3 class="text-lg font-medium text-gray-600 mb-2">No purchases yet</h3>
                    <p class="text-gray-500 mb-4">Start shopping to see your orders here!</p>
                    <a href="{{ route('listings.index') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        Browse Listings
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Sales Tab -->
    <div id="sales" class="tab-content hidden">
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6 border-b">
                <h2 class="text-lg font-semibold">Sales History</h2>
            </div>
            
            @if($sellerOrders->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($sellerOrders as $order)
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-medium">{{ $order->listing->title }}</h3>
                                    <p class="text-sm text-gray-500">
                                        Game: {{ $order->listing->game->title }} • 
                                        Buyer: {{ $order->buyer->name }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-green-600">
                                        ${{ number_format((float)$order->total, 2) }}
                                    </p>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                        @if($order->status === 'completed') bg-green-100 text-green-800
                                        @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-gray-600">
                                    <p>Quantity: {{ $order->quantity }}</p>
                                    <p>Sale Date: {{ $order->created_at->format('M j, Y g:i A') }}</p>
                                </div>
                                
                                <div class="flex space-x-2">
                                    <a href="{{ route('listings.show', $order->listing) }}" 
                                       class="text-blue-600 hover:text-blue-800 text-sm">
                                        View Item
                                    </a>
                                    @if($order->status === 'pending')
                                        <span class="text-gray-400">•</span>
                                        <button class="text-green-600 hover:text-green-800 text-sm">
                                            Mark as Completed
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-8 text-center">
                    <div class="text-gray-400 text-4xl mb-4">💰</div>
                    <h3 class="text-lg font-medium text-gray-600 mb-2">No sales yet</h3>
                    <p class="text-gray-500 mb-4">Create listings to start selling!</p>
                    <a href="{{ route('my-listings.create') }}" 
                       class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                        Create Listing
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');
    
    // Set initial active tab
    tabButtons[0].classList.add('border-blue-500', 'text-blue-600');
    tabButtons[0].classList.remove('border-transparent', 'text-gray-500');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetTab = this.dataset.tab;
            
            // Remove active state from all buttons
            tabButtons.forEach(btn => {
                btn.classList.remove('border-blue-500', 'text-blue-600');
                btn.classList.add('border-transparent', 'text-gray-500');
            });
            
            // Add active state to clicked button
            this.classList.add('border-blue-500', 'text-blue-600');
            this.classList.remove('border-transparent', 'text-gray-500');
            
            // Hide all tab contents
            tabContents.forEach(content => {
                content.classList.add('hidden');
            });
            
            // Show target tab content
            document.getElementById(targetTab).classList.remove('hidden');
        });
    });
});
</script>
@endpush
@endsection
