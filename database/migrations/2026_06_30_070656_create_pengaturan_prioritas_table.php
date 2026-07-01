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
         Schema::create('pengaturan_prioritas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dibuat_oleh_id')
                  ->constrained('users')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            $table->string('label', 100);
            $table->decimal('bobot_keparahan', 4, 2);
            $table->decimal('bobot_pelapor', 4, 2);
            $table->decimal('bobot_fasilitas', 4, 2);
            $table->smallInteger('radius_deduplikasi_m')->unsigned()->default(50);
            $table->smallInteger('radius_fasilitas_m')->unsigned()->default(500);
            $table->boolean('adalah_aktif')->default(false);
            $table->text('catatan')->nullable();
            $table->timestamp('berlaku_sejak')->nullable();
            $table->timestamp('berlaku_hingga')->nullable();
            $table->timestamps();
            
            $table->index('adalah_aktif');
            $table->index('dibuat_oleh_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturan_prioritas');
    }
};
