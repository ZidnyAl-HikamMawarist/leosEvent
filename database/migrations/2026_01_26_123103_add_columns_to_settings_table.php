<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('nama_event')->nullable();
            $table->text('deskripsi_event')->nullable();
            $table->string('footer_text')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['nama_event', 'deskripsi_event', 'footer_text']);
        });
    }
};
