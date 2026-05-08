# Dokumentasi Lengkap Sistem Manajemen Koperasi

## Gambaran Umum

Sistem Manajemen Koperasi adalah aplikasi web berbasis Laravel yang dirancang untuk mengelola operasional koperasi secara efisien. Sistem ini mengintegrasikan teknologi AI untuk pemrosesan dokumen otomatis dan menyediakan fitur lengkap untuk manajemen anggota, simpanan, pinjaman, transaksi, dan pelaporan akuntansi.

## Teknologi yang Digunakan

-   **Framework**: Laravel 12
-   **Database**: MySQL / SQLite
-   **Frontend**: Blade Templates, Bootstrap, JavaScript, jQuery
-   **AI Integration**: Google Gemini API 2.0 Flash
-   **OCR Processing**: Tesseract.js
-   **Authentication**: Laravel Sanctum
-   **Permissions**: Spatie Laravel Permission

## Arsitektur Sistem

### Struktur Database Utama

#### 1. Tabel Anggota (`anggota`)

```sql
- id (Primary Key)
- nomor_anggota (Unique)
- nama
- jenis_kelamin (L/P)
- alamat, kecamatan, kabupaten, provinsi
- telepon, email
- status_keluarga, jumlah_tanggungan
- nama_ahli_waris, hubungan_ahli_waris, telepon_ahli_waris
- pekerjaan, alamat_pekerjaan
- tanggal_pendaftaran
- rekening_simpanan_pokok, rekening_simpanan_wajib, rekening_simpanan_sukarela
- status (aktif/non-aktif)
```

#### 2. Tabel Pinjaman (`pinjaman`)

```sql
- id (Primary Key)
- id_anggota (Foreign Key)
- kode_pinjaman (Unique)
- tanggal_pengajuan, tanggal_disetujui
- jumlah_pinjaman (Decimal)
- tenor (Integer)
- jenis_angsuran (harian/mingguan/bulanan/jatuh_tempo)
- besaran_jasa (flat/anuitas/persen)
- bunga_persen, suku_bunga_tahunan
- biaya_admin
- status (pending/disetujui/ditolak/lunas)
```

#### 3. Tabel Simpanan (`simpanan`)

```sql
- id (Primary Key)
- id_anggota, id_user, id_account (Foreign Keys)
- nomor_bukti (Unique)
- tanggal
- jenis_transaksi (setor/tarik)
- keterangan
- jumlah (Decimal)
```

#### 4. Tabel Transaksi (`transaksi`)

```sql
- id (Primary Key)
- id_anggota, id_user (Foreign Keys, nullable)
- tanggal
- keterangan
- ref (UUID)
```

#### 5. Tabel Jurnal (`jurnal`)

```sql
- id (Primary Key)
- id_transaksi, id_account (Foreign Keys)
- tipe (debit/kredit)
- jumlah (Decimal)
```

#### 6. Tabel Account (`account`)

```sql
- no_account (Unique)
- saldo_normal (debit/kredit)
- level (1/2)
- nama_account
- kelompok (Aktiva/Kewajiban/Ekuitas/Pendapatan/Beban)
```

## Fitur Utama Sistem

### 1. Manajemen Anggota 👥

#### Fitur OCR untuk KTP

-   **Upload Gambar KTP**: Sistem menerima upload gambar KTP anggota
-   **Pemrosesan AI**: Menggunakan Google Gemini API untuk ekstraksi data:
    -   NIK, Nama Lengkap
    -   Tempat/Tanggal Lahir
    -   Alamat Lengkap
    -   Jenis Kelamin
-   **Validasi Data**: Data yang diekstrak dapat diedit sebelum disimpan

#### CRUD Anggota

-   **Pendaftaran Anggota Baru**
-   **Update Data Anggota**
-   **Manajemen Status** (Aktif/Non-Aktif)
-   **Data Ahli Waris**
-   **Informasi Pekerjaan**

### 2. Sistem Simpanan 💰

#### Jenis Simpanan

1. **Simpanan Pokok**: Wajib dibayar saat pendaftaran
2. **Simpanan Wajib**: Pembayaran rutin bulanan
3. **Simpanan Sukarela**: Opsional, dapat ditarik kapan saja

#### Transaksi Simpanan

-   **Setoran Simpanan**: Pencatatan setoran dari anggota
-   **Penarikan Simpanan**: Khusus simpanan pokok dan sukarela
-   **Monitoring Saldo Real-time**
-   **Riwayat Transaksi Lengkap**

#### Jurnal Otomatis

-   **Setoran**: Debit Kas, Kredit Simpanan
-   **Penarikan**: Debit Simpanan, Kredit Kas

### 3. Sistem Pinjaman 💳

