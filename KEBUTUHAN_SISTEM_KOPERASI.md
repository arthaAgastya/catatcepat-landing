# Kebutuhan Sistem Manajemen Koperasi

## 0. Kebutuhan Software & Hardware

### 0.1 Kebutuhan Software

#### Server Requirements

-   **Operating System**: Linux (Ubuntu 20.04 LTS atau CentOS 8+), Windows Server 2019+
-   **Web Server**: Apache 2.4+ atau Nginx 1.20+
-   **Database**: MySQL 8.0+ / MariaDB 10.6+ / PostgreSQL 13+
-   **PHP**: Version 8.1+ dengan ekstensi:
    -   php-mysql/php-pgsql
    -   php-mbstring
    -   php-xml
    -   php-curl
    -   php-zip
    -   php-gd
    -   php-intl
    -   php-bcmath
-   **Node.js**: Version 16+ (untuk frontend assets)
-   **Composer**: Version 2.0+ (PHP dependency manager)
-   **Git**: Version 2.25+ (version control)

#### Client Requirements

-   **Browser Support**:
    -   Google Chrome 90+
    -   Mozilla Firefox 88+
    -   Microsoft Edge 90+
    -   Safari 14+
    -   Mobile browsers (iOS Safari, Chrome Mobile)
-   **JavaScript**: ES6+ support
-   **CSS**: CSS3 dengan Flexbox/Grid support
-   **Local Storage**: Minimum 10MB untuk offline capabilities

#### Development Tools

-   **IDE**: VS Code, PHPStorm, atau Sublime Text
-   **Version Control**: Git dengan GitHub/GitLab
-   **Testing Tools**: PHPUnit, Jest, Cypress
-   **API Testing**: Postman, Insomnia
-   **Database Tools**: phpMyAdmin, DBeaver, MySQL Workbench

#### Third-party Services

-   **AI Service**: Google Gemini API 2.0 Flash
-   **OCR Processing**: Tesseract.js 4.0+
-   **Email Service**: SMTP atau services (SendGrid, Mailgun)
-   **SMS Gateway**: Twilio atau local providers
-   **File Storage**: AWS S3, Google Cloud Storage, atau local storage
-   **CDN**: Cloudflare, AWS CloudFront (optional)

### 0.2 Kebutuhan Hardware

#### Production Server (Minimum)

-   **CPU**: 2 cores (4 cores recommended)
-   **RAM**: 4GB (8GB recommended)
-   **Storage**: 50GB SSD (100GB recommended)
-   **Network**: 100Mbps bandwidth
-   **Uptime**: 99.5% availability

#### Production Server (Recommended for 100+ users)

-   **CPU**: 4-8 cores
-   **RAM**: 16GB
-   **Storage**: 200GB SSD + backup storage
-   **Network**: 1Gbps bandwidth
-   **Load Balancer**: Nginx/HAProxy untuk multiple servers

#### Database Server (Dedicated)

-   **CPU**: 4-8 cores
-   **RAM**: 32GB
-   **Storage**: 500GB SSD dengan RAID 1/10
-   **Network**: 1Gbps dedicated connection
-   **Backup**: Automated daily backups

#### Development Environment

-   **CPU**: 2+ cores
-   **RAM**: 8GB
-   **Storage**: 100GB SSD
-   **Network**: Stable internet connection

#### Client Hardware Requirements

-   **Minimum**:
    -   CPU: 1GHz dual-core
    -   RAM: 2GB
    -   Storage: 500MB free space
    -   Display: 1024x768 resolution
-   **Recommended**:
    -   CPU: 2GHz quad-core
    -   RAM: 4GB
    -   Storage: 1GB free space
    -   Display: 1920x1080 resolution

#### Network Infrastructure

