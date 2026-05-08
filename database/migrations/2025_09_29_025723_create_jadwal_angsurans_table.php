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
        Schema::create('jadwal_angsuran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pinjaman')->constrained('pinjaman')->cascadeOnDelete();
            $table->string('kode_angsuran')->unique();
            $table->integer('angsuran_ke');
            $table->date('tanggal_jatuh_tempo');
            $table->decimal('jumlah_pokok', 15, 0);
            $table->decimal('jumlah_bunga', 15, 0);
            $table->decimal('jumlah_total', 15, 0);
            $table->enum('status', ['belum', 'pending', 'lunas'])->default('belum');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_angsuran');
    }
};
