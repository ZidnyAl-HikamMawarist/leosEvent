<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('text_primary_color')->default('#ffffff')->after('primary_color');
            $table->string('text_secondary_color')->default('#ffffff')->after('secondary_color');
            $table->string('body_text_color')->default('#fdf6f0')->after('accent_color');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['text_primary_color', 'text_secondary_color', 'body_text_color']);
        });
    }
};
