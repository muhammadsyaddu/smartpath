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
            $table->bigIncrements('konfigurasi_id');
            $table->string('kunci', 100)->uniqiue();
            $table->string('nilai', 255);
            $table->string('deskripsi')->nullable();
            $table->timestamps();
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
