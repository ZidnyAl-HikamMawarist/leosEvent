<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('lombas', function (Blueprint $table) {
            $table->enum('tipe_lomba', ['solo', 'kelompok'])->default('solo')->after('nama_lomba');
            $table->string('whatsapp_panitia')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('lombas', function (Blueprint $table) {
            $table->dropColumn(['tipe_lomba', 'whatsapp_panitia']);
        });
    }
};
