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
        $columns = [
            'about_feature1_title',
            'about_feature1_desc',
            'about_feature1_icon',
            'about_feature2_title',
            'about_feature2_desc',
            'about_feature2_icon',
            'about_feature3_title',
            'about_feature3_desc',
            'about_feature3_icon',
            'about_feature4_title',
            'about_feature4_desc',
            'about_feature4_icon',
            'about_btn_text'
        ];

        Schema::table('settings', function (Blueprint $table) use ($columns) {
            foreach ($columns as $column) {
                if (Schema::hasColumn('settings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->string('about_feature1_title', 100)->nullable();
            $table->text('about_feature1_desc')->nullable();
            $table->string('about_feature1_icon', 100)->nullable();

            $table->string('about_feature2_title', 100)->nullable();
            $table->text('about_feature2_desc')->nullable();
            $table->string('about_feature2_icon', 100)->nullable();

            $table->string('about_feature3_title', 100)->nullable();
            $table->text('about_feature3_desc')->nullable();
            $table->string('about_feature3_icon', 100)->nullable();

            $table->string('about_feature4_title', 100)->nullable();
            $table->text('about_feature4_desc')->nullable();
            $table->string('about_feature4_icon', 100)->nullable();

            $table->string('about_btn_text', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'about_feature1_title',
                'about_feature1_desc',
                'about_feature1_icon',
                'about_feature2_title',
                'about_feature2_desc',
                'about_feature2_icon',
                'about_feature3_title',
                'about_feature3_desc',
                'about_feature3_icon',
                'about_feature4_title',
                'about_feature4_desc',
                'about_feature4_icon',
                'about_btn_text'
            ]);
        });
    }
};
