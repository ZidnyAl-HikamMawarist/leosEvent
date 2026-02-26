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
        Schema::table('settings', function (Blueprint $table) {
            $table->string('countdown_tag')->nullable();
            $table->string('countdown_title')->nullable();
            $table->string('countdown_subtitle')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['countdown_tag', 'countdown_title', 'countdown_subtitle']);
        });
    }
};
