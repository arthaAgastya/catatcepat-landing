# Sistem Manajemen Koperasi

Sistem manajemen koperasi berbasis web yang dibangun menggunakan Laravel untuk mengelola operasional koperasi secara efisien. Sistem ini menyediakan fitur-fitur lengkap untuk pengelolaan anggota, simpanan, pinjaman, transaksi, pencatatan akuntansi, dan pelaporan.

## Fitur Utama

### 👥 Manajemen Anggota

-   Pendaftaran dan pengelolaan data anggota koperasi
-   Manajemen peran dan izin pengguna (Role-Based Access Control)
-   Pengelolaan data pengelola koperasi

### 💰 Simpanan

-   Pencatatan setoran simpanan anggota
-   Penarikan simpanan
-   Monitoring saldo simpanan real-time
-   Riwayat transaksi simpanan

### 💳 Pinjaman

-   Pengajuan pinjaman oleh anggota
-   Proses persetujuan pinjaman
-   Pencairan dana pinjaman
-   Sistem angsuran otomatis
-   Pembayaran angsuran

### 📊 Transaksi

-   Pencatatan transaksi umum
-   Transaksi angsuran pinjaman
-   Integrasi dengan sistem akuntansi

### 📈 Pencatatan Akuntansi

-   Jurnal umum
-   Neraca keuangan
-   Laporan Perhitungan Usaha (LPU)
-   Chart of Accounts (COA)

### 📋 Laporan

-   Laporan simpanan anggota
-   Laporan pinjaman
-   Laporan SHU (Sisa Hasil Usaha)
-   Laporan keuangan lainnya

### 🤖 Fitur Tambahan

-   OCR (Optical Character Recognition) untuk pemrosesan dokumen
-   Dashboard dengan ringkasan keuangan
-   Sistem notifikasi dan approval

## Teknologi yang Digunakan

-   **Framework**: Laravel 12
-   **Database**: MySQL / SQLite
-   **Frontend**: Blade Templates, Bootstrap, JavaScript
-   **Authentication**: Laravel Sanctum / UI
-   **Permissions**: Spatie Laravel Permission
-   **Queue**: Laravel Queue untuk background jobs

## Persyaratan Sistem

-   PHP ^8.2
-   Composer
-   Node.js & NPM
-   MySQL atau SQLite

## Instalasi

1. **Clone Repository**

    ```bash
    git clone <repository-url>
    cd koperasi
    ```

2. **Install Dependencies**

    ```bash
    composer install
    npm install
    ```

3. **Konfigurasi Environment**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Konfigurasi Database**
   Edit file `.env` dan sesuaikan pengaturan database:

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=koperasi
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```

5. **Jalankan Migrasi dan Seeder**

    ```bash
    php artisan migrate
    php artisan db:seed
    ```

6. **Build Assets**

    ```bash
    npm run build
    ```

7. **Jalankan Aplikasi**

    ```bash
    php artisan serve
    ```

    Atau gunakan script dev untuk menjalankan server, queue, dan vite secara bersamaan:

    ```bash
    composer run dev
    ```

## Penggunaan

### Akses Sistem

-   Buka browser dan akses `http://localhost:8000`
-   Login dengan akun admin yang telah dibuat melalui seeder

### Menu Utama

-   **Dashboard**: Ringkasan keuangan dan statistik
-   **Master**: Pengelolaan data dasar (anggota, akun, pengguna)
-   **Transaksi**: Pencatatan simpanan, pinjaman, dan transaksi lainnya
-   **Laporan**: Generate dan view berbagai laporan
-   **Pencatatan**: Jurnal, neraca, dan LPU

## Struktur Database

Sistem menggunakan beberapa tabel utama:

-   `users`: Data pengguna dan pengelola
-   `anggotas`: Data anggota koperasi
-   `accounts`: Chart of Accounts
-   `simpanans`: Transaksi simpanan
-   `pinjamen`: Data pinjaman
-   `transaksis`: Transaksi umum
-   `jurnals`: Jurnal akuntansi

## Testing

Jalankan test suite dengan perintah:

```bash
php artisan test
```

## Kontribusi

1. Fork repository
2. Buat branch fitur baru (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## Lisensi

Proyek ini menggunakan lisensi MIT. Lihat file `LICENSE` untuk detail lebih lanjut.

## Dukungan

Untuk pertanyaan atau dukungan, silakan hubungi tim pengembang atau buat issue di repository ini.
