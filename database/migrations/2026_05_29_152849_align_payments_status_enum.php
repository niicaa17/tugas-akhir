<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Tambah nilai 'selesai' dan 'dibatalkan' ke enum payments.status
     * supaya konsisten dengan vocabulary order.status. Sekaligus migrasi
     * data lama (berhasil -> selesai, gagal -> dibatalkan) agar seragam.
     */
    public function up(): void
    {
        // Perluas enum dulu (sertakan nilai lama supaya data lama tidak putus)
        DB::statement("ALTER TABLE payments MODIFY COLUMN status ENUM(
            'pending','berhasil','gagal','selesai','dibatalkan'
        ) NOT NULL DEFAULT 'pending'");

        // Migrasi data lama ke vocabulary baru
        DB::table('payments')->where('status', 'berhasil')->update(['status' => 'selesai']);
        DB::table('payments')->where('status', 'gagal')->update(['status' => 'dibatalkan']);

        // Sempitkan enum ke vocabulary baru saja
        DB::statement("ALTER TABLE payments MODIFY COLUMN status ENUM(
            'pending','selesai','dibatalkan'
        ) NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse: kembalikan ke enum lama dan map balik datanya.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE payments MODIFY COLUMN status ENUM(
            'pending','berhasil','gagal','selesai','dibatalkan'
        ) NOT NULL DEFAULT 'pending'");

        DB::table('payments')->where('status', 'selesai')->update(['status' => 'berhasil']);
        DB::table('payments')->where('status', 'dibatalkan')->update(['status' => 'gagal']);

        DB::statement("ALTER TABLE payments MODIFY COLUMN status ENUM(
            'pending','berhasil','gagal'
        ) NOT NULL DEFAULT 'pending'");
    }
};
