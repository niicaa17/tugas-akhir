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
        Schema::create('keuangan', function (Blueprint $table) {
            $table->id();

            // Relasi ke UMKM
            $table->foreignId('umkm_id')
                  ->constrained('umkms')
                  ->onDelete('cascade');

            $table->enum('jenis', ['pemasukan', 'pengeluaran']);

            $table->bigInteger('jumlah');
            $table->text('keterangan')->nullable();

            $table->date('tanggal');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keuangan');
    }
};
