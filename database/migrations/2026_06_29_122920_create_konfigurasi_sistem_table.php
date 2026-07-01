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
         Schema::create('konfigurasi_sistem', function (Blueprint $table) {
            $table->id();
            $table->string('kunci', 100)->unique()->comment('Nama parameter unik');
            $table->text('nilai')->comment('Nilai parameter dalam bentuk string');
            $table->enum('tipe_nilai', ['teks', 'angka', 'desimal', 'boolean', 'json'])
                  ->default('teks');
            $table->string('keterangan', 255)->nullable();
            $table->boolean('dapat_diedit_ui')->default(true);
            $table->timestamps();
            
            $table->index('kunci');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konfigurasi_sistem');
    }
};
