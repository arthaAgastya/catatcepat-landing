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
        Schema::create('simpanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_anggota')->constrained('anggota')->cascadeOnDelete();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_account')->constrained('account')->cascadeOnDelete();
            $table->string('nomor_bukti')->unique();
            $table->date('tanggal');
            $table->enum('jenis_transaksi', ['setor', 'tarik'])->default('setor');
            $table->string('keterangan')->nullable();
            $table->decimal('jumlah', 15, 0)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simpanan');
    }
};
