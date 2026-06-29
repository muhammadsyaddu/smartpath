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
        Schema::create('kategori_hambatan', function (Blueprint $table) {
            $table->id('id_kategori');
            $table->string('nama');
            $table->string('bobot_keparahan');
            $table->string('warna_hex');
            $tabel->text('deskripsi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_hambatan');
    }
};
