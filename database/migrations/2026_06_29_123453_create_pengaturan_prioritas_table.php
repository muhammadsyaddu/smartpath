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
            $table->bigIncrements('prioritas_id');
            $table->string('nama_prioritas', 100);
            $table->decimal('bobot', 5, 2);
            $table->text('deskripsi')->nullable(); 
            $table->timestamps();
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
