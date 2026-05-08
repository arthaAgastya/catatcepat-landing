# Manual Pengguna Sistem Manajemen Koperasi

## Selamat Datang di Sistem Manajemen Koperasi

Sistem Manajemen Koperasi adalah platform digital yang dirancang untuk memudahkan pengelolaan operasional koperasi secara efisien dan transparan. Dengan antarmuka yang user-friendly dan fitur otomatisasi canggih, sistem ini membantu Anda mengelola anggota, simpanan, pinjaman, dan laporan keuangan dengan mudah.

---

## 1. Memulai: Login ke Sistem

### Langkah-langkah Login:

1. **Buka Browser**: Akses alamat website koperasi (contoh: `https://koperasi-anda.com`)
2. **Halaman Login**: Anda akan melihat form login dengan kolom:
    - **Email/Username**: Masukkan email atau username Anda
    - **Password**: Masukkan kata sandi Anda
3. **Klik "Login"**: Sistem akan memverifikasi kredensial Anda

### Lupa Password?

-   Klik link **"Lupa Password?"** di halaman login
-   Masukkan email Anda
-   Ikuti instruksi yang dikirim ke email untuk reset password

### Tips Login:

-   Pastikan koneksi internet stabil
-   Gunakan browser terbaru (Chrome, Firefox, Safari)
-   Jika login gagal, periksa kembali email dan password
-   Hubungi administrator jika mengalami kesulitan

---

## 2. Dashboard: Ringkasan Sistem

Setelah login berhasil, Anda akan diarahkan ke **Dashboard** yang menampilkan:

### Informasi Utama:

-   **Total Simpanan**: Jumlah total simpanan anggota
-   **Total Pinjaman**: Jumlah pinjaman yang sedang berjalan
-   **Jumlah Anggota Aktif**: Total anggota yang aktif
-   **Laporan Keuangan**: Ringkasan neraca dan laba/rugi

### Menu Navigasi:

-   **Beranda**: Dashboard utama
-   **Master Data**: Kelola anggota, akun, pengguna
-   **Transaksi**: Simpanan, pinjaman, transaksi umum
-   **Laporan**: Berbagai jenis laporan keuangan
-   **Pencatatan**: Jurnal, neraca, LPU

---

## 3. Manajemen Anggota

### 3.1 Menambah Anggota Baru

1. **Akses Menu**: Master Data → Anggota → Tambah Baru
2. **Upload KTP**: Klik tombol "Pilih File" dan upload foto KTP
3. **Proses OCR**: Klik "🔍 Proses OCR" untuk ekstraksi data otomatis
4. **Periksa Data**: Sistem akan mengisi form secara otomatis. Periksa dan edit jika perlu
5. **Isi Data Tambahan**:
    - Informasi pribadi (nama, alamat, telepon)
    - Data keluarga dan ahli waris
    - Informasi pekerjaan
    - Tanggal pendaftaran
6. **Simpan**: Klik "Simpan" untuk menyimpan data anggota

### 3.2 Mengedit Data Anggota

1. **Cari Anggota**: Master Data → Anggota → Cari berdasarkan nama atau nomor anggota
2. **Klik Edit**: Pada baris anggota yang dipilih, klik tombol "Edit"
3. **Update Data**: Lakukan perubahan yang diperlukan
4. **Simpan Perubahan**: Klik "Update" untuk menyimpan

### 3.3 Mengaktifkan/Nonaktifkan Anggota

1. **Pilih Anggota**: Dari daftar anggota
2. **Ubah Status**: Klik tombol "Aktif/Non-aktif"
3. **Konfirmasi**: Sistem akan meminta konfirmasi perubahan status

---

## 4. Sistem Simpanan

### 4.1 Mencatat Setoran Simpanan

1. **Akses Menu**: Transaksi → Simpanan → Tambah Baru
2. **Pilih Anggota**: Cari dan pilih anggota yang akan setor
3. **Pilih Jenis Simpanan**:
    - **Simpanan Pokok**: Wajib, biasanya setor sekali
    - **Simpanan Wajib**: Setor rutin bulanan
    - **Simpanan Sukarela**: Opsional
4. **Isi Detail**:
    - Tanggal setoran
    - Jumlah nominal (minimal sesuai ketentuan)
    - Keterangan (opsional)
5. **Upload Bukti**: Upload foto bukti setoran (opsional)
6. **Simpan Transaksi**: Sistem akan mencatat dan update saldo

