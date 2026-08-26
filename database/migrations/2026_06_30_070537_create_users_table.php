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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('email')->unique();
            $table->string('google_id')->nullable()->unique(); // Kolom Google ID ditambahkan di sini
            $table->string('kata_sandi');
            $table->string('nomor_hp')->nullable();
            $table->enum('peran', ['admin', 'dinas', 'warga'])->default('warga');
            $table->boolean('email_terverifikasi')->default(false);
            $table->boolean('aktif')->default(true);
            $table->timestamp('terakhir_masuk')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};