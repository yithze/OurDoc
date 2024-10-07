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
        Schema::create('folders', function (Blueprint $table) {
            $table->id(); // Membuat kolom 'id' dengan auto-increment
            $table->string('name'); // Kolom 'name' untuk nama folder
            $table->string('description')->nullable(); // Kolom 'description' untuk deskripsi folder, nullable
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Menambahkan kolom user_id
            $table->timestamps(); // Menambahkan kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('folders');
    }
};

