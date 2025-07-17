export interface Paginated<T> {
  data: T[];
  meta: {
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    links: {
      url: string | null;
      label: string;
      active: boolean;
    }[];
  };
}

export interface Category {
  id: number;
  name: string;
  slug: string;
  description: string;
  icon: string;
  image?: string;
  games_count?: number;
  is_active: boolean;
}

export interface Game {
  id: number;
  title: string;
  description: string;
  platform: string;
  base_price: number;
  cover_image: string | null;
  category: Category;
  is_active: boolean;
  is_new: boolean;
  is_popular: boolean;
  developer: string | null;
  slug: string;
  listings_count?: number;
}

export interface Listing {
  id: number;
  title: string;
  description: string;
  price: number;
  condition: string;
  type: 'sell' | 'buy';
  status: 'active' | 'sold' | 'expired';
  game: Game;
  user: {
    id: number;
    name: string;
  };
}
