<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Catat.Cepat - Asisten Keuangan AI UMKM</title>
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/catatcepat.png') }}" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 text-slate-800 font-sans">

    <!-- Navbar -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-blue-900">Catat<span class="text-blue-600">.</span>Cepat</h1>
            <nav class="space-x-6">
                <a href="#fitur" class="text-slate-700 hover:text-blue-700">Fitur</a>
                <a href="#ai" class="text-slate-700 hover:text-blue-700">Teknologi AI</a>
                <a href="#cta" class="text-slate-700 hover:text-blue-700">Coba Gratis</a>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-blue-900 to-blue-700 py-24 text-white">
        <div class="max-w-5xl mx-auto text-center px-4">
            <h2 class="text-4xl md:text-5xl font-extrabold mb-6">
                Catat.Cepat: Selesai dalam 30 Detik,<br />
                Usaha Makin Rapi
            </h2>
            <p class="text-lg md:text-xl text-blue-100 mb-8">
                Unggah struk atau cukup berbicara. Biarkan AI kami yang mencatat keuangan usaha Anda
                secara otomatis, akurat, dan bebas ribet.
            </p>
            <div class="flex justify-center gap-4">
                <a href="#demo"
                    class="bg-white text-blue-800 px-6 py-3 rounded font-semibold hover:bg-blue-100 transition">
                    ▶ Lihat Demo 1 Menit
                </a>
                <a href="#cta"
                    class="border border-white px-6 py-3 rounded font-semibold hover:bg-white hover:text-blue-800 transition">
                    Coba Gratis
                </a>
            </div>
        </div>
    </section>

    <!-- Fitur Section -->
    <section id="fitur" class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <h3 class="text-3xl font-bold text-slate-800 mb-12">
                Semua Pencatatan, Tanpa Ribet
            </h3>

            <div class="grid md:grid-cols-4 gap-8">
                <div class="p-6 bg-slate-50 rounded-lg shadow">
                    <h4 class="font-semibold text-lg text-blue-800 mb-3">
                        📸 Catat dari Foto Struk
                    </h4>
                    <p class="text-slate-600">
                        Foto struk atau kuitansi belanja. AI kami membaca dan langsung mencatat transaksi ke buku kas.
                    </p>
                </div>

                <div class="p-6 bg-slate-50 rounded-lg shadow">
                    <h4 class="font-semibold text-lg text-blue-800 mb-3">
                        🎙️ Input Suara
                    </h4>
                    <p class="text-slate-600">
                        Ucapkan transaksi harian dengan bahasa biasa. Tidak perlu ketik, tidak perlu buka buku.
                    </p>
                </div>

                <div class="p-6 bg-slate-50 rounded-lg shadow">
                    <h4 class="font-semibold text-lg text-blue-800 mb-3">
                        🔄 Keuangan Terpisah Otomatis
                    </h4>
                    <p class="text-slate-600">
                        Pisahkan uang usaha dan pribadi secara otomatis untuk pembukuan yang sehat.
                    </p>
                </div>

                <div class="p-6 bg-slate-50 rounded-lg shadow">
                    <h4 class="font-semibold text-lg text-blue-800 mb-3">
                        📊 Laporan Real-time
                    </h4>
                    <p class="text-slate-600">
                        Pantau arus kas, laba rugi, dan kondisi usaha kapan saja dari satu dashboard.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- AI Section -->
    <section id="ai" class="py-20 bg-slate-100">
        <div class="max-w-5xl mx-auto px-4">
            <h3 class="text-3xl font-bold text-center text-slate-800 mb-12">
                Cara Kerja AI Kami yang Cerdas
            </h3>

            <div class="grid md:grid-cols-2 gap-10">
                <div>
                    <h4 class="text-xl font-semibold text-blue-800 mb-3">
                        👁️ OCR Cerdas (Mata AI)
                    </h4>
                    <p class="text-slate-700">
                        Tidak sekadar membaca teks, OCR kami memahami isi struk:
                        nama barang, jumlah, harga, hingga total transaksi.
                    </p>
                </div>

                <div>
                    <h4 class="text-xl font-semibold text-blue-800 mb-3">
                        👂 Pemahaman Bahasa Alami
                    </h4>
                    <p class="text-slate-700">
                        Ucapkan transaksi dengan bahasa sehari-hari.
                        AI mengubahnya menjadi catatan keuangan yang rapi dan terstruktur.
                    </p>
                </div>

                <div>
                    <h4 class="text-xl font-semibold text-blue-800 mb-3">
                        🧠 Klasifikasi & Analisis
                    </h4>
                    <p class="text-slate-700">
                        Transaksi otomatis dikelompokkan (bahan baku, operasional, penjualan),
                        lengkap dengan insight sederhana untuk pemilik usaha.
                    </p>
                </div>

                <div>
                    <h4 class="text-xl font-semibold text-blue-800 mb-3">
                        🔐 Keamanan & Privasi Data
                    </h4>
                    <p class="text-slate-700">
                        Data keuangan dienkripsi dan disimpan dengan aman.
                        Hak milik data sepenuhnya milik Anda.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section id="cta" class="bg-blue-900 py-16 text-white">
        <div class="max-w-4xl mx-auto text-center px-4">
            <h3 class="text-3xl font-bold mb-4">
                Saatnya Naik Kelas Secara Finansial
            </h3>
            <p class="text-blue-100 mb-8">
                Stop buang waktu dengan pencatatan manual.
                Bangun keuangan usaha yang rapi, transparan, dan siap berkembang.
            </p>
            <a href="#"
                class="bg-white text-blue-900 px-8 py-4 rounded font-semibold hover:bg-blue-100 transition">
                🚀 Coba Catat.Cepat Gratis — Daftar 2 Menit
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white py-8">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <p class="text-slate-700 mb-2">
                © 2025 Catat.Cepat. Asisten Keuangan AI untuk UMKM Indonesia.
            </p>
            <p class="text-slate-500">
                Email: support@catatcepat.id | WhatsApp: 08xx-xxxx-xxxx
            </p>
        </div>
    </footer>

</body>

</html>
