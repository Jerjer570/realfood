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
            $table->bigIncrements('id_pesanan');
            $table->string('subtotal');
            $table->string('status')->default('pending');
            $table->foreignId('id_user')->constrained('user', 'id_user')->onDelete('cascade');
            $table->text('alamat_pengiriman');
            $table->string('no_hp');
            $table->string('metode_pembayaran');
            $table->string('ongkos_kirim');
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
