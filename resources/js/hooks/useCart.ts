import { useCallback, useState } from 'react';
import { router } from '@inertiajs/react';
import { CartItem, CartResponse, CartError, CartUpdateRequest } from '@/types/cart';

interface UseCartReturn {
    cartItems: CartItem[];
    total: number;
    loading: boolean;
    error: CartError | null;
    addToCart: (listingId: number) => Promise<void>;
    updateQuantity: (cartItemId: number, data: CartUpdateRequest) => Promise<void>;
    removeFromCart: (cartItemId: number) => Promise<void>;
    clearCart: () => Promise<void>;
    refreshCart: () => Promise<void>;
}

export function useCart(initialCart: CartItem[] = [], initialTotal: number = 0): UseCartReturn {
    const [cartItems, setCartItems] = useState<CartItem[]>(initialCart);
    const [total, setTotal] = useState<number>(initialTotal);
    const [loading, setLoading] = useState<boolean>(false);
    const [error, setError] = useState<CartError | null>(null);

    const refreshCart = useCallback(async () => {
        setLoading(true);
        try {
            const response = await router.reload({ 
                only: ['cartItems', 'total'],
                preserveScroll: true
            });
            setCartItems(response.props.cartItems);
            setTotal(response.props.total);
            setError(null);
        } catch (err) {
            setError({
                message: 'Failed to refresh cart'
            });
        } finally {
            setLoading(false);
        }
    }, []);

    const addToCart = useCallback(async (listingId: number) => {
        setLoading(true);
        try {
            await router.post('/cart', { listing_id: listingId }, {
                preserveScroll: true,
                onSuccess: () => refreshCart()
            });
        } catch (err) {
            setError({
                message: 'Failed to add item to cart'
            });
        } finally {
            setLoading(false);
        }
    }, [refreshCart]);

    const updateQuantity = useCallback(async (cartItemId: number, data: CartUpdateRequest) => {
        setLoading(true);
        try {
            await router.put(`/cart/${cartItemId}`, data, {
                preserveScroll: true,
                onSuccess: () => refreshCart()
            });
        } catch (err) {
            setError({
                message: 'Failed to update quantity'
            });
        } finally {
            setLoading(false);
        }
    }, [refreshCart]);

    const removeFromCart = useCallback(async (cartItemId: number) => {
        setLoading(true);
        try {
            await router.delete(`/cart/${cartItemId}`, {
                preserveScroll: true,
                onSuccess: () => refreshCart()
            });
        } catch (err) {
            setError({
                message: 'Failed to remove item from cart'
            });
        } finally {
            setLoading(false);
        }
    }, [refreshCart]);

    const clearCart = useCallback(async () => {
        setLoading(true);
        try {
            await router.delete('/cart/clear', {
                preserveScroll: true,
                onSuccess: () => refreshCart()
            });
        } catch (err) {
            setError({
                message: 'Failed to clear cart'
            });
        } finally {
            setLoading(false);
        }
    }, [refreshCart]);

    return {
        cartItems,
        total,
        loading,
        error,
        addToCart,
        updateQuantity,
        removeFromCart,
        clearCart,
        refreshCart
    };
}