#### Pengajuan Pinjaman

-   **Form Pengajuan**: Input data pinjaman oleh anggota
-   **Kode Pinjaman Otomatis**: Format PNJ + YYMMDD + 5 digit sequence
-   **Validasi Data**: Minimal pinjaman, maksimal tenor

#### Persetujuan Pinjaman

-   **Review oleh Pengelola**: Sistem approval workflow
-   **Status Tracking**: Pending → Disetujui/Ditolak
-   **Catatan Persetujuan**

#### Pencairan Dana

-   **Proses Pencairan**: Setelah disetujui
-   **Generate Jadwal Angsuran Otomatis**
-   **Jurnal Pencairan**: Debit Piutang, Kredit Kas

#### Sistem Angsuran

-   **Jenis Angsuran**:

    -   **Flat**: Bunga tetap per periode
    -   **Anuitas**: Angsuran tetap, bunga menurun
    -   **Persen**: Bunga berdasarkan sisa pokok
    -   **Jatuh Tempo**: Pembayaran di akhir tenor

-   **Jadwal Pembayaran**: Harian/Mingguan/Bulanan
-   **Tracking Pembayaran**: Status belum/lunas
-   **Denda Keterlambatan** (opsional)

#### Jurnal Angsuran

-   **Pembayaran Angsuran**: Debit Kas, Kredit Piutang

### 4. Transaksi Umum 📊

#### OCR untuk Nota/Struk

-   **Upload Gambar Nota**: Sistem menerima gambar struk belanja
-   **Pemrosesan AI**: Ekstraksi otomatis:
    -   Daftar barang (nama, quantity, price)
    -   Diskon, Pajak
    -   Total pembayaran
-   **Koreksi Manual**: Data dapat diedit sebelum simpan

#### Pencatatan Transaksi

-   **Multi-Account Journal**: Debit dan Kredit multiple
-   **Validasi Balance**: Total debit = total kredit
-   **Upload Bukti**: File nota/invoice
-   **Keterangan Transaksi**

#### Jurnal Transaksi

-   **Double Entry Accounting**: Setiap transaksi memiliki debit dan kredit yang balance
-   **Account Mapping**: Pemilihan akun berdasarkan kategori

### 5. Sistem Akuntansi 📈

#### Chart of Accounts (COA)

-   **Struktur Akun**: 5 digit kode akun
-   **Kategori**: Aktiva, Kewajiban, Ekuitas, Pendapatan, Beban
-   **Saldo Normal**: Debit/Kredit
-   **Level**: Parent/Child accounts

#### Jurnal Umum

-   **Pencatatan Harian**: Semua transaksi tercatat
-   **Filter & Search**: Berdasarkan tanggal, akun, anggota
-   **Export Data**: Format Excel/PDF

#### Neraca Keuangan

-   **Aktiva**: Kas, Piutang, Simpanan, dll
-   **Kewajiban + Ekuitas**: Hutang, Modal, dll
-   **Balance Check**: Pastikan aktiva = kewajiban + ekuitas
-   **Periode**: Real-time atau berdasarkan tanggal

#### Laporan Perhitungan Usaha (LPU)

-   **Pendapatan**: Bunga pinjaman, jasa administrasi
-   **Beban**: Biaya operasional, bunga simpanan
-   **Laba/Rugi**: Perhitungan otomatis
-   **Margin Analysis**

### 6. Fitur AI Integration 🤖

#### AIService Class

```php
class AIService {
    protected $apiKey = 'AIzaSyAsLcO6wjLDiKsgO1Qj2ya4lqk1y2t-n64';
    protected $model = 'gemini-2.0-flash';

    public function extractIdentityData(string $ocrText): array
    public function extractTransactionData(string $ocrText): array
}
```

#### Prompt Engineering

-   **Identity Extraction**: Template prompt untuk data KTP
-   **Transaction Extraction**: Template prompt untuk data nota
-   **Error Handling**: Fallback untuk parsing gagal
-   **JSON Response**: Structured output dari AI

#### OCR Processing

-   **Tesseract.js**: Client-side OCR processing
-   **Image Preprocessing**: B/W conversion, noise reduction
-   **Confidence Scoring**: Akurasi recognition
-   **Fallback Manual**: Input manual jika OCR gagal

### 7. Sistem Laporan 📋

#### Laporan Simpanan

-   **Per Anggota**: Riwayat setoran & penarikan
-   **Per Jenis**: Pokok, Wajib, Sukarela
-   **Statistik**: Total simpanan, jumlah anggota aktif

#### Laporan Pinjaman

-   **Outstanding Loans**: Pinjaman aktif
-   **Payment History**: Riwayat angsuran
-   **Delinquency Report**: Pinjaman bermasalah

