```markdown
# Aplikasi Manajemen Tugas (To-Do App)

Aplikasi ini adalah aplikasi manajemen tugas berbasis web yang memungkinkan pengguna untuk mendaftar, login, mengelola tugas (create, read, update, delete), memfilter tugas berdasarkan status, serta menampilkan kutipan motivasi harian dari API eksternal. Aplikasi ini dibangun menggunakan Laravel dengan antarmuka pengguna yang responsif dan menarik berbasis Bootstrap.

## Fitur
-   Autentikasi Pengguna  : Registrasi, login, logout, dan proteksi rute untuk pengguna yang sudah login.
-   Manajemen Tugas  : Membuat, membaca, memperbarui, dan menghapus tugas dengan status "pending" atau "completed".
-   Filter Tugas  : Memfilter tugas berdasarkan status (semua, belum selesai, selesai).
-   Kutipan Motivasi  : Menampilkan kutipan harian dari API API-Ninjas di dashboard.
-   Desain Responsif  : Antarmuka pengguna yang rapi dan responsif menggunakan Bootstrap 5 dengan tata letak modern.

![alt_text](https://github.com/khikisb/todo-app/blob/master/dashboard.png?raw=true)

## Teknologi yang Digunakan
-   Backend  : PHP 8.1, Laravel 10
-   Frontend  : Bootstrap 5.3.3, Bootstrap Icons 1.11.3
-   Database  : MySQL
-   API Eksternal  : API-Ninjas (https://api.api-ninjas.com/v1/quotes)
-   Lainnya  : Composer, npm, Laravel Authentication (UI Bootstrap)

## Prasyarat
Sebelum menjalankan proyek, pastikan Anda memiliki:
- PHP >= 8.1
- Composer
- MySQL (dikonfigurasi pada port 3307 atau sesuaikan)
- Node.js dan npm
- Kunci API dari [API-Ninjas](https://api.api-ninjas.com/) (daftar untuk mendapatkan kunci gratis)

## Instruksi Setup
Ikuti langkah-langkah berikut untuk mengatur dan menjalankan proyek di lingkungan lokal Anda.

1.   Kloning Repositori   (jika menggunakan Git):
   ```bash
   git clone <url-repositori-anda>
   cd todo-app
```

Atau unduh proyek secara manual dan ekstrak ke direktori kerja.

2.   Instal Dependensi  :

   ```bash
   composer install
   npm install
   npm run build
   ```

3.   Konfigurasi Lingkungan  :

   - Salin file `.env.example` ke `.env`:

     ```bash
     cp .env.example .env
     ```
   - Buka `.env` dan sesuaikan pengaturan database serta kunci API:

     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3307
     DB_DATABASE=todo_app
     DB_USERNAME=root
     DB_PASSWORD=
     
     API_NINJAS_KEY=your_api_ninjas_key
     ```
   - Ganti `your_api_ninjas_key` dengan kunci API dari API-Ninjas.

4.   Buat Database  :

   - Buat database MySQL bernama `todo_app`:

     ```sql
     CREATE DATABASE todo_app;
     ```
   - Atau gunakan klien seperti phpMyAdmin.

5.   Jalankan Migrasi dan Data Dummy  :

   - Jalankan migrasi untuk membuat tabel:

     ```bash
     php artisan migrate
     ```
   - Opsional: Tambahkan data dummy dengan menjalankan SQL berikut di klien MySQL:

     ```sql
     INSERT INTO users (name, email, password, created_at, updated_at) VALUES
     ('John Doe', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2025-06-06 21:54:00', '2025-06-06 21:54:00'),
     ('Jane Smith', 'jane@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2025-06-06 21:54:00', '2025-06-06 21:54:00');
     
     INSERT INTO tasks (user_id, title, description, status, created_at, updated_at) VALUES
     (1, 'Complete Project Proposal', 'Draft and finalize the project proposal for client review.', 'pending', '2025-06-06 21:54:00', '2025-06-06 21:54:00'),
     (2, 'Schedule Team Meeting', 'Organize a meeting to discuss project milestones.', 'completed', '2025-06-06 21:54:00', '2025-06-06 21:54:00');
     ```

6.   Generate Kunci Aplikasi  :

   ```bash
   php artisan key:generate
   ```

7.   Jalankan Server  :

   ```bash
   php artisan serve
   ```

   Aplikasi akan tersedia di `http://localhost:8000`.

8.   Login  :

   - Gunakan kredensial dummy:
     - Email: `john@example.com`, Kata Sandi: `password`
     - Email: `jane@example.com`, Kata Sandi: `password`
   - Atau daftar pengguna baru di `http://localhost:8000/register`.

## Struktur Proyek

Berikut adalah struktur direktori utama proyek dan penjelasan singkat:

-   app/  :
  - `Http/Controllers/TaskController.php`: Mengelola logika CRUD tugas dan integrasi API kutipan.
  - `Models/Task.php`: Model Eloquent untuk tabel `tasks`.
  - `Policies/TaskPolicy.php`: Kebijakan otorisasi untuk memastikan pengguna hanya mengelola tugas miliknya.
-   database/  :
  - `migrations/`: Berisi migrasi untuk tabel `users` dan `tasks`.
-   resources/  :
  - `views/layouts/app.blade.php`: Template utama dengan navbar dan CSS Bootstrap.
  - `views/tasks/index.blade.php`: Dashboard dengan formulir filter, tambah tugas, tabel tugas, dan kutipan motivasi.
-   routes/  :
  - `web.php`: Mendefinisikan rute untuk autentikasi dan manajemen tugas.
-   public/  :
  - Berisi aset statis seperti CSS dan JS yang dihasilkan oleh npm.
-   .env  : File konfigurasi untuk database dan kunci API.

## Catatan Pengembangan

-   Autentikasi  : Rute tugas dilindungi oleh middleware `auth`, memastikan hanya pengguna yang login yang dapat mengaksesnya.
-   API-Ninjas  : Pastikan kunci API valid dan kuota tidak terlampaui. Jika ada masalah SSL, perbarui bundle CA di `php.ini` atau gunakan opsi `verify => false` (hanya untuk lokal).
-   Desain  : Antarmuka menggunakan Bootstrap 5 dengan warna kustom (biru muda #4A90E2, oranye #F39C12) dan modal edit untuk pengalaman pengguna yang rapi.
-   Database  : Tabel `tasks` memiliki kunci asing `user_id` ke `users` dengan `ON DELETE CASCADE`.

## Penyelesaian Masalah

-   Kesalahan Database  : Pastikan MySQL berjalan pada port 3307 dan database `todo_app` ada.
-   Kesalahan API  : Periksa kunci API di `.env` dan uji endpoint `https://api.api-ninjas.com/v1/quotes` dengan cURL.
-   Tampilan Tidak Rapi  : Pastikan CDN Bootstrap aktif atau gunakan aset lokal.
-   Log Kesalahan  : Periksa `storage/logs/laravel.log` untuk detail error.

## Kontribusi

Untuk berkontribusi, silakan fork repositori, buat branch baru, dan ajukan pull request dengan deskripsi perubahan.

```
```
