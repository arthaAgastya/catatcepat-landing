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
        Schema::create('files', function (Blueprint $table) {
            $table->id();

            // Relasi dinamis polymorphic
            $table->nullableMorphs('fileable'); // fileable_id & fileable_type

            // Informasi file
            $table->string('name');                    // Nama file (misalnya: invoice.pdf)
            $table->string('path');                    // Path relatif di storage
            $table->string('mime_type')->nullable();   // Tipe MIME, contoh: application/pdf
            $table->unsignedBigInteger('size')->nullable(); // Ukuran file (dalam byte)
            $table->text('description')->nullable();   // Deskripsi file (opsional)
            $table->enum('type', ['image', 'document', 'other'])->default('other'); // Kategori file

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
