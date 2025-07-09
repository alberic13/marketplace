-- ===========================================
-- MARKETPLACE GAME PLATFORM DATABASE BACKUP
-- Created: July 2, 2025
-- ===========================================

-- Create Database
CREATE DATABASE IF NOT EXISTS `marketplace` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `marketplace`;

-- =====================================
-- USERS TABLE
-- =====================================
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `role` enum('buyer','seller','admin') NOT NULL DEFAULT 'buyer',
  `balance` decimal(15,2) NOT NULL DEFAULT 0.00,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================
-- CATEGORIES TABLE
-- =====================================
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================
-- GAMES TABLE
-- =====================================
CREATE TABLE `games` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `developer` varchar(255) DEFAULT NULL,
  `publisher` varchar(255) DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `platform` enum('PC','PlayStation','Xbox','Nintendo Switch','Mobile','Multiple') NOT NULL,
  `genre` varchar(255) DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `screenshots` json DEFAULT NULL,
  `base_price` decimal(10,2) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `games_slug_unique` (`slug`),
  KEY `games_category_id_foreign` (`category_id`),
  CONSTRAINT `games_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================
-- LISTINGS TABLE
-- =====================================
CREATE TABLE `listings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `game_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `type` enum('sell','buy') NOT NULL,
  `condition` enum('new','like_new','good','fair','digital') NOT NULL,
  `status` enum('active','sold','pending','inactive') NOT NULL DEFAULT 'active',
  `images` json DEFAULT NULL,
  `game_key` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `listings_user_id_foreign` (`user_id`),
  KEY `listings_game_id_foreign` (`game_id`),
  CONSTRAINT `listings_game_id_foreign` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE,
  CONSTRAINT `listings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================
