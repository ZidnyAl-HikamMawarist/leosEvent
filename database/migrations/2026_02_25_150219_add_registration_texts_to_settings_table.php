<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('reg_tag')->nullable();
            $table->string('reg_title')->nullable();
            $table->text('reg_subtitle')->nullable();
            $table->string('reg_feature_1')->nullable();
            $table->string('reg_feature_2')->nullable();
            $table->string('reg_feature_3')->nullable();
            $table->string('reg_form_title')->nullable();
            $table->string('reg_form_subtitle')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'reg_tag',
                'reg_title',
                'reg_subtitle',
                'reg_feature_1',
                'reg_feature_2',
                'reg_feature_3',
                'reg_form_title',
                'reg_form_subtitle'
            ]);
        });
    }
};
