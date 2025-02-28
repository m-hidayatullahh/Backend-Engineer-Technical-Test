# Inventory System API Documentation

## 📌 Pendahuluan
API ini digunakan untuk mengelola permintaan barang di perusahaan.  
Dibangun menggunakan **Laravel 12 + MySQL + Vue.js**.

---

## 🚀 Instalasi
1. Clone repositori:
   ```bash
   git clone https://github.com/username/inventory-system.git
   cd inventory-system

2. Install dependencies:
```bash
composer install
npm install
```

3. Konfigurasi .env
```
DB_DATABASE=inventory
DB_USERNAME=root
DB_PASSWORD=
```

4.Jalankan migration dan seeder:
```
php artisan migrate --seed
```

5.Jalankan server
```
php artisan serve
npm run dev
```

## 🔥 API Endpoints
## 📌 1. Users
GET /api/users → Mendapatkan daftar pengguna.

## 📌 2. Items
GET /api/items → Mendapatkan daftar barang.

## 📌 3. Requests
GET /api/requests → Melihat semua permintaan barang.

POST /api/requests → Membuat permintaan barang.

#### Contoh Body untuk POST /api/requests
```json
{
    "user_id": 1,
    "items": [
        {
            "item_id": 2,
            "quantity": 5
        }
    ]
}
```

## 🛠 Teknologi yang Digunakan
##### Laravel 11 (Backend)
##### Vue.js (Frontend)
##### MySQL (Database)
##### Tailwind CSS (Styling)
##### Vite (Bundler)

