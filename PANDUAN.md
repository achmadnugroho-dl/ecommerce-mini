# 📦 ecommerce-mini — Panduan Setup

## 1. Import Database
- Buka phpMyAdmin
- Import file `database.sql`
- Database bernama **ecommerce_mini** akan dibuat otomatis

## 2. Letakkan Folder
- Salin folder `ecommerce-mini` ke `htdocs` (XAMPP) atau `www` (WAMP/Laragon)
- Akses via: `http://localhost/ecommerce-mini`

## 3. Akun Admin
- **Username:** admin
- **Password:** admin123
- Halaman admin: `http://localhost/ecommerce-mini/admin/dashboard.php`

## 4. Fitur yang Tersedia
- ✅ Login & Register pengguna
- ✅ Halaman produk dengan deskripsi
- ✅ Keranjang belanja & checkout
- ✅ Admin: tambah produk (nama, deskripsi, harga, gambar)
- ✅ Admin: hapus produk
- ✅ Admin: kelola status pesanan

## 5. Struktur Folder
```
ecommerce-mini/
├── admin/
│   ├── dashboard.php      ← Daftar & hapus produk
│   ├── add_product.php    ← Tambah produk + deskripsi
│   ├── delete_product.php ← Proses hapus produk
│   ├── orders.php         ← Kelola pesanan
│   └── sidebar.php
├── auth/
│   ├── login.php
│   ├── register.php
│   └── logout.php
├── config/
│   ├── db.php             ← Koneksi database (ecommerce_mini)
│   ├── admin_guard.php
│   └── user_guard.php
├── assets/
│   ├── css/style.css
│   └── js/script.js
├── uploads/               ← Gambar produk
├── index.php              ← Halaman utama toko
├── cart.php
├── checkout.php
└── database.sql
```