### 4.2 Mencatat Penarikan Simpanan

1. **Akses Menu**: Transaksi → Simpanan → Tarik Simpanan
2. **Pilih Anggota**: Cari anggota yang akan tarik
3. **Cek Saldo**: Sistem akan menampilkan saldo tersedia
4. **Pilih Jenis**: Hanya simpanan pokok dan sukarela yang dapat ditarik
5. **Isi Detail**:
    - Tanggal penarikan
    - Jumlah penarikan (tidak boleh melebihi saldo)
    - Nomor bukti
    - Keterangan
6. **Simpan**: Sistem akan memproses penarikan

### 4.3 Melihat Riwayat Simpanan

1. **Akses Menu**: Transaksi → Simpanan → Index
2. **Filter Data**: Gunakan filter tanggal, jenis simpanan, atau nama anggota
3. **Lihat Detail**: Klik detail untuk melihat transaksi lengkap

---

## 5. Sistem Pinjaman

### 5.1 Mengajukan Pinjaman

1. **Akses Menu**: Transaksi → Pinjaman → Ajukan Baru
2. **Pilih Anggota**: Cari anggota peminjam
3. **Isi Detail Pinjaman**:
    - Jumlah pinjaman yang diajukan
    - Tenor (jangka waktu) dalam bulan
    - Jenis angsuran (harian/mingguan/bulanan/jatuh tempo)
    - Besaran jasa (flat/anuitas/persen)
    - Bunga persen
4. **Simpan Pengajuan**: Sistem akan generate kode pinjaman otomatis

### 5.2 Menyetujui/Tolak Pinjaman

1. **Akses Menu**: Transaksi → Pinjaman → Daftar Pinjaman
2. **Pilih Pinjaman**: Klik "Persetujuan" pada pinjaman pending
3. **Review Data**: Periksa detail pengajuan
4. **Berikan Keputusan**:
    - **Setujui**: Klik "Disetujui" dan isi catatan
    - **Tolak**: Klik "Ditolak" dan isi alasan penolakan
5. **Simpan Keputusan**

### 5.3 Pencairan Dana Pinjaman

1. **Pilih Pinjaman Disetujui**: Dari daftar pinjaman
2. **Klik Pencairan**: Klik tombol "Pencairan"
3. **Isi Detail Pencairan**:
    - Tanggal pencairan
    - Jumlah yang dicairkan
    - Metode pencairan (transfer/tunai)
4. **Generate Jadwal**: Sistem akan otomatis buat jadwal angsuran
5. **Simpan**: Dana siap dicairkan

### 5.4 Pembayaran Angsuran

1. **Akses Menu**: Transaksi → Angsuran
2. **Pilih Anggota**: Cari anggota yang akan bayar
3. **Pilih Angsuran**: Klik "Bayar" pada angsuran yang jatuh tempo
4. **Konfirmasi Pembayaran**: Sistem akan mencatat pembayaran
5. **Cetak Bukti**: Jika diperlukan

---

## 6. Transaksi Umum

### 6.1 Mencatat Transaksi Lain

1. **Akses Menu**: Transaksi → Transaksi Lain → Tambah Baru
2. **Upload Nota**: Upload foto nota/invoice (opsional)
3. **Proses OCR**: Klik "🔍 Proses OCR" untuk ekstraksi otomatis
4. **Periksa Item**: Sistem akan mengisi daftar barang otomatis
5. **Edit Jika Perlu**: Tambah/kurangi item, edit harga
6. **Isi Pajak & Diskon**: Masukkan pajak dan diskon jika ada
7. **Pilih Akun**: Untuk setiap transaksi, pilih akun debit dan kredit
8. **Validasi**: Pastikan total debit = total kredit
9. **Simpan Transaksi**

### 6.2 Melihat Daftar Transaksi

1. **Akses Menu**: Transaksi → Transaksi Lain → Index
2. **Filter & Cari**: Berdasarkan tanggal, keterangan, dll
3. **Lihat Detail**: Klik untuk melihat detail lengkap

---

## 7. Laporan dan Pencatatan

### 7.1 Laporan Simpanan

1. **Akses Menu**: Laporan → Simpanan
2. **Pilih Periode**: Tentukan rentang tanggal
3. **Pilih Filter**: Per jenis simpanan atau per anggota
4. **Generate Laporan**: Klik "Tampilkan"
5. **Export**: Simpan sebagai PDF atau Excel

