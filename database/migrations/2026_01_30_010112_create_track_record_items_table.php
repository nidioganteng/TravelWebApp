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
            $table->foreignId('track_record_id')->constrained('track_records')->onDelete('cascade');
            $table->string('title'); 
            $table->text('description'); 
            $table->string('image'); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('track_record_items');
    }
};
