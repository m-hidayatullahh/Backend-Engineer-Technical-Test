# Inventory System API Documentation

## 📌 Pendahuluan
API ini digunakan untuk mengelola permintaan barang di perusahaan.  
Dibangun menggunakan **Laravel 12 + MySQL + Vue.js**.

---

## 🚀 Instalasi
1. Clone repositori:
   ```bash
   https://github.com/m-hidayatullahh/Backend-Engineer-Technical-Test
   cd Backend-Engineer-Technical-Test

2. Install dependencies:
```bash
composer install
npm install
```

3. Konfigurasi .env
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventory
DB_USERNAME=root
DB_PASSWORD= your password
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
##### Laravel 12 (Backend)
##### Vue.js 3 (Frontend)
##### MySQL (Database)
##### Tailwind CSS (Styling)
##### Vite (Bundler)

