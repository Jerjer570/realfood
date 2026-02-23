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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            
            // 1. Menghubungkan ke tabel orders (Pastikan tabel orders sudah ada)
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            
            // 2. PERBAIKAN: Menghubungkan ke 'foods', bukan 'food'
            $table->foreignId('food_id')->constrained('food')->onDelete('cascade');
            
            $table->integer('quantity');
            
            // Menyimpan harga saat transaksi terjadi (snapshot)
            $table->decimal('price', 12, 2); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};