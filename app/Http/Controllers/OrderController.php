<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Create order from cart
     */
    public function checkout(Request $request)
    {
        $user = auth()->user();
        $cartItems = $user->cartItems()->with('listing.user')->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }
        
        $total = $cartItems->sum('total');
        
        // Check if user has sufficient balance
        if ($user->balance < $total) {
            return redirect()->route('cart.index')
                ->with('error', 'Insufficient balance. Please top up your account.');
        }
        
        DB::transaction(function () use ($user, $cartItems, $total) {
            // Create orders for each item
            foreach ($cartItems as $cartItem) {
                $listing = $cartItem->listing;
                
                // Create order
                $order = Order::create([
                    'buyer_id' => $user->id,
                    'seller_id' => $listing->user_id,
                    'listing_id' => $listing->id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                    'total' => $cartItem->total,
                    'status' => 'pending'
                ]);
                
                // Update listing status to sold
                $listing->update(['status' => 'sold']);
                
                // Transfer money from buyer to seller
                $user->decrement('balance', $cartItem->total);
                $listing->user->increment('balance', $cartItem->total);
            }
            
            // Clear cart
            $user->cartItems()->delete();
        });
        
        return redirect()->route('dashboard')
            ->with('success', 'Order placed successfully! Check your dashboard for order details.');
    }
    
    /**
     * Show checkout page
     */
    public function showCheckout()
    {
        $user = auth()->user();
        $cartItems = $user->cartItems()->with(['listing.game', 'listing.user'])->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }
        
        $total = $cartItems->sum('total');
        
        return view('checkout.index', compact('cartItems', 'total'));
    }
    
    /**
     * Show user's orders
     */
    public function orders()
    {
        $buyerOrders = auth()->user()->buyerOrders()
            ->with(['listing.game', 'seller'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        $sellerOrders = auth()->user()->sellerOrders()
            ->with(['listing.game', 'buyer'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('orders.index', compact('buyerOrders', 'sellerOrders'));
    }
}
