<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->datetime('event_start')->nullable()->after('deskripsi_event');
            $table->datetime('event_end')->nullable()->after('event_start');
            $table->string('event_status')->default('upcoming')->after('event_end'); // upcoming, ongoing, finished
            $table->boolean('is_save_the_date_active')->default(true)->after('event_status');
            $table->boolean('auto_update_status')->default(true)->after('is_save_the_date_active');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['event_start', 'event_end', 'event_status', 'is_save_the_date_active', 'auto_update_status']);
        });
    }
};
