<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_reference')->unique();
            
            // Relasi ke User yang beli
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Relasi ke Produk/Tur yang dibeli
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            
            $table->integer('quantity'); // Jumlah tiket yang dibeli
            $table->decimal('total_price', 10, 2); // Harga total (Harga Produk x Quantity)
            
            // Status pembayaran: unpaid, paid, cancelled
            $table->enum('status', ['unpaid', 'paid', 'cancelled'])->default('unpaid'); 
            
            // Untuk menyimpan ID dari Stripe nanti (Sangat penting!)
            $table->string('stripe_session_id')->nullable(); 
            
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};