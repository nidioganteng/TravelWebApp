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
        Schema::table('users', function (Blueprint $table) {
            $table->string('gender')->nullable()->after('email');
            $table->string('city')->nullable()->after('gender');
            // Jika kamu ingin simpan pisah-pisah sesuai input:
            $table->integer('birth_day')->nullable();
            $table->string('birth_month')->nullable();
            $table->integer('birth_year')->nullable();
            
            // ATAU jika di database kamu maunya satu kolom 'birthdate' (DATE),
            // kamu perlu logic tambahan di controller untuk menggabungkannya.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
