<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('about_experience_label')->nullable();
            $table->string('about_experience_sublabel')->nullable();
            $table->string('hero_primary_btn_text')->nullable();
            $table->string('hero_secondary_btn_text')->nullable();
            $table->string('footer_description')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'about_experience_label',
                'about_experience_sublabel',
                'hero_primary_btn_text',
                'hero_secondary_btn_text',
                'footer_description'
            ]);
        });
    }
};
