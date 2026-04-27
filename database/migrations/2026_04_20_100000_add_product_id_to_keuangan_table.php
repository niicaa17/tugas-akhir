<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('keuangan', function (Blueprint $table) {
            $table->foreignId('product_id')
                ->nullable()
                ->after('umkm_id')
                ->constrained('products')
                ->nullOnDelete();
        });

        $productByUmkm = DB::table('products')
            ->select('id', 'umkm_id')
            ->orderBy('id')
            ->get()
            ->groupBy('umkm_id')
            ->map(fn ($rows) => $rows->first()->id);

        DB::table('keuangan')
            ->select('id', 'umkm_id')
            ->orderBy('id')
            ->chunk(100, function ($records) use ($productByUmkm) {
                foreach ($records as $record) {
                    $productId = $productByUmkm->get($record->umkm_id);

                    if ($productId) {
                        DB::table('keuangan')
                            ->where('id', $record->id)
                            ->update(['product_id' => $productId]);
                    }
                }
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('keuangan', function (Blueprint $table) {
            $table->dropConstrainedForeignId('product_id');
        });
    }
};
