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
        Schema::create('detail_pengelola', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade')->unique();
            $table->string('nik')->unique();
            $table->string('telepon');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('alamat');
            $table->string('kecamatan');
            $table->string('kabupaten_kotamadya');
            $table->string('provinsi');

            // Keterangan Diri
            $table->date('tanggal_diangkat');
            $table->string('nomor_induk_kepegawaian')->unique();
            $table->string('nomor_telepon_hp');
            $table->string('status_keluarga')->nullable();
            $table->integer('jumlah_tanggungan')->nullable();
            $table->string('nama_ahli_waris')->nullable();
            $table->string('hubungan_ahli_waris')->nullable();
            $table->string('jabatan');

            // Dokumen Diri (path file)
            $table->string('foto')->nullable();
            $table->string('ktp')->nullable();
            $table->string('tanda_tangan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pengelola');
    }
};
