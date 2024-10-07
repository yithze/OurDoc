<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('doc_approvals', function (Blueprint $table) {
            $table->id(); // Membuat kolom 'id' dengan auto-increment
            $table->string('name'); // Kolom 'name' untuk nama dokumen
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Menambahkan kolom user_id
            $table->foreignId('folder_id')->constrained()->onDelete('cascade'); // Menambahkan kolom folder_id
            $table->string('document_number'); // Kolom untuk nomor dokumen
            $table->date('date'); // Kolom untuk tanggal
            $table->string('document_storage'); // Kolom untuk menyimpan lokasi dokumen
            $table->binary('file'); // Kolom untuk menyimpan file sebagai BLOB
            $table->json('approvals'); // Kolom untuk menyimpan data approval dalam format JSON
            $table->timestamps(); // Menambahkan kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doc_approval');
    }
};
