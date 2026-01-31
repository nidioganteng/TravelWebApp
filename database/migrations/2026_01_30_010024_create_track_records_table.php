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
        Schema::create('track_records', function (Blueprint $table) {
            $table->id();
            $table->string('city_name'); // Judul Utama (misal: Bromo Mountain)
            $table->text('description');
            $table->year('year'); // Tahun (misal: 2023)
            $table->string('banner_image'); // Path foto untuk banner besar di atas
            $table->string('slug')->unique(); // Untuk URL yang cantik (misal: bromo-mountain-2023)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('track_records');
    }
};
