# Sharia Stock Screener API

REST API berbasis Laravel untuk melakukan screening saham syariah berdasarkan rasio utang perusahaan.

---

## Requirement

- PHP >= 8.2
- Composer
- MySQL
- Laravel 11

---

## Instalasi

### 1. Clone repository

```bash
git clone https://github.com/username/nama-repo.git
cd nama-repo
```

### 2. Install dependency

```bash
composer install
```

### 3. create new project in laragon folder

```bash
cd C:\laragon\www\stock-app
```

### 4. Konfigurasi database

Buka file `.env` dan sesuaikan dengan konfigurasi database lokal kamu:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dbstockmarket
DB_USERNAME=root
DB_PASSWORD=
```

> Pastikan database sudah dibuat terlebih dahulu di MySQL sebelum menjalankan migrasi.

### 5. Aktifkan API routing (Laravel 11)

```bash
php artisan install:api
```

### 6. Jalankan migrasi dan seeder

```bash
php artisan migrate
php artisan db:seed
```

### 7. Jalankan server

```bash
php artisan serve
```

---

## Penggunaan API

### GET /api/sharia-stocks

Mengembalikan daftar perusahaan yang lolos screening syariah, yaitu perusahaan dengan rasio utang **(total_debt / total_assets) di bawah 45%**.

**Request:**

```
GET http://127.0.0.1:8000/api/sharia-stocks
```

**Response:**

```json
{
  "data": [
    {
      "ticker": "BBCA",
      "company_name": "Bank Central Asia Tbk",
      "total_assets": 1408000000000,
      "total_debt": 450000000000,
      "debt_ratio": 31.96,
      "is_sharia": true
    },
    {
      "ticker": "TLKM",
      "company_name": "Telkom Indonesia Tbk",
      "total_assets": 275000000000,
      "total_debt": 95000000000,
      "debt_ratio": 34.55,
      "is_sharia": true
    },
    {
      "ticker": "UNVR",
      "company_name": "Unilever Indonesia Tbk",
      "total_assets": 20000000000,
      "total_debt": 7500000000,
      "debt_ratio": 37.5,
      "is_sharia": false
    },
    {
      "ticker": "ASII",
      "company_name": "Astra International Tbk",
      "total_assets": 320000000000,
      "total_debt": 130000000000,
      "debt_ratio": 40.63,
      "is_sharia": true
    },
    {
      "ticker": "ICBP",
      "company_name": "Indofood CBP Sukses Makmur Tbk",
      "total_assets": 55000000000,
      "total_debt": 20000000000,
      "debt_ratio": 36.36,
      "is_sharia": true
    }
  ]
}
```

---

## Struktur Project

```
app/
├── Http/
│   ├── Controllers/Api/
│   │   └── StockController.php
│   └── Resources/
│       └── CompanyResource.php
└── Models/
    └── Company.php
    └── User.php

database/
├── migrations/
│   └── 0001_01_01_000000_create_users_table.php
    └──0001_01_01_000001_create_cache_table.php
    └──0001_01_01_000002_create_jobs_table.php
    └──2026_05_05_234258_create_companies_table.php
    └──2026_05_06_002652_create_personal_access_tokens_table.php
└── seeders/
    ├── CompanySeeder.php
    └── DatabaseSeeder.php

routes/
└── api.php
```

---

## Logika Screening

Filtering dilakukan di level database menggunakan query:

```sql
WHERE (total_debt / total_assets) < 0.45
```

Implementasi di Model menggunakan Laravel Query Scope:

```php
public function scopePassesShariaScreening($query)
{
    return $query->whereRaw('total_assets != 0 AND (total_debt / total_assets) < 0.45');
}
```
