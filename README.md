# Sistem Pengajuan Transaksi

Sistem ini digunakan untuk mengelola pengajuan transaksi secara terstruktur dengan alur approval multi-level, mulai dari Staff, SPV, Manager, Direktur, hingga Finance.

## 1. Cara Instalasi

Pastikan perangkat sudah terinstall:
- PHP 8.2+
- Composer
- Node.js dan npm
- Database MySQL

Langkah instalasi:

```bash
git clone <repo-url>
cd sistem_pengajuan_transaksi
composer install
cp .env.example .env
php artisan key:generate
```

Setelah itu, sesuaikan konfigurasi database di file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem_pengajuan_transaksi
DB_USERNAME=root
DB_PASSWORD=
```

Lalu jalankan migrasi dan seeder:

```bash
php artisan migrate --seed
```

Install dependency frontend:

```bash
npm install
```

## 2. Cara Menjalankan Project

Jalankan aplikasi dalam dua terminal terpisah.

Terminal 1 (backend):

```bash
php artisan serve
```

Terminal 2 (frontend):

```bash
npm run dev
```

Setelah server berjalan, buka:

```text
http://127.0.0.1:8000
```

## 3. Struktur Database

Database utama terdiri dari tabel-tabel berikut:

- `roles`
  - `id`
  - `name`

- `users`
  - `id`
  - `name`
  - `email`
  - `password`
  - `role_id`

- `categories`
  - `id`
  - `name`

- `budgets`
  - `id`
  - `category_id`
  - `amount`
  - `fiscal_year`

- `submissions`
  - `id`
  - `submission_number`
  - `submission_date`
  - `user_id`
  - `category_id`
  - `amount`
  - `description`
  - `attachment`
  - `status`

- `approvals`
  - `id`
  - `submission_id`
  - `user_id`
  - `status`
  - `notes`

- `payments`
  - `id`
  - `submission_id`
  - `user_id`
  - `payment_date`

Relasi utama:
- `users.role_id` mengacu ke `roles.id`
- `submissions.user_id` mengacu ke `users.id`
- `submissions.category_id` mengacu ke `categories.id`
- `approvals.submission_id` mengacu ke `submissions.id`
- `payments.submission_id` mengacu ke `submissions.id`

## 4. Akun Login Testing

Berikut akun yang dapat digunakan untuk testing setelah menjalankan seeder:

| Role | Email | Password |
| --- | --- | --- |
| Staff | staff@test.com | password |
| SPV | spv@test.com | password |
| Manager | manager@test.com | password |
| Direktur | direktur@test.com | password |
| Finance | finance@test.com | password |

Catatan:
- Akun admin juga tersedia dengan email `admin@test.com` dan password `password`.
- Password default di-seed menggunakan hashing Laravel.
