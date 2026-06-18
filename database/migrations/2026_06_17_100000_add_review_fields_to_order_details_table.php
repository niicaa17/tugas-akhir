<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->unsignedTinyInteger('rating')->nullable()->after('harga');
            $table->text('review_komentar')->nullable()->after('rating');
            $table->string('review_foto')->nullable()->after('review_komentar');
            $table->timestamp('reviewed_at')->nullable()->after('review_foto');
        });
    }

    public function down(): void
    {
        Schema::table('order_details', function (Blueprint $table) {
            $table->dropColumn(['rating', 'review_komentar', 'review_foto', 'reviewed_at']);
        });
    }
};
