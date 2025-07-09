# Database Schema - Marketplace Game Platform

Database ini dirancang untuk platform marketplace jual beli game sederhana dengan fitur-fitur lengkap untuk user, penjual, dan pembeli.

## Struktur Database

### 1. Users Table
```sql
- id (Primary Key)
- name (string)
- email (string, unique)
- email_verified_at (timestamp, nullable)
- password (string)
- phone (string, nullable)
- address (text, nullable)
- avatar (string, nullable)
- role (enum: 'buyer', 'seller', 'admin', default: 'buyer')
- balance (decimal 15,2, default: 0)
- is_verified (boolean, default: false)
- remember_token
- created_at, updated_at
```

### 2. Categories Table
```sql
- id (Primary Key)
- name (string)
- slug (string, unique)
- description (text, nullable)
- image (string, nullable)
- is_active (boolean, default: true)
- created_at, updated_at
```

### 3. Games Table
```sql
- id (Primary Key)
- category_id (Foreign Key -> categories.id)
- title (string)
- slug (string, unique)
- description (text)
- developer (string, nullable)
- publisher (string, nullable)
- release_date (date, nullable)
- platform (enum: 'PC', 'PlayStation', 'Xbox', 'Nintendo Switch', 'Mobile', 'Multiple')
- genre (string, nullable)
- cover_image (string, nullable)
- screenshots (json, nullable)
- base_price (decimal 10,2, nullable)
- is_active (boolean, default: true)
- created_at, updated_at
```

### 4. Listings Table
```sql
- id (Primary Key)
- user_id (Foreign Key -> users.id)
- game_id (Foreign Key -> games.id)
- title (string)
- description (text)
- price (decimal 10,2)
- type (enum: 'sell', 'buy')
- condition (enum: 'new', 'like_new', 'good', 'fair', 'digital')
- status (enum: 'active', 'sold', 'pending', 'inactive', default: 'active')
- images (json, nullable)
- game_key (string, nullable) // untuk digital games
- notes (text, nullable)
- views (integer, default: 0)
- created_at, updated_at
```

### 5. Orders Table
```sql
- id (Primary Key)
- order_number (string, unique)
- buyer_id (Foreign Key -> users.id)
- seller_id (Foreign Key -> users.id)
- listing_id (Foreign Key -> listings.id)
- amount (decimal 10,2)
- fee (decimal 10,2, default: 0)
- total_amount (decimal 10,2)
- status (enum: 'pending', 'paid', 'shipped', 'delivered', 'completed', 'cancelled', 'disputed', default: 'pending')
- payment_method (enum: 'balance', 'credit_card', 'bank_transfer', 'paypal')
- shipping_address (text, nullable)
- tracking_number (string, nullable)
- shipped_at (timestamp, nullable)
- delivered_at (timestamp, nullable)
- notes (text, nullable)
- created_at, updated_at
```

### 6. Reviews Table
```sql
- id (Primary Key)
- order_id (Foreign Key -> orders.id)
- reviewer_id (Foreign Key -> users.id)
- reviewed_user_id (Foreign Key -> users.id)
- rating (integer, min: 1, max: 5)
- comment (text, nullable)
- type (enum: 'seller', 'buyer') // review untuk seller atau buyer
- created_at, updated_at
```

### 7. Favorites Table (Wishlist)
```sql
- id (Primary Key)
- user_id (Foreign Key -> users.id)
- listing_id (Foreign Key -> listings.id)
- created_at, updated_at
- UNIQUE(user_id, listing_id)
```

### 8. Messages Table
```sql
- id (Primary Key)
- sender_id (Foreign Key -> users.id)
- receiver_id (Foreign Key -> users.id)
- listing_id (Foreign Key -> listings.id, nullable)
- message (text)
- is_read (boolean, default: false)
- created_at, updated_at
```

## Relasi Database

### User Relations:
- User dapat memiliki banyak Listings (seller)
- User dapat memiliki banyak Orders sebagai buyer
- User dapat memiliki banyak Orders sebagai seller
- User dapat memiliki banyak Reviews sebagai reviewer
- User dapat memiliki banyak Reviews sebagai yang direview
- User dapat memiliki banyak Favorites
- User dapat mengirim dan menerima banyak Messages

### Category Relations:
- Category dapat memiliki banyak Games

### Game Relations:
- Game belongs to Category
- Game dapat memiliki banyak Listings

### Listing Relations:
- Listing belongs to User (seller)
- Listing belongs to Game
- Listing dapat memiliki banyak Orders
- Listing dapat memiliki banyak Favorites
- Listing dapat memiliki banyak Messages

### Order Relations:
- Order belongs to User (buyer)
- Order belongs to User (seller)
- Order belongs to Listing
- Order dapat memiliki banyak Reviews

### Review Relations:
- Review belongs to Order
- Review belongs to User (reviewer)
- Review belongs to User (reviewed_user)

### Favorite Relations:
- Favorite belongs to User
- Favorite belongs to Listing

### Message Relations:
- Message belongs to User (sender)
- Message belongs to User (receiver)
- Message belongs to Listing (optional)

## Sample Data yang Sudah Diisi

### Categories:
- Action, Adventure, RPG, Strategy, Sports, Racing, Shooter, Simulation, Puzzle, Horror, MMORPG, Indie

### Games:
- Cyberpunk 2077 (Action)
- The Witcher 3: Wild Hunt (RPG)
- Call of Duty: Modern Warfare (Shooter)
- Age of Empires IV (Strategy)
- FIFA 24 (Sports)
- Hollow Knight (Indie)

### Users:
- Admin User (test@example.com)
- Seller User (seller@example.com)
- Buyer User (buyer@example.com)

## Fitur yang Dapat Dibangun

1. **User Management**: Registrasi, login, profil user, verifikasi
2. **Game Catalog**: Browse games by category, search, filter
3. **Listing Management**: Create, edit, delete listings (sell/buy)
4. **Order Processing**: Order flow, payment, tracking, completion
5. **Review System**: Rating dan review untuk seller/buyer
6. **Favorites/Wishlist**: Simpan listings favorit
7. **Messaging System**: Chat antar user untuk negosiasi
8. **Search & Filter**: Pencarian advanced berdasarkan berbagai kriteria
9. **Admin Panel**: Manage users, games, categories, orders
10. **Payment System**: Integrate dengan payment gateway
