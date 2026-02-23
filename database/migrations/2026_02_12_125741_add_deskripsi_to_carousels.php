<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('carousels', function (Blueprint $table) {
            if (!Schema::hasColumn('carousels', 'deskripsi')) {
                $table->text('deskripsi')->nullable()->after('judul');
            }
            if (!Schema::hasColumn('carousels', 'link_url')) {
                $table->string('link_url')->nullable()->after('deskripsi');
            }
        });
    }

    public function down(): void
    {
        Schema::table('carousels', function (Blueprint $table) {
            $table->dropColumn(['deskripsi', 'link_url']);
        });
    }
};
