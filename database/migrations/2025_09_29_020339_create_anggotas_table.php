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
        Schema::create('anggota', function (Blueprint $table) {
            $table->id(); // id_anggota
            $table->string('nomor_anggota')->unique(); // NIK atau nomor anggota
            $table->string('nama');
            $table->enum('jenis_kelamin', ['L', 'P']); // Laki-laki / Perempuan
            $table->string('alamat')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('telepon')->nullable(); // Nomor Telepon / HP
            $table->string('status_keluarga')->nullable(); // Status Keluarga
            $table->unsignedTinyInteger('jumlah_tanggungan')->default(0);
            $table->string('nama_ahli_waris')->nullable();
            $table->string('hubungan_ahli_waris')->nullable();
            $table->string('telepon_ahli_waris')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('alamat_pekerjaan')->nullable();
            $table->date('tanggal_pendaftaran')->default(now());

            // Rekening Simpanan
            $table->string('rekening_simpanan_pokok')->nullable();
            $table->string('rekening_simpanan_wajib')->nullable();
            $table->string('rekening_simpanan_sukarela')->nullable();

            $table->enum('status', ['aktif', 'non-aktif'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggota');
    }
};
