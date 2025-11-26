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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('user')->onDelete('cascade');
            $table->foreignId('id_pedagang')->constrained('pedagang')->onDelete('cascade');
            $table->enum('status', ['proses','siap','selesai','dibatalkan'])->default('proses');
            $table->decimal('total_harga', 10, 2);
            $table->enum('metode_pembayaran', ['cash','ewallet','transfer']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
