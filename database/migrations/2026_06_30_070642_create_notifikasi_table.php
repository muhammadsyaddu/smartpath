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
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penerima_id')
                  ->constrained('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreignId('laporan_id')
                  ->nullable()
                  ->constrained('laporan')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->enum('jenis', [
                'laporan_diterima',
                'laporan_diverifikasi',
                'laporan_ditolak',
                'laporan_dikembalikan',
                'laporan_dalam_perbaikan',
                'laporan_selesai',
                'duplikat_digabung',
                'sistem'
            ]);
            $table->string('judul', 150);
            $table->text('pesan');
            $table->string('tautan', 255)->nullable();
            $table->boolean('sudah_dibaca')->default(false);
            $table->timestamp('dibaca_pada')->nullable();
            $table->timestamps();
            
            $table->index(['penerima_id', 'sudah_dibaca']);
            $table->index('laporan_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
