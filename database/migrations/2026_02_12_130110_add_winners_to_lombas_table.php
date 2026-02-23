<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('lombas', function (Blueprint $table) {
            $table->string('juara_1')->nullable()->after('status');
            $table->string('juara_2')->nullable()->after('juara_1');
            $table->string('juara_3')->nullable()->after('juara_2');
        });
    }

    public function down(): void
    {
        Schema::table('lombas', function (Blueprint $table) {
            $table->dropColumn(['juara_1', 'juara_2', 'juara_3']);
        });
    }
};
