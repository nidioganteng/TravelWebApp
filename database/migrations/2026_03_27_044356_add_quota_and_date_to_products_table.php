<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Tambahkan kolom kuota tiket (angka bulat)
            $table->integer('ticket_quota')->default(0)->after('product_price');
            // Tambahkan kolom tanggal & waktu keberangkatan
            $table->dateTime('departure_date')->nullable()->after('ticket_quota');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['ticket_quota', 'departure_date']);
        });
    }
};