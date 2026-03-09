<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration untuk membuat tabel 'user'.
     */
    public function up(): void
    {
        Schema::create('user', function (Blueprint $table) {
            // Menggunakan id_user sebagai Primary Key sesuai Model
            $table->bigIncrements('id_user'); 
            
            // Informasi Akun Dasar
            $table->string('email')->unique();
            $table->string('nama');
            $table->string('password');
            
            // Otoritas & Status
            $table->string('role')->default('user'); // admin atau user
            $table->string('status_email')->default('unverified');
            
            // Informasi Tambahan (Boleh Kosong/Nullable)
            $table->text('alamat')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('foto_profil')->nullable();
            
            // WAJIB: Untuk fitur "Remember Me" pada sistem login Laravel
            $table->rememberToken(); 
            
            // Mencatat waktu created_at dan updated_at
            $table->timestamps();
        });
    }

    /**
     * Batalkan migration (Rollback).
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};