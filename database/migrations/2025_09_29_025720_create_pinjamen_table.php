<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pinjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_anggota')->constrained('anggota')->cascadeOnDelete();
            $table->string('kode_pinjaman')->unique();
            $table->date('tanggal_pengajuan');
            $table->decimal('jumlah_pinjaman', 15, 0);
            $table->integer('tenor'); // lama pinjaman (dalam hari/minggu/bulan sesuai jenis angsuran)

            // Jenis Angsuran
            $table->enum('jenis_angsuran', ['harian', 'mingguan', 'bulanan', 'jatuh_tempo']);

            // Besaran Jasa Pinjaman
            $table->enum('besaran_jasa', ['flat', 'anuitas', 'persen'])->default('flat');

            $table->decimal('bunga_persen', 5, 2)->default(0); // % bunga
            $table->decimal('suku_bunga_tahunan', 5, 2)->nullable();
            $table->decimal('biaya_admin', 15, 0)->default(0);

            $table->date('tanggal_disetujui')->nullable();

            $table->enum('status', ['pending', 'disetujui', 'ditolak', 'lunas'])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinjaman');
    }
};
