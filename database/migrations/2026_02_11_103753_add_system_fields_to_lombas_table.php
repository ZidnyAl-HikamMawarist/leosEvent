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
        Schema::table('lombas', function (Blueprint $table) {
            $table->string('slug')->unique()->after('nama_lomba')->nullable();
            $table->year('event_year')->nullable()->after('slug');
            $table->datetime('event_start')->nullable()->after('tanggal_pelaksanaan');
            $table->datetime('event_end')->nullable()->after('event_start');
            $table->boolean('is_save_the_date_active')->default(false)->after('status');
            $table->decimal('harga_tiket', 15, 2)->default(0)->after('is_save_the_date_active');
            $table->string('lokasi')->nullable()->after('harga_tiket');
            $table->text('juklak_juknis_link')->nullable()->after('lokasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lombas', function (Blueprint $table) {
            $table->dropColumn('slug');
            $table->dropColumn('event_year');
            $table->dropColumn('event_start');
            $table->dropColumn('event_end');
            $table->dropColumn('is_save_the_date_active');
            $table->dropColumn('harga_tiket');
            $table->dropColumn('lokasi');
            $table->dropColumn('juklak_juknis_link');
        });
    }
};
