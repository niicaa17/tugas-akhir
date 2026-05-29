<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('penerima_nama')->nullable()->after('user_id');
            $table->string('alamat_lengkap')->nullable()->after('penerima_nama');
            $table->string('kota')->nullable()->after('alamat_lengkap');
            $table->string('kode_pos')->nullable()->after('kota');
            $table->string('nomor_telepon')->nullable()->after('kode_pos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'penerima_nama',
                'alamat_lengkap',
                'kota',
                'kode_pos',
                'nomor_telepon'
            ]);
        });
    }
};
