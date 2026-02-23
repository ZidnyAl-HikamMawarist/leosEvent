<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('logo')->nullable();
            $table->string('navbar_element')->nullable();
            $table->string('top_image')->nullable();
            $table->string('side_image_left')->nullable();
            $table->string('side_image_right')->nullable();
            $table->string('footer_image')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'logo',
                'navbar_element',
                'top_image',
                'side_image_left',
                'side_image_right',
                'footer_image',
            ]);
        });
    }
};
