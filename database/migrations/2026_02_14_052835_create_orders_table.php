<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Kode ini dikonversi dari interface Order di index.ts
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // Menghubungkan pesanan ke ID User yang memesan
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            
            $table->decimal('total', 12, 2); // Total bayar
            
            // Status pesanan sesuai enum di index.ts
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');
            
            $table->text('deliveryAddress'); // Alamat pengiriman
            $table->string('phone'); // Nomor telepon untuk pesanan
            $table->timestamps(); // Mencatat waktu pesanan dibuat (createdAt)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};