-- ORDERS TABLE
-- =====================================
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_number` varchar(255) NOT NULL,
  `buyer_id` bigint(20) unsigned NOT NULL,
  `seller_id` bigint(20) unsigned NOT NULL,
  `listing_id` bigint(20) unsigned NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','paid','shipped','delivered','completed','cancelled','disputed') NOT NULL DEFAULT 'pending',
  `payment_method` enum('balance','credit_card','bank_transfer','paypal') NOT NULL,
  `shipping_address` text DEFAULT NULL,
  `tracking_number` varchar(255) DEFAULT NULL,
  `shipped_at` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`),
  KEY `orders_buyer_id_foreign` (`buyer_id`),
  KEY `orders_seller_id_foreign` (`seller_id`),
  KEY `orders_listing_id_foreign` (`listing_id`),
  CONSTRAINT `orders_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `orders_listing_id_foreign` FOREIGN KEY (`listing_id`) REFERENCES `listings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `orders_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================
-- REVIEWS TABLE
-- =====================================
CREATE TABLE `reviews` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `reviewer_id` bigint(20) unsigned NOT NULL,
  `reviewed_user_id` bigint(20) unsigned NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `type` enum('seller','buyer') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviews_order_id_foreign` (`order_id`),
  KEY `reviews_reviewer_id_foreign` (`reviewer_id`),
  KEY `reviews_reviewed_user_id_foreign` (`reviewed_user_id`),
  CONSTRAINT `reviews_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_reviewed_user_id_foreign` FOREIGN KEY (`reviewed_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_reviewer_id_foreign` FOREIGN KEY (`reviewer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================
-- FAVORITES TABLE
-- =====================================
CREATE TABLE `favorites` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `listing_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `favorites_user_id_listing_id_unique` (`user_id`,`listing_id`),
  KEY `favorites_listing_id_foreign` (`listing_id`),
  CONSTRAINT `favorites_listing_id_foreign` FOREIGN KEY (`listing_id`) REFERENCES `listings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================
-- MESSAGES TABLE
-- =====================================
CREATE TABLE `messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sender_id` bigint(20) unsigned NOT NULL,
  `receiver_id` bigint(20) unsigned NOT NULL,
  `listing_id` bigint(20) unsigned DEFAULT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `messages_sender_id_foreign` (`sender_id`),
  KEY `messages_receiver_id_foreign` (`receiver_id`),
  KEY `messages_listing_id_foreign` (`listing_id`),
  CONSTRAINT `messages_listing_id_foreign` FOREIGN KEY (`listing_id`) REFERENCES `listings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================
-- SAMPLE DATA INSERT
-- =====================================

-- Categories
INSERT INTO `categories` (`name`, `slug`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
('Action', 'action', 'Fast-paced games with combat and adventure', 1, NOW(), NOW()),
('Adventure', 'adventure', 'Story-driven games with exploration', 1, NOW(), NOW()),
('RPG', 'rpg', 'Role-playing games with character development', 1, NOW(), NOW()),
('Strategy', 'strategy', 'Games requiring tactical thinking and planning', 1, NOW(), NOW()),
('Sports', 'sports', 'Sports simulation and arcade games', 1, NOW(), NOW()),
('Racing', 'racing', 'Car, bike, and other vehicle racing games', 1, NOW(), NOW()),
('Shooter', 'shooter', 'First-person and third-person shooting games', 1, NOW(), NOW()),
('Simulation', 'simulation', 'Life and world simulation games', 1, NOW(), NOW()),
('Puzzle', 'puzzle', 'Brain-teasing and logic games', 1, NOW(), NOW()),
('Horror', 'horror', 'Scary and suspenseful games', 1, NOW(), NOW()),
('MMORPG', 'mmorpg', 'Massively multiplayer online role-playing games', 1, NOW(), NOW()),
('Indie', 'indie', 'Independent developer games', 1, NOW(), NOW());

-- Sample Users
INSERT INTO `users` (`name`, `email`, `password`, `role`, `balance`, `is_verified`, `created_at`, `updated_at`) VALUES
('Admin User', 'admin@marketplace.com', '$2y$12$i1XU6bKn2TGnsUECDmRya.wgCRq1BPNESpBhue5SwkFOq6oWd8cqu', 'admin', 1000.00, 1, NOW(), NOW()),
('Seller User', 'seller@marketplace.com', '$2y$12$i1XU6bKn2TGnsUECDmRya.wgCRq1BPNESpBhue5SwkFOq6oWd8cqu', 'seller', 500.00, 1, NOW(), NOW()),
('Buyer User', 'buyer@marketplace.com', '$2y$12$i1XU6bKn2TGnsUECDmRya.wgCRq1BPNESpBhue5SwkFOq6oWd8cqu', 'buyer', 300.00, 1, NOW(), NOW());

-- Sample Games
INSERT INTO `games` (`category_id`, `title`, `slug`, `description`, `developer`, `publisher`, `release_date`, `platform`, `genre`, `base_price`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Cyberpunk 2077', 'cyberpunk-2077', 'An open-world, action-adventure story set in Night City.', 'CD Projekt RED', 'CD Projekt', '2020-12-10', 'Multiple', 'Action RPG', 59.99, 1, NOW(), NOW()),
(3, 'The Witcher 3: Wild Hunt', 'the-witcher-3-wild-hunt', 'A story-driven open world RPG set in a visually stunning fantasy universe.', 'CD Projekt RED', 'CD Projekt', '2015-05-19', 'Multiple', 'Action RPG', 39.99, 1, NOW(), NOW()),
(7, 'Call of Duty: Modern Warfare', 'call-of-duty-modern-warfare', 'The stakes have never been higher as players take on the role of lethal Tier One operators.', 'Infinity Ward', 'Activision', '2019-10-25', 'Multiple', 'First-Person Shooter', 59.99, 1, NOW(), NOW()),
(4, 'Age of Empires IV', 'age-of-empires-iv', 'Real-time strategy game featuring both familiar and innovative new ways to expand your empire.', 'Relic Entertainment', 'Xbox Game Studios', '2021-10-28', 'PC', 'Real-Time Strategy', 59.99, 1, NOW(), NOW()),
(5, 'FIFA 24', 'fifa-24', 'The world''s game featuring HyperMotionV technology for authentic football experience.', 'EA Sports', 'Electronic Arts', '2023-09-29', 'Multiple', 'Sports Simulation', 69.99, 1, NOW(), NOW()),
(12, 'Hollow Knight', 'hollow-knight', 'A challenging 2D action-adventure through a vast ruined kingdom of insects and heroes.', 'Team Cherry', 'Team Cherry', '2017-02-24', 'Multiple', 'Metroidvania', 14.99, 1, NOW(), NOW());

-- =====================================
-- INDEXES FOR PERFORMANCE
-- =====================================
CREATE INDEX idx_users_role ON users(role);
CREATE INDEX idx_users_is_verified ON users(is_verified);
CREATE INDEX idx_categories_is_active ON categories(is_active);
CREATE INDEX idx_games_platform ON games(platform);
CREATE INDEX idx_games_is_active ON games(is_active);
CREATE INDEX idx_listings_type ON listings(type);
CREATE INDEX idx_listings_status ON listings(status);
CREATE INDEX idx_listings_condition ON listings(condition);
CREATE INDEX idx_orders_status ON orders(status);
CREATE INDEX idx_orders_created_at ON orders(created_at);
CREATE INDEX idx_reviews_rating ON reviews(rating);
CREATE INDEX idx_messages_is_read ON messages(is_read);
CREATE INDEX idx_messages_created_at ON messages(created_at);

-- =====================================
-- END OF DATABASE BACKUP
-- =====================================
