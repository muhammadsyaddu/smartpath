<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap', 150);
            $table->string('email', 150)->unique();
            $table->string('kata_sandi', 255)->comment('Bcrypt hash');
            $table->string('nomor_hp', 20)->nullable();
            $table->enum('peran', ['warga', 'administrator', 'dinas'])->default('warga');
            $table->foreignId('wilayah_id')
                  ->nullable()
                  ->constrained('wilayah')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
            $table->string('foto_profil', 255)->nullable();
            $table->boolean('adalah_disabilitas')->default(false);
            $table->string('jenis_disabilitas', 100)->nullable();
            $table->boolean('email_terverifikasi')->default(false);
            $table->timestamp('terakhir_masuk')->nullable();
            $table->string('token_reset', 100)->nullable();
            $table->timestamp('token_reset_kadaluarsa')->nullable();
            $table->boolean('aktif')->default(true);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('peran');
            $table->index('wilayah_id');
        });

        // Create admin user
        DB::table('users')->insert([
            'nama_lengkap' => 'Administrator SmartPath',
            'email' => 'admin@smartpath.id',
            'kata_sandi' => Hash::make('SmartPath2026!'),
            'peran' => 'administrator',
            'email_terverifikasi' => true,
            'aktif' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};