### 7.2 Laporan Pinjaman

1. **Akses Menu**: Laporan → Pinjaman
2. **Filter Data**: Status pinjaman, periode, dll
3. **Lihat Detail**: Outstanding loans, payment history
4. **Export Laporan**

### 7.3 Jurnal Transaksi

1. **Akses Menu**: Pencatatan → Jurnal Transaksi
2. **Pilih Periode**: Rentang tanggal yang diinginkan
3. **Lihat Jurnal**: Semua transaksi dengan debit/kredit
4. **Cek Balance**: Pastikan total debit = total kredit

### 7.4 Neraca Keuangan

1. **Akses Menu**: Pencatatan → Laporan Posisi Keuangan
2. **Lihat Neraca**: Aktiva vs Kewajiban + Ekuitas
3. **Cek Status**: Seimbang atau tidak seimbang
4. **Export**: Simpan laporan

### 7.5 Laporan Perhitungan Usaha (LPU)

1. **Akses Menu**: Pencatatan → Laporan Perhitungan Usaha
2. **Lihat Laporan**: Pendapatan vs Beban
3. **Hitung Laba/Rugi**: Otomatis terhitung
4. **Export Laporan**

---

## 8. Pengaturan Sistem

### 8.1 Manajemen Pengguna

1. **Akses Menu**: Master Data → Pengelola
2. **Tambah Pengguna**: Isi data nama, email, role
3. **Set Password**: Sistem akan kirim email reset password
4. **Kelola Role**: Assign role dan permission

### 8.2 Chart of Accounts (COA)

1. **Akses Menu**: Master Data → Akun
2. **Tambah Akun Baru**: Isi kode akun, nama, kategori
3. **Set Saldo Normal**: Debit atau kredit
4. **Kelola Hierarki**: Parent/child accounts

### 8.3 Role dan Permission

1. **Akses Menu**: Master Data → Role/Permission
2. **Buat Role Baru**: Isi nama role
3. **Assign Permission**: Pilih hak akses yang sesuai
4. **Update Pengguna**: Assign role ke pengguna

---

## 9. Tips dan Troubleshooting

### 9.1 Masalah Umum

**Login Gagal**:

-   Periksa email dan password
-   Pastikan akun aktif
-   Reset password jika lupa

**Upload File Gagal**:

-   Pastikan format file sesuai (JPG, PNG, PDF)
-   Ukuran file maksimal 2MB
-   Periksa koneksi internet

**Data Tidak Tersimpan**:

-   Pastikan semua field wajib terisi
-   Periksa format tanggal dan angka
-   Refresh halaman dan coba lagi

### 9.2 Keyboard Shortcuts

-   **Ctrl+S**: Simpan form
-   **Ctrl+F**: Cari dalam halaman
-   **Esc**: Tutup modal/popup
-   **Enter**: Submit form

### 9.3 Best Practices

1. **Backup Data**: Selalu backup data penting
2. **Verifikasi Input**: Periksa ulang sebelum simpan
3. **Gunakan OCR**: Manfaatkan fitur AI untuk efisiensi
4. **Update Berkala**: Periksa saldo dan status secara berkala
5. **Keamanan**: Jangan bagikan password, logout setelah selesai

---

## 10. Kontak Support

Jika Anda mengalami kesulitan atau memiliki pertanyaan:

-   **Email Support**: support@koperasi-anda.com
-   **Telepon**: (021) 1234-5678
-   **WhatsApp**: +62 812-3456-7890
-   **Jam Operasional**: Senin-Jumat, 08:00-17:00 WIB

---

## 11. Update dan Perbaikan

Sistem akan menerima update berkala untuk perbaikan bug dan penambahan fitur. Pastikan untuk:

1. **Cek Update**: Login secara berkala untuk notifikasi update
2. **Backup Data**: Sebelum update besar
3. **Test Fitur Baru**: Coba fitur baru setelah update
4. **Laporkan Bug**: Jika menemukan error, laporkan ke support

---

_Manual ini dibuat untuk memudahkan penggunaan Sistem Manajemen Koperasi. Untuk informasi lebih detail tentang fitur tertentu, silakan hubungi tim support atau baca dokumentasi teknis._

**Versi Manual: 1.0**
**Tanggal Update: Desember 2024**
