import React from 'react';
import { Head, Link, usePage } from '@inertiajs/react';
import Layout from '@/layouts/app-layout';
import { useCart } from '@/hooks/useCart';
import { CartItem } from '@/types/cart';

export default function CartIndex() {
    const { props } = usePage<{
        cartItems: CartItem[];
        total: number;
        flash: {
            success?: string;
            error?: string;
            info?: string;
        };
    }>();
    const { flash } = props;
    
    const {
        cartItems,
        total,
        loading,
        error,
        updateQuantity,
        removeFromCart,
        clearCart,
        refreshCart
    } = useCart(props.cartItems, props.total);

    // Handle quantity update
    const handleQuantityChange = (itemId: number, quantity: number) => {
        updateQuantity(itemId, { quantity });
    };

    return (
        <Layout>
            <Head title="Shopping Cart" />
            <div className="container mx-auto px-6 py-8">
                {/* Header */}
                <div className="flex items-center justify-between mb-8">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-800">Shopping Cart</h1>
                        <p className="text-gray-600">Review your items before checkout</p>
                    </div>
                    <Link href={route('listings.index')} className="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        Continue Shopping
                    </Link>
                </div>

                {/* Success/Error Messages */}
                {flash.success && (
                    <div className="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                        <div className="flex">
                            <span className="text-green-400">✅</span>
                            <p className="ml-3 text-sm text-green-800">{flash.success}</p>
                        </div>
                    </div>
                )}

                {flash.error && (
                    <div className="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                        <div className="flex">
                            <span className="text-red-400">⚠️</span>
                            <p className="ml-3 text-sm text-red-800">{flash.error}</p>
                        </div>
                    </div>
                )}

                {flash.info && (
                    <div className="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div className="flex">
                            <span className="text-blue-400">ℹ️</span>
                            <p className="ml-3 text-sm text-blue-800">{flash.info}</p>
                        </div>
                    </div>
                )}

                {cartItems.length > 0 ? (
                    <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        {/* Cart Items */}
                        <div className="lg:col-span-2">
                            <div className="bg-white rounded-lg shadow-md">
                                <div className="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                                    <h3 className="text-lg font-medium text-gray-900">
                                        Cart Items ({cartItems.length})
                                    </h3>
                                    <button 
                                        onClick={clearCart}
                                        className="text-red-600 hover:text-red-800 text-sm clear-cart"
                                        disabled={loading}
                                    >
                                        {loading ? 'Clearing...' : 'Clear All'}
                                    </button>
                                </div>
                                
                                <div className="divide-y divide-gray-200">
                                    {cartItems.map((item) => (
                                        <div key={item.id} className="p-6 cart-item">
                                            <div className="flex items-center space-x-4">
                                                {/* Item Image */}
                                                <div className="flex-shrink-0">
                                                    <div className="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                                        {item.listing.image_url ? (
                                                            <img src={item.listing.image_url} alt={item.listing.title} 
                                                                className="w-20 h-20 object-cover rounded-lg" />
                                                        ) : (
                                                            <span className="text-gray-400">🎮</span>
                                                        )}
                                                    </div>
                                                </div>

                                                {/* Item Details */}
                                                <div className="flex-1 min-w-0">
                                                    <div className="flex items-start justify-between">
                                                        <div>
                                                            <h4 className="text-sm font-medium text-gray-900 truncate">
                                                                {item.listing.title}
                                                            </h4>
                                                            <p className="text-sm text-gray-500">{item.listing.game.title}</p>
                                                            <p className="text-xs text-gray-400">
                                                                Sold by {item.listing.user.name}
                                                            </p>
                                                            <div className="mt-1">
                                                                <span className={`inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                                                    ${item.listing.type === 'sell' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800'}`}>
                                                                    {item.listing.type.charAt(0).toUpperCase() + item.listing.type.slice(1)}
                                                                </span>
                                                                <span className="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 ml-1">
                                                                    {item.listing.condition.charAt(0).toUpperCase() + item.listing.condition.slice(1)}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        
                                                        {/* Price and Actions */}
                                                        <div className="text-right">
                                                            <p className="text-lg font-medium text-green-600 price-display">
                                                                ${item.price.toFixed(2)}
                                                            </p>
                                                            {item.listing.price !== item.price && (
                                                                <p className="text-sm text-gray-500 line-through">
                                                                    ${item.listing.price.toFixed(2)}
                                                                </p>
                                                            )}
                                                        </div>
                                                    </div>

                                                    {/* Quantity and Remove */}
                                                    <div className="mt-4 flex items-center justify-between">
                                                        <div className="flex items-center space-x-3">
                                                            <label className="text-sm text-gray-600">Quantity:</label>
                                                            <select 
                                                                value={item.quantity}
                                                                onChange={(e) => handleQuantityChange(item.id, parseInt(e.target.value))}
                                                                className="border border-gray-300 rounded px-2 py-1 text-sm quantity-input"
                                                                disabled={loading}
                                                            >
                                                                {[...Array(10).keys()].map(i => (
                                                                    <option key={i+1} value={i+1}>
                                                                        {i+1}
                                                                    </option>
                                                                ))}
                                                            </select>
                                                        </div>

                                                        <div className="flex items-center space-x-4">
                                                            <span className="text-sm font-medium text-gray-900 price-display">
                                                                Total: ${item.total.toFixed(2)}
                                                            </span>
                                                            <button 
                                                                onClick={() => removeFromCart(item.id)}
                                                                className="text-red-600 hover:text-red-800 text-sm remove-item"
                                                                disabled={loading}
                                                            >
                                                                {loading ? 'Removing...' : 'Remove'}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        </div>

                        {/* Cart Summary */}
                        <div className="lg:col-span-1">
                            <div className="bg-white rounded-lg shadow-md p-6">
                                <h3 className="text-lg font-medium text-gray-900 mb-4">Order Summary</h3>
                                
                                <div className="space-y-3">
                                    <div className="flex justify-between text-sm">
                                        <span className="text-gray-600">Items ({cartItems.length})</span>
                                        <span>${total.toFixed(2)}</span>
                                    </div>
                                    <div className="flex justify-between text-sm">
                                        <span className="text-gray-600">Shipping</span>
                                        <span className="text-green-600">Free</span>
                                    </div>
                                    <div className="border-t pt-3">
                                        <div className="flex justify-between text-lg font-medium">
                                            <span>Total</span>
                                            <span className="text-green-600">${total.toFixed(2)}</span>
                                        </div>
                                    </div>
                                </div>

                                <div className="mt-6 space-y-3">
                                    <button className="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg font-medium">
                                        Proceed to Checkout
                                    </button>
                                    <Link href={route('listings.index')} 
                                        className="block w-full text-center border border-gray-300 hover:bg-gray-50 text-gray-700 py-3 px-4 rounded-lg">
                                        Continue Shopping
                                    </Link>
                                </div>

                                {/* Security Notice */}
                                <div className="mt-6 p-4 bg-gray-50 rounded-lg">
                                    <div className="flex items-center">
                                        <span className="text-green-600 text-sm">🔒</span>
                                        <span className="ml-2 text-sm text-gray-600">
                                            Secure checkout with buyer protection
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                ) : (
                    /* Empty Cart */
                    <div className="text-center py-16">
                        <div className="text-gray-400 text-6xl mb-4">🛒</div>
                        <h3 className="text-xl font-semibold text-gray-600 mb-2">Your cart is empty</h3>
                        <p className="text-gray-500 mb-6">Add some games to your cart to get started!</p>
                        <Link href={route('listings.index')} 
                            className="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg inline-block">
                            Browse Listings
                        </Link>
                    </div>
                )}
            </div>
        </Layout>
    );
}