#### Laporan SHU (Sisa Hasil Usaha)

-   **Perhitungan SHU**: Berdasarkan simpanan & pinjaman
-   **Distribusi**: Jasa simpanan, jasa pinjaman, cadangan
-   **Audit Trail**: Riwayat perhitungan

### 8. Sistem Keamanan 🔒

#### Role-Based Access Control

-   **Super Admin**: Full access
-   **Pengelola**: Manajemen operasional
-   **Anggota**: View personal data

#### Authentication

-   **Laravel Sanctum**: API token authentication
-   **Session Management**: Secure login/logout
-   **Password Hashing**: Bcrypt encryption

#### Data Validation

-   **Server-side Validation**: Laravel validation rules
-   **Client-side Validation**: JavaScript form validation
-   **File Upload Security**: MIME type, size limits

## API Endpoints

### OCR Endpoints

```
POST /ocr/parse - Ekstraksi data KTP
POST /ocr/invoice/parse - Ekstraksi data nota
```

### Master Data

```
GET/POST /master/anggota - CRUD Anggota
GET/POST /master/akun - CRUD Chart of Accounts
GET/POST /master/role - Role Management
GET/POST /master/permission - Permission Management
```

### Transaksi

```
GET/POST /transaksi/simpanan - Simpanan management
GET/POST /transaksi/pinjaman - Pinjaman management
GET/POST /transaksi/transaksi-lain - Transaksi umum
GET/POST /transaksi/angsuran - Pembayaran angsuran
```

### Laporan

```
GET /laporan/simpanan - Laporan simpanan
GET /laporan/pinjaman - Laporan pinjaman
GET /laporan/shu - Laporan SHU
```

### Pencatatan Akuntansi

```
GET /pencatatan/jurnal - Jurnal umum
GET /pencatatan/neraca - Neraca keuangan
GET /pencatatan/lpu - Laporan LPU
```

## Workflow Sistem

### 1. Pendaftaran Anggota

1. Upload KTP → OCR Processing → AI Extraction
2. Review & Edit Data → Simpan Anggota
3. Generate Nomor Anggota → Aktivasi Akun

### 2. Proses Pinjaman

1. Pengajuan Pinjaman → Review Pengelola
2. Persetujuan/Ditolak → Jika disetujui: Pencairan
3. Generate Jadwal Angsuran → Mulai Pembayaran
4. Tracking Pembayaran → Update Status

### 3. Transaksi Umum

1. Upload Nota → OCR Processing → AI Extraction
2. Review Items & Total → Pilih Akun Debit/Kredit
3. Validasi Balance → Simpan Transaksi
4. Generate Jurnal Entry

## Keunggulan Sistem

### 1. AI-Powered Automation

-   **Otomatisasi Data Entry**: Mengurangi kesalahan manual
-   **Intelligent Parsing**: Memahami konteks dokumen
-   **Smart Validation**: Deteksi anomali data

### 2. Comprehensive Accounting

-   **Double Entry System**: Akuntansi yang akurat
-   **Real-time Reporting**: Laporan instan
-   **Audit Trail**: Tracking perubahan data

### 3. User-Friendly Interface

-   **Responsive Design**: Mobile-friendly
-   **Intuitive Navigation**: Mudah digunakan
-   **Real-time Feedback**: Notifikasi dan validasi

### 4. Scalable Architecture

-   **Modular Design**: Mudah dikembangkan
-   **RESTful API**: Integrasi dengan sistem lain
-   **Queue System**: Background processing

## Maintenance & Support

### Backup & Recovery

-   **Database Backup**: Otomatis harian
-   **File Storage**: Cloud backup untuk dokumen
-   **Disaster Recovery**: Plan B untuk kehilangan data

### Performance Monitoring

-   **System Logs**: Laravel logging
-   **Performance Metrics**: Response time, memory usage
-   **Error Tracking**: Exception handling

### Future Enhancements

-   **Mobile App**: Aplikasi mobile untuk anggota
-   **API Integration**: Payment gateway, e-signature
-   **Advanced AI**: Machine learning untuk fraud detection
-   **Multi-branch**: Support multiple koperasi locations

## Kesimpulan

Sistem Manajemen Koperasi ini menyediakan solusi lengkap untuk mengelola operasional koperasi modern dengan integrasi AI yang powerful. Kombinasi antara teknologi terkini dan praktik akuntansi yang solid menjadikan sistem ini efisien, akurat, dan mudah digunakan.

Dengan fitur OCR dan AI, sistem ini mengurangi beban kerja manual dan meminimalkan kesalahan input data, sementara sistem akuntansi yang komprehensif memastikan compliance dan transparansi keuangan koperasi.
