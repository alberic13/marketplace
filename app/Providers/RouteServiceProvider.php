<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Models\Cart;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        parent::boot();

        // Only bind cart items that belong to the current user
        Route::bind('cart', function ($value) {
            $cart = \App\Models\Cart::where('id', $value)->where('user_id', auth()->id())->first();
            \Log::info('Cart binding', [
                'cart_id' => $value,
                'user_id' => auth()->id(),
                'cart_found' => $cart ? true : false,
            ]);
            if (!$cart) abort(404);
            return $cart;
        });
    }
} 