<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('about_tag')->nullable();
            $table->string('about_title')->nullable();
            $table->string('lomba_tag')->nullable();
            $table->string('lomba_title')->nullable();
            $table->text('lomba_subtitle')->nullable();
            $table->string('galeri_tag')->nullable();
            $table->string('galeri_title')->nullable();
            $table->text('galeri_subtitle')->nullable();
            $table->string('faq_tag')->nullable();
            $table->string('faq_title')->nullable();
            $table->text('faq_subtitle')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'about_tag',
                'about_title',
                'lomba_tag',
                'lomba_title',
                'lomba_subtitle',
                'galeri_tag',
                'galeri_title',
                'galeri_subtitle',
                'faq_tag',
                'faq_title',
                'faq_subtitle'
            ]);
        });
    }
};
