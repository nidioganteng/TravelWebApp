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
        Schema::create('track_record_items', function (Blueprint $table) {
            $table->id();
            // KUNCI PENTING: Ini menghubungkan item ke track record induknya.
            // onDelete('cascade') artinya kalau induknya dihapus, item-item ini ikut terhapus otomatis.
            $table->foreignId('track_record_id')->constrained('track_records')->onDelete('cascade');
            $table->string('title'); // Judul per item cerita
            $table->text('description'); // Deskripsi lengkap per item
            $table->string('image'); // Foto per item
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('track_record_items');
    }
};
