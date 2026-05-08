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
        Schema::table('account', function (Blueprint $table) {

            // Tambah kolom id_category (nullable agar tidak error saat migrasi)
            $table->unsignedBigInteger('id_category')
                ->nullable()
                ->after('id');

            // Foreign key ke tabel account_categories
            $table->foreign('id_category')
                ->references('id')
                ->on('account_categories')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('account', function (Blueprint $table) {
            $table->dropForeign(['id_category']);
            $table->dropColumn('id_category');
        });
    }
};
