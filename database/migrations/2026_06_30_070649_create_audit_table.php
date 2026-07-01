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
         Schema::create('audit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
            $table->string('aksi', 100);
            $table->string('tabel_terkait', 64)->nullable();
            $table->unsignedInteger('id_terkait')->nullable();
            $table->json('data_lama')->nullable();
            $table->json('data_baru')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->string('keterangan', 255)->nullable();
            $table->timestamps();
            
            $table->index('pengguna_id');
            $table->index('aksi');
            $table->index(['tabel_terkait', 'id_terkait']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit');
    }
};
