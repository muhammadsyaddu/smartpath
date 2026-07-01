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
        Schema::create('verifikasi_laporan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_id')
                  ->constrained('laporan')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreignId('admin_id')
                  ->constrained('users')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->enum('keputusan', ['disetujui', 'ditolak', 'dikembalikan']);
            $table->text('catatan_admin')->nullable();
            $table->foreignId('kategori_koreksi')
                  ->nullable()
                  ->constrained('kategori_hambatan')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
            $table->timestamps();
            
            $table->index('laporan_id');
            $table->index('admin_id');
            $table->index('keputusan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verifikasi_laporan');
    }
};
