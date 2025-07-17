export interface CartItem {
    id: number;
    quantity: number;
    price: number;
    total: number;
    listing: {
        id: number;
        title: string;
        type: 'sell' | 'trade' | 'both';
        condition: 'new' | 'used' | 'refurbished';
        price: number;
        image_url: string | null;
        game: {
            title: string;
        };
        user: {
            name: string;
        };
    };
}

export interface CartResponse {
    cartItems: CartItem[];
    total: number;
    count?: number;
    message?: string;
}

export interface CartCountResponse {
    count: number;
}

export interface CartError {
    message: string;
    errors?: Record<string, string[]>;
}

export interface CartUpdateRequest {
    quantity: number;
}
