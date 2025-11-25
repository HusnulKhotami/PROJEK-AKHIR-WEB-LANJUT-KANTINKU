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
        Schema::table('notifikasi', function (Blueprint $table) {
            // Tambah kolom jika belum ada
            if (!Schema::hasColumn('notifikasi', 'pesanan_id')) {
                $table->foreignId('pesanan_id')->nullable()->constrained('pesanan')->onDelete('cascade');
            }
            if (!Schema::hasColumn('notifikasi', 'tipe')) {
                $table->string('tipe')->default('status_update');
            }
            if (!Schema::hasColumn('notifikasi', 'catatan')) {
                $table->text('catatan')->nullable();
            }
            if (!Schema::hasColumn('notifikasi', 'dibaca')) {
                $table->boolean('dibaca')->default(false);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifikasi', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\Pesanan::class, 'pesanan_id');
            $table->dropColumn(['pesanan_id', 'tipe', 'catatan', 'dibaca']);
        });
    }
};
