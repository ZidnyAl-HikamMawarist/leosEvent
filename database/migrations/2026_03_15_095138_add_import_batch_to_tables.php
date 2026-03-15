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
            $table->string('import_batch')->nullable()->after('status');
        });

        Schema::table('participants', function (Blueprint $table) {
            $table->string('import_batch')->nullable()->after('source');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropColumn('import_batch');
        });

        Schema::table('participants', function (Blueprint $table) {
            $table->dropColumn('import_batch');
        });
    }
};
