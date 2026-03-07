<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('school_logo')->nullable()->after('logo');
            $table->string('nama_sekolah')->nullable()->after('school_logo');
            $table->string('organizer_text')->nullable()->after('nama_sekolah');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['school_logo', 'nama_sekolah', 'organizer_text']);
        });
    }
};
