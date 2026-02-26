<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('lombas', function (Blueprint $table) {
            $table->string('link_grup_wa')->nullable()->after('whatsapp_panitia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lombas', function (Blueprint $table) {
            $table->dropColumn('link_grup_wa');
        });
    }
};
