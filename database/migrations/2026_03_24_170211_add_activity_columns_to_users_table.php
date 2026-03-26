<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->timestamp('last_seen_at')->nullable()->after('remember_token');
        $table->string('last_page', 191)->nullable()->after('last_seen_at');
        $table->string('last_ip', 45)->nullable()->after('last_page');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['last_seen_at', 'last_page', 'last_ip']);
    });
}
};
