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
        // Gunakan nama 'foods' agar otomatis terbaca oleh Model Food
        Schema::create('food', function (Blueprint $table) {
            $table->id(); 
            $table->string('name'); 
            $table->text('description'); 
            $table->decimal('price', 12, 2); 
            $table->string('image'); 
            $table->float('rating')->default(0); 
            $table->integer('calories')->nullable(); 
            $table->string('category'); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food');
    }
};