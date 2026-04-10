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
        Schema::table('pendaftarans', function (Blueprint $table) {
            // Index untuk mempercepat query whereExists pada PageController
            $table->index(['nama', 'sekolah', 'lomba_id'], 'pendaftarans_search_idx');
        });

        Schema::table('participants', function (Blueprint $table) {
            // Index untuk sinkronisasi penghapusan dan pencarian voting
            $table->index(['nama', 'sekolah', 'lomba_id'], 'participants_search_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropIndex('pendaftarans_search_idx');
        });

        Schema::table('participants', function (Blueprint $table) {
            $table->dropIndex('participants_search_idx');
        });
    }
};
