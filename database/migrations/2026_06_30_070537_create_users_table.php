<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel users.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('nama_lengkap', 150);

            $table->string('email', 150)
                ->unique();

            /*
             * ID akun Google.
             * Nullable karena akun lokal tidak wajib
             * terhubung dengan Google.
             */
            $table->string('google_id', 255)
                ->nullable()
                ->unique();

            /*
             * Password lokal.
             * Akun Google tetap mendapatkan password acak
             * sehingga struktur autentikasi tetap konsisten.
             */
            $table->string('kata_sandi', 255)
                ->comment('Bcrypt hash');

            $table->string('nomor_hp', 20)
                ->nullable();

            /*
             * Role resmi SmartPath:
             * administrator, dinas, warga.
             */
            $table->enum('peran', [
                'warga',
                'administrator',
                'dinas',
            ])->default('warga');

            /*
             * Wilayah pengguna.
             */
            $table->foreignId('wilayah_id')
                ->nullable()
                ->constrained('wilayah')
                ->onDelete('set null')
                ->onUpdate('cascade');

            /*
             * Profil pengguna.
             */
            $table->string('foto_profil', 255)
                ->nullable();

            $table->boolean('adalah_disabilitas')
                ->default(false);

            $table->string('jenis_disabilitas', 100)
                ->nullable();

            /*
             * Status verifikasi email.
             */
            $table->boolean('email_terverifikasi')
                ->default(false);

            /*
             * Aktivitas login terakhir.
             */
            $table->timestamp('terakhir_masuk')
                ->nullable();

            /*
             * Reset password.
             */
            $table->string('token_reset', 100)
                ->nullable();

            $table->timestamp('token_reset_kadaluarsa')
                ->nullable();

            /*
             * Status akun.
             */
            $table->boolean('aktif')
                ->default(true);

            /*
             * Laravel authentication.
             */
            $table->rememberToken();

            /*
             * Timestamp standar Laravel.
             */
            $table->timestamps();

            /*
             * Soft delete wajib karena User model
             * menggunakan SoftDeletes.
             */
            $table->softDeletes();

            /*
             * Index.
             */
            $table->index('peran');
            $table->index('wilayah_id');
            $table->index('aktif');
        });
    }

    /**
     * Menghapus tabel users.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};