<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_participants', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel bookings (Pesanan yang mana?)
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            
            // Data diri penumpang
            $table->string('name');
            $table->enum('category', ['Adult', 'Child'])->default('Adult'); // Dewasa atau Anak
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_participants');
    }
};