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
            $table->string('primary_color')->nullable()->default('#712f23');
            $table->string('secondary_color')->nullable()->default('#c5a353');
            $table->string('accent_color')->nullable()->default('#d4af37');
            $table->string('font_family_url')->nullable()->default('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700&display=swap');
            $table->string('theme_slug')->nullable()->default('default');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'primary_color',
                'secondary_color',
                'accent_color',
                'font_family_url',
                'theme_slug',
            ]);
        });
    }
};