-   **Internet Connection**: Minimum 10Mbps stable connection
-   **Firewall**: Hardware firewall dengan rule-based filtering
-   **SSL Certificate**: Valid SSL certificate (Let's Encrypt atau commercial)
-   **DNS**: Domain name dengan proper DNS configuration
-   **Backup Internet**: Secondary internet connection untuk redundancy

#### Security Hardware

-   **SSL Accelerator**: Hardware SSL offloading (optional)
-   **Intrusion Detection**: IDS/IPS system
-   **Backup Storage**: NAS/SAN untuk data backup
-   **VPN**: Remote access VPN untuk admin

## 1. Kebutuhan Fungsional (Functional Requirements)

### 1.1 Manajemen Anggota 👥

#### FR-ANG-001: Pendaftaran Anggota

-   Sistem harus dapat mendaftarkan anggota baru dengan data lengkap
-   Mendukung upload dan ekstraksi data KTP menggunakan OCR
-   Generate nomor anggota otomatis dengan format unik
-   Validasi data wajib (NIK, nama, alamat, dll)

#### FR-ANG-002: Pengelolaan Data Anggota

-   CRUD (Create, Read, Update, Delete) data anggota
-   Manajemen status anggota (aktif/non-aktif)
-   Pencatatan data ahli waris dan keluarga
-   Update informasi pekerjaan dan kontak

#### FR-ANG-003: Pencarian dan Filter Anggota

-   Pencarian berdasarkan nama, nomor anggota, NIK
-   Filter berdasarkan status, tanggal pendaftaran, wilayah
-   Export data anggota dalam format Excel/PDF

### 1.2 Sistem Simpanan 💰

#### FR-SIM-001: Pencatatan Setoran Simpanan

-   Mendukung 3 jenis simpanan: Pokok, Wajib, Sukarela
-   Validasi minimal setoran sesuai ketentuan koperasi
-   Upload bukti setoran (foto/scan)
-   Generate nomor bukti otomatis

#### FR-SIM-002: Pencatatan Penarikan Simpanan

-   Khusus untuk simpanan pokok dan sukarela
-   Validasi saldo sebelum penarikan
-   Pencatatan biaya administrasi (jika ada)
-   Generate bukti penarikan

#### FR-SIM-003: Monitoring Saldo Simpanan

-   Real-time balance per anggota per jenis simpanan
-   Riwayat transaksi lengkap dengan filter tanggal
-   Laporan simpanan per periode
-   Alert untuk simpanan wajib yang belum terpenuhi

#### FR-SIM-004: Jurnal Otomatis Simpanan

-   Auto-generate jurnal entry untuk setiap transaksi
-   Debit Kas, Kredit Simpanan (setoran)
-   Debit Simpanan, Kredit Kas (penarikan)
-   Integration dengan sistem akuntansi

### 1.3 Sistem Pinjaman 💳

#### FR-PIN-001: Pengajuan Pinjaman

-   Form pengajuan dengan validasi lengkap
-   Generate kode pinjaman unik (format: PNJ + YYMMDD + sequence)
-   Upload dokumen pendukung (opsional)
-   Simulasi angsuran otomatis

#### FR-PIN-002: Workflow Persetujuan Pinjaman

-   Status tracking: Pending → Disetujui/Ditolak
-   Multi-level approval (jika diperlukan)
-   Pencatatan alasan tolak/setuju
-   Notification ke anggota

#### FR-PIN-003: Pencairan Dana Pinjaman

-   Proses pencairan setelah approval
-   Generate jadwal angsuran otomatis
-   Pencatatan metode pencairan (transfer/tunai)
-   Jurnal pencairan: Debit Piutang, Kredit Kas

#### FR-PIN-004: Sistem Angsuran

-   Mendukung berbagai jenis angsuran:
    -   Flat: Bunga tetap per periode
    -   Anuitas: Angsuran tetap, bunga menurun
    -   Persen: Bunga berdasarkan sisa pokok
    -   Jatuh Tempo: Pembayaran di akhir tenor
-   Tracking pembayaran per angsuran
-   Denda keterlambatan (konfigurable)
-   Reminder otomatis untuk jatuh tempo

#### FR-PIN-005: Pelaporan Pinjaman

-   Outstanding loans report
-   Payment history per anggota
-   Delinquency report (pinjaman bermasalah)
-   Portfolio analysis

### 1.4 Transaksi Umum 📊

#### FR-TRX-001: OCR untuk Nota/Invoice

-   Upload gambar nota/struk
-   Ekstraksi data otomatis menggunakan AI
-   Parsing item, quantity, price, tax, discount
-   Koreksi manual hasil ekstraksi

#### FR-TRX-002: Pencatatan Transaksi Multi-Account

-   Journal entry dengan multiple debit/kredit
-   Validasi balance (total debit = total kredit)
-   Pencatatan keterangan dan referensi
-   Upload bukti transaksi

#### FR-TRX-003: Validasi dan Approval Transaksi

-   Server-side validation untuk semua input
-   Approval workflow untuk transaksi besar
-   Audit trail lengkap
-   Rollback capability untuk error

### 1.5 Sistem Akuntansi 📈

#### FR-AKT-001: Chart of Accounts (COA)

-   Struktur akun 5 digit dengan hierarki
-   Kategori: Aktiva, Kewajiban, Ekuitas, Pendapatan, Beban
-   Saldo normal (debit/kredit) per akun
-   Parent-child relationship

#### FR-AKT-002: Jurnal Umum

-   Pencatatan semua transaksi keuangan
-   Double entry accounting system
-   Filter dan search advanced
-   Export jurnal per periode

#### FR-AKT-003: Neraca Keuangan

-   Generate balance sheet otomatis
-   Aktiva vs Kewajiban + Ekuitas
-   Balance check (aktiva = kewajiban + ekuitas)
-   Multi-periode comparison

#### FR-AKT-004: Laporan Laba Rugi (LPU)

-   Pendapatan vs Beban analysis
-   Laba/Rugi bersih calculation
-   Trend analysis per periode
-   Break-even analysis

#### FR-AKT-005: Laporan SHU (Sisa Hasil Usaha)

-   Perhitungan SHU berdasarkan simpanan dan pinjaman
-   Distribusi: Jasa simpanan, jasa pinjaman, cadangan
-   Historical SHU tracking
-   Tax calculation integration

### 1.6 Sistem Laporan 📋

#### FR-LAP-001: Laporan Operasional

-   Daily transaction summary
-   Monthly activity report
-   Member activity tracking
-   Performance dashboard

#### FR-LAP-002: Laporan Keuangan

-   Balance Sheet (Neraca)
-   Profit & Loss (Laba Rugi)
-   Cash Flow Statement
-   Equity Statement

#### FR-LAP-003: Laporan Manajemen

-   Member demographics
-   Loan portfolio analysis
-   Savings trend analysis
-   Risk assessment reports

#### FR-LAP-004: Export dan Integration

-   Export ke PDF, Excel, CSV
-   Scheduled report generation
-   Email distribution
-   API integration untuk external systems

### 1.7 Sistem Keamanan dan User Management 🔒

#### FR-SEC-001: Authentication & Authorization

-   Multi-level user roles (Super Admin, Pengelola, Anggota)
-   Role-based access control (RBAC)
-   Password policy enforcement
-   Session management

#### FR-SEC-002: Audit Trail

-   Logging semua aktivitas user
-   Change tracking untuk data sensitif
-   Compliance reporting
-   Data integrity checks

#### FR-SEC-003: Data Security

-   Data encryption at rest and in transit
-   Secure file upload with virus scanning
-   GDPR compliance untuk data pribadi
-   Backup and disaster recovery

## 2. Kebutuhan Non-Fungsional (Non-Functional Requirements)

### 2.1 Performance (Kinerja)

#### NFR-PERF-001: Response Time

-   Login: < 2 detik
-   Form submission: < 3 detik
-   Report generation: < 10 detik
-   OCR processing: < 30 detik
-   API response: < 1 detik

#### NFR-PERF-002: Throughput

-   Mendukung 100 concurrent users
-   1000 transactions per hour
-   File upload up to 5MB
-   Database queries optimized

#### NFR-PERF-003: Scalability

-   Horizontal scaling capability
-   Database sharding untuk data besar
-   CDN integration untuk static assets
-   Auto-scaling berdasarkan load

### 2.2 Usability (Kegunaan)

#### NFR-USAB-001: User Interface

-   Responsive design (mobile, tablet, desktop)
-   Intuitive navigation dengan breadcrumb
-   Consistent UI/UX patterns
-   Accessibility compliance (WCAG 2.1)

#### NFR-USAB-002: User Experience

-   Step-by-step wizards untuk complex tasks
-   Real-time validation dan feedback
-   Contextual help dan tooltips
-   Multi-language support (Indonesian/English)

#### NFR-USAB-003: Learning Curve

-   Comprehensive user manual
-   In-app tutorials dan walkthroughs
-   Video tutorials untuk fitur kompleks
-   Progressive disclosure of features

### 2.3 Reliability (Keandalan)

#### NFR-REL-001: Availability

-   99.5% uptime SLA
-   24/7 system availability
-   Graceful degradation during maintenance
-   Auto-recovery dari failure

#### NFR-REL-002: Fault Tolerance

-   Redundant servers dan databases
-   Automatic failover mechanisms
-   Data consistency across nodes
-   Error handling dan recovery procedures

#### NFR-REL-003: Data Integrity

-   ACID compliance untuk transactions
-   Data validation at multiple layers
-   Backup verification
-   Corruption detection dan repair

### 2.4 Security (Keamanan)

#### NFR-SEC-001: Authentication

-   Multi-factor authentication (MFA)
-   Secure password hashing (bcrypt)
-   Session timeout configuration
-   Brute force protection

#### NFR-SEC-002: Authorization

-   Principle of least privilege
-   API rate limiting
-   CORS configuration
-   Input sanitization

#### NFR-SEC-003: Data Protection

-   End-to-end encryption
-   Secure API communication (HTTPS/TLS 1.3)
-   Data masking untuk sensitive fields
-   Regular security audits

### 2.5 Maintainability (Dapat Dipelihara)

#### NFR-MAINT-001: Code Quality

-   Clean code principles
-   Comprehensive documentation
-   Unit test coverage > 80%
-   Code review mandatory

#### NFR-MAINT-002: Modularity

-   Microservices architecture
-   Loose coupling between modules
-   Dependency injection
-   Plugin architecture untuk extensibility

#### NFR-MAINT-003: Monitoring & Logging

-   Centralized logging system
-   Performance monitoring
-   Error tracking dan alerting
-   Health check endpoints

### 2.6 Compatibility (Kompatibilitas)

#### NFR-COMP-001: Browser Support

-   Chrome 90+, Firefox 88+, Safari 14+, Edge 90+
-   Mobile browsers (iOS Safari, Chrome Mobile)
-   Progressive Web App (PWA) support
-   Offline capability untuk critical features

#### NFR-COMP-002: Device Support

-   Desktop computers
-   Tablets (iPad, Android tablets)
-   Mobile phones (iOS, Android)
-   Screen readers dan assistive technologies

#### NFR-COMP-003: Integration

-   RESTful API untuk third-party integration
-   Webhook support untuk real-time updates
-   CSV/Excel import/export
-   Email dan SMS gateway integration

### 2.7 Portability (Portabilitas)

#### NFR-PORT-001: Deployment

-   Docker containerization
-   Cloud-native deployment (AWS, GCP, Azure)
-   On-premise deployment support
-   Database migration scripts

#### NFR-PORT-002: Data Migration

-   Legacy system data import
-   Incremental data sync
-   Data transformation tools
-   Rollback capabilities

### 2.8 Legal & Compliance

#### NFR-LEGAL-001: Regulatory Compliance

-   POJK (Peraturan Otoritas Jasa Keuangan)
-   GDPR untuk data privacy
-   Local financial regulations
-   Tax compliance integration

#### NFR-LEGAL-002: Data Retention

-   Configurable data retention policies
-   Automatic data archiving
-   Audit trail untuk compliance
-   Data deletion procedures

### 2.9 Environmental

#### NFR-ENV-001: Energy Efficiency

-   Optimized database queries
-   Efficient caching strategies
-   CDN untuk static assets
-   Green hosting considerations

#### NFR-ENV-002: Resource Usage

-   Memory optimization
-   CPU utilization monitoring
-   Storage optimization
-   Bandwidth management

## 3. Prioritas Implementasi

### High Priority (Must Have)

-   FR-ANG-001, FR-ANG-002 (Core member management)
-   FR-SIM-001, FR-SIM-002, FR-SIM-003 (Essential savings)
-   FR-PIN-001, FR-PIN-002, FR-PIN-003, FR-PIN-004 (Core lending)
-   FR-AKT-001, FR-AKT-002, FR-AKT-003 (Basic accounting)
-   NFR-PERF-001, NFR-SEC-001, NFR-REL-001 (Critical NFRs)

### Medium Priority (Should Have)

-   FR-TRX-001, FR-TRX-002 (Advanced transactions)
-   FR-LAP-001, FR-LAP-002 (Reporting)
-   FR-SEC-001, FR-SEC-002 (Security features)
-   NFR-USAB-001, NFR-MAINT-001 (Usability & maintainability)

### Low Priority (Nice to Have)

-   FR-LAP-003, FR-LAP-004 (Advanced reporting)
-   FR-AKT-004, FR-AKT-005 (Advanced accounting)
-   NFR-COMP-003, NFR-PORT-001 (Integration & portability)
-   NFR-ENV-001, NFR-ENV-002 (Environmental considerations)

## 4. Acceptance Criteria

### Functional Testing

-   All FR-\* requirements must pass acceptance tests
-   Integration testing untuk end-to-end workflows
-   User acceptance testing (UAT) dengan stakeholders

### Non-Functional Testing

-   Performance testing dengan JMeter/LoadRunner
-   Security testing dengan OWASP standards
-   Usability testing dengan real users
-   Compatibility testing across supported platforms

### Documentation

-   User manual dan training materials
-   Technical documentation lengkap
-   API documentation dengan Swagger/OpenAPI
-   Deployment dan maintenance guides
