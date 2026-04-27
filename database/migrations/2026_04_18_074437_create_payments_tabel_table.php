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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // Relasi ke orders
            $table->foreignId('order_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->string('metode'); // transfer, e-wallet, dll
            $table->bigInteger('jumlah');

            $table->enum('status', [
                'pending',
                'berhasil',
                'gagal'
            ])->default('pending');

            $table->string('bukti_bayar')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
