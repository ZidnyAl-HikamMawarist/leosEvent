<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('lombas', function (Blueprint $table) {
            $table->time('event_start')->nullable()->change();
            $table->time('event_end')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('lombas', function (Blueprint $table) {
            $table->datetime('event_start')->nullable()->change();
            $table->datetime('event_end')->nullable()->change();
        });
    }
};
