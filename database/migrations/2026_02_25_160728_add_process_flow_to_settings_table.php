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
            $table->string('process_title1')->nullable();
            $table->text('process_desc1')->nullable();
            $table->string('process_icon1')->nullable();

            $table->string('process_title2')->nullable();
            $table->text('process_desc2')->nullable();
            $table->string('process_icon2')->nullable();

            $table->string('process_title3')->nullable();
            $table->text('process_desc3')->nullable();
            $table->string('process_icon3')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'process_title1',
                'process_desc1',
                'process_icon1',
                'process_title2',
                'process_desc2',
                'process_icon2',
                'process_title3',
                'process_desc3',
                'process_icon3'
            ]);
        });
    }
};
