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
            $table->string('city_name'); 
            $table->text('description');
            $table->year('year'); 
            $table->string('banner_image'); 
            $table->string('slug')->unique(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('track_records');
    }
};
