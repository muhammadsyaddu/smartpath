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
            $table->id();
            $table->string('nama', 100);
            $table->string('slug', 100)->unique();
            $table->text('keterangan')->nullable();
            $table->tinyInteger('bobot_keparahan')->unsigned()->default(50)
                  ->comment('Skor keparahan 0-100');
            $table->string('ikon', 100)->nullable();
            $table->char('warna_penanda', 7)->nullable();
            $table->tinyInteger('urutan_tampil')->unsigned()->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
            
            $table->index('aktif');
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
