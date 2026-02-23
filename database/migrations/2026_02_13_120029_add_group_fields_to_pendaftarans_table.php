<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->string('nama_pembina')->nullable()->after('no_wa');
            $table->string('no_hp_pembina')->nullable()->after('nama_pembina');
            $table->string('nama_pemimpin_regu')->nullable()->after('no_hp_pembina');
            $table->string('no_hp_pemimpin_regu')->nullable()->after('nama_pemimpin_regu');
            $table->string('formulir_pendaftaran')->nullable()->after('no_hp_pemimpin_regu');
            $table->enum('metode_pembayaran', ['transfer', 'tunai'])->default('transfer')->after('formulir_pendaftaran');
        });
    }

    public function down(): void
    {
        Schema::table('pendaftarans', function (Blueprint $table) {
            $table->dropColumn([
                'nama_pembina',
                'no_hp_pembina',
                'nama_pemimpin_regu',
                'no_hp_pemimpin_regu',
                'formulir_pendaftaran',
                'metode_pembayaran'
            ]);
        });
    }
};
