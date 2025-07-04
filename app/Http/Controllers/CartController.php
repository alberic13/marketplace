<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Listing;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display the cart contents
     */
    public function index()
    {
        $cartItems = auth()->user()->cartItems()
            ->with(['listing.game', 'listing.user'])
            ->get();

        $total = $cartItems->sum('total');

        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add item to cart
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'listing_id' => 'required|exists:listings,id'
            ]);

            $listing = Listing::findOrFail($request->listing_id);

            // Check if listing is available and not user's own listing
            if ($listing->status !== 'active') {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'This listing is no longer available.'
                    ], 400);
                }
                return back()->with('error', 'This listing is no longer available.');
            }

            if ($listing->user_id === auth()->id()) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You cannot add your own listing to cart.'
                    ], 400);
                }
                return back()->with('error', 'You cannot add your own listing to cart.');
            }

            // Check if item already in cart
            $existingCartItem = Cart::where('user_id', auth()->id())
                ->where('listing_id', $listing->id)
                ->first();

            if ($existingCartItem) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'This item is already in your cart.'
                    ], 400);
                }
                return back()->with('info', 'This item is already in your cart.');
            }

            // Add to cart
            Cart::create([
                'user_id' => auth()->id(),
                'listing_id' => $listing->id,
                'quantity' => 1,
                'price' => $listing->price
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Item added to cart successfully!',
                    'cart_count' => auth()->user()->cart_count
                ]);
            }

            return back()->with('success', 'Item added to cart successfully!');
            
        } catch (\Exception $e) {
            \Log::error('Cart store error: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while adding item to cart. Please try again.'
                ], 500);
            }
            
            return back()->with('error', 'An error occurred while adding item to cart. Please try again.');
        }
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, Cart $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        // Verify cart item belongs to current user
        if ($cartItem->user_id !== auth()->id()) {
            abort(403);
        }

        $cartItem->update([
            'quantity' => $request->quantity
        ]);

        return back()->with('success', 'Cart updated successfully!');
    }

    /**
     * Remove item from cart
     */
    public function destroy(Cart $cartItem)
    {
        // Verify cart item belongs to current user
        if ($cartItem->user_id !== auth()->id()) {
            abort(403);
        }

        $cartItem->delete();

        return back()->with('success', 'Item removed from cart.');
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        auth()->user()->cartItems()->delete();

        return back()->with('success', 'Cart cleared successfully!');
    }

    /**
     * Get cart count for AJAX
     */
    public function count()
    {
        return response()->json([
            'count' => auth()->user()->cart_count
        ]);
    }
}
