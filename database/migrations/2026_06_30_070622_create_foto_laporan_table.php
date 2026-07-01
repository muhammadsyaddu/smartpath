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
         Schema::create('foto_laporan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_id')
                  ->constrained('laporan')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->string('nama_file', 255)->comment('Hash/UUID filename');
            $table->string('nama_asli', 255)->comment('Original filename');
            $table->string('path_file', 500)->comment('Relative path from storage');
            $table->string('mime_type', 50);
            $table->unsignedInteger('ukuran_byte');
            $table->smallInteger('lebar_px')->unsigned()->nullable();
            $table->smallInteger('tinggi_px')->unsigned()->nullable();
            $table->boolean('adalah_utama')->default(false);
            $table->tinyInteger('urutan')->unsigned()->default(0);
            $table->timestamps();
            
            $table->index('laporan_id');
            $table->index(['laporan_id', 'adalah_utama']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foto_laporan');
    }
};
