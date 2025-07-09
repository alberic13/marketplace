```mermaid
erDiagram
    USERS {
        id PK
        name string
        email string
        password string
        phone string
        address text
        avatar string
        role enum
        balance decimal
        is_verified boolean
        created_at timestamp
        updated_at timestamp
    }
    
    CATEGORIES {
        id PK
        name string
        slug string
        description text
        image string
        is_active boolean
        created_at timestamp
        updated_at timestamp
    }
    
    GAMES {
        id PK
        category_id FK
        title string
        slug string
        description text
        developer string
        publisher string
        release_date date
        platform enum
        genre string
        cover_image string
        screenshots json
        base_price decimal
        is_active boolean
        created_at timestamp
        updated_at timestamp
    }
    
    LISTINGS {
        id PK
        user_id FK
        game_id FK
        title string
        description text
        price decimal
        type enum
        condition enum
        status enum
        images json
        game_key string
        notes text
        views integer
        created_at timestamp
        updated_at timestamp
    }
    
    ORDERS {
        id PK
        order_number string
        buyer_id FK
        seller_id FK
        listing_id FK
        amount decimal
        fee decimal
        total_amount decimal
        status enum
        payment_method enum
        shipping_address text
        tracking_number string
        shipped_at timestamp
        delivered_at timestamp
        notes text
        created_at timestamp
        updated_at timestamp
    }
    
    REVIEWS {
        id PK
        order_id FK
        reviewer_id FK
        reviewed_user_id FK
        rating integer
        comment text
        type enum
        created_at timestamp
        updated_at timestamp
    }
    
    FAVORITES {
        id PK
        user_id FK
        listing_id FK
        created_at timestamp
        updated_at timestamp
    }
    
    MESSAGES {
        id PK
        sender_id FK
        receiver_id FK
        listing_id FK
        message text
        is_read boolean
        created_at timestamp
        updated_at timestamp
    }

    %% Relationships
    USERS ||--o{ LISTINGS : "sells"
    USERS ||--o{ ORDERS : "buys"
    USERS ||--o{ ORDERS : "sells"
    USERS ||--o{ REVIEWS : "writes"
    USERS ||--o{ REVIEWS : "receives"
    USERS ||--o{ FAVORITES : "has"
    USERS ||--o{ MESSAGES : "sends"
    USERS ||--o{ MESSAGES : "receives"
    
    CATEGORIES ||--o{ GAMES : "contains"
    
    GAMES ||--o{ LISTINGS : "listed"
    
    LISTINGS ||--o{ ORDERS : "creates"
    LISTINGS ||--o{ FAVORITES : "favorited"
    LISTINGS ||--o{ MESSAGES : "discusses"
    
    ORDERS ||--o{ REVIEWS : "generates"
```
