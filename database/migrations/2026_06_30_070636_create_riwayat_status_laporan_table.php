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
         Schema::create('riwayat_status_laporan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_id')
                  ->constrained('laporan')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreignId('diubah_oleh_id')
                  ->constrained('users')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->enum('status_sebelumnya', [
                'menunggu_verifikasi',
                'diverifikasi',
                'ditolak',
                'dalam_perbaikan',
                'selesai',
                'diarsipkan'
            ])->nullable();
            $table->enum('status_baru', [
                'menunggu_verifikasi',
                'diverifikasi',
                'ditolak',
                'dalam_perbaikan',
                'selesai',
                'diarsipkan'
            ]);
            $table->string('keterangan', 255)->nullable();
            $table->timestamps();
            
            $table->index('laporan_id');
            $table->index('diubah_oleh_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_status_laporan');
    }
};
