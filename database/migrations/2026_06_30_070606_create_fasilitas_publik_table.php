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
        Schema::create('fasilitas_publik', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150);
            $table->enum('jenis', [
                'rumah_sakit', 'puskesmas', 'sekolah', 'perguruan_tinggi',
                'halte', 'stasiun', 'terminal', 'kantor_pemerintah',
                'pasar', 'tempat_ibadah', 'lainnya'
            ]);
            $table->foreignId('wilayah_id')
                  ->nullable()
                  ->constrained('wilayah')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
            $table->string('alamat', 255)->nullable();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->tinyInteger('bobot_vital')->unsigned()->default(50)
                  ->comment('Tingkat kepentingan 0-100');
            $table->enum('sumber_data', ['osm', 'pemerintah', 'manual'])->default('osm');
            $table->string('osm_id', 50)->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
            
            $table->index('jenis');
            $table->index('wilayah_id');
            $table->index(['latitude', 'longitude']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fasilitas_publik');
    }
};
