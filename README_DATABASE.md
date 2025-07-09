# Marketplace Game Platform

Platform marketplace sederhana untuk jual beli game dengan sistem yang lengkap untuk buyer, seller, dan admin.

## 📋 Fitur Utama

### Untuk User (Buyer/Seller)
- ✅ Registrasi dan Login
- ✅ Profil User dengan role (buyer/seller/admin)
- ✅ Sistem Balance/Wallet
- ✅ Verifikasi User

### Untuk Listing Game
- ✅ Browse game berdasarkan kategori
- ✅ Listing game untuk dijual/dibeli
- ✅ Kondisi game (new, like_new, good, fair, digital)
- ✅ Upload multiple images
- ✅ Game key untuk digital games

### Untuk Transaksi
- ✅ Sistem order yang lengkap
- ✅ Multiple payment methods
- ✅ Tracking pengiriman
- ✅ Fee transaksi

### Fitur Tambahan
- ✅ Review system untuk buyer/seller
- ✅ Favorites/Wishlist
- ✅ Messaging system
- ✅ Search dan filter advanced

## 🗃️ Struktur Database

Database ini terdiri dari 8 tabel utama:

1. **users** - Data user dengan role dan balance
2. **categories** - Kategori game (Action, RPG, Strategy, dll)
3. **games** - Katalog game dengan detail lengkap
4. **listings** - Listing jual/beli dari user
5. **orders** - Transaksi pembelian
6. **reviews** - Review untuk seller/buyer
7. **favorites** - Wishlist user
8. **messages** - System chat antar user

## 📊 Data Sample

Database sudah diisi dengan data sample:

### Categories (12 kategori):
- Action, Adventure, RPG, Strategy
- Sports, Racing, Shooter, Simulation
- Puzzle, Horror, MMORPG, Indie

### Games (6 games):
- Cyberpunk 2077 (Action)
- The Witcher 3: Wild Hunt (RPG)
- Call of Duty: Modern Warfare (Shooter)
- Age of Empires IV (Strategy)
- FIFA 24 (Sports)
- Hollow Knight (Indie)

### Users (3 users):
- Admin: test@example.com
- Seller: seller@example.com
- Buyer: buyer@example.com

## 🚀 Setup dan Instalasi

1. **Clone atau setup project Laravel**
2. **Konfigurasi database di .env**
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=marketplace
   DB_USERNAME=root
   DB_PASSWORD=
   ```

3. **Jalankan migration dan seeder**
   ```bash
   php artisan migrate:fresh --seed
   ```

4. **Generate application key**
   ```bash
   php artisan key:generate
   ```

5. **Jalankan server**
   ```bash
   php artisan serve
   ```

## 📁 File Database

- `DATABASE_SCHEMA.md` - Dokumentasi lengkap schema database
- `ERD_DIAGRAM.md` - Entity Relationship Diagram
- `database/migrations/` - File migration untuk semua tabel
- `database/seeders/` - File seeder untuk data sample

## 🎯 Next Steps - Fitur yang Bisa Dikembangkan

### Frontend Development
- [ ] UI/UX design dengan React/Inertia.js
- [ ] Dashboard untuk user, seller, admin
- [ ] Game catalog dengan search & filter
- [ ] Shopping cart functionality
- [ ] Real-time messaging

### Backend Development
- [ ] API endpoints untuk mobile app
- [ ] Payment gateway integration
- [ ] Email notifications
- [ ] File upload handling
- [ ] Advanced search with Elasticsearch

### Security & Performance
- [ ] Input validation dan sanitization
- [ ] Rate limiting
- [ ] Image optimization
- [ ] Database indexing
- [ ] Caching strategy

### Admin Features
- [ ] Admin panel untuk manage users
- [ ] Moderation system untuk listings
- [ ] Analytics dan reporting
- [ ] Dispute resolution system

## 🔐 Keamanan

- Password hashing dengan bcrypt
- CSRF protection
- SQL injection protection dengan Eloquent ORM
- Input validation
- Role-based access control

## 📈 Scalability

Database ini dirancang untuk scalable dengan:
- Proper indexing pada foreign keys
- Normalized table structure
- JSON fields untuk flexible data
- Soft deletes ready
- Optimized queries dengan Eloquent relationships

## 🤝 Contributing

1. Fork repository
2. Create feature branch
3. Commit changes
4. Push to branch
5. Create Pull Request

## 📝 License

This project is open source and available under the [MIT License](LICENSE).

---

**Happy Coding! 🎮🚀**
