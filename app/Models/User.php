<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        'nama_lengkap',
        'email',
        'kata_sandi',
        'nomor_hp',
        'peran',
        'wilayah_id',
        'foto_profil',
        'adalah_disabilitas',
        'jenis_disabilitas',
        'email_terverifikasi',
        'terakhir_masuk',
        'token_reset',
        'token_reset_kadaluarsa',
        'aktif'
    ];

    protected $hidden = [
        'kata_sandi',
        'token_reset',
        'remember_token',
    ];

    protected $casts = [
        'email_terverifikasi' => 'boolean',
        'adalah_disabilitas' => 'boolean',
        'aktif' => 'boolean',
        'terakhir_masuk' => 'datetime',
        'token_reset_kadaluarsa' => 'datetime',
    ];

    /**
     * dapet password untuk user
     */
    public function getAuthPassword(): string
    {
        return $this->kata_sandi;
    }

    /**
     * dapet wilayah untuk user
     */
    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class, 'wilayah_id');
    }

    /**
     * Laporan dibuat user ini
     */
    public function laporanDibuat(): HasMany
    {
        return $this->hasMany(Laporan::class, 'pelapor_id');
    }

    /**
     * Verifikasi performed by this user
     */
    public function verifikasiDilakukan(): HasMany
    {
        return $this->hasMany(VerifikasiLaporan::class, 'admin_id');
    }

    /**
     * Riwayat status changes by this user
     */
    public function riwayatStatus(): HasMany
    {
        return $this->hasMany(RiwayatStatusLaporan::class, 'diubah_oleh_id');
    }

    /**
     * Notifications for this user
     */
    public function notifikasi(): HasMany
    {
        return $this->hasMany(Notifikasi::class, 'penerima_id');
    }

    /**
     * Audit logs by this user
     */
    public function audit(): HasMany
    {
        return $this->hasMany(Audit::class, 'pengguna_id');
    }

    /**
     * Pengaturan prioritas created by this user
     */
    public function pengaturanPrioritas(): HasMany
    {
        return $this->hasMany(PengaturanPrioritas::class, 'dibuat_oleh_id');
    }

    /**
     * Scope for active users
     */
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    /**
     * Scope for specific role
     */
    public function scopePeran($query, string $peran)
    {
        return $query->where('peran', $peran);
    }

    /**
     * Check if user has specific role
     */
    public function hasRole(string $role): bool
    {
        return $this->peran === $role;
    }

    /**
     * Periksa user ini jika Admin
     */
    public function isAdmin(): bool
    {
        return $this->peran === 'administrator';
    }

    /**
     * Periksa jika user adalah Dinas
     */
    public function isDinas(): bool
    {
        return $this->peran === 'dinas';
    }

    /**
     * Periksa jika user adalah warga
     */
    public function isWarga(): bool
    {
        return $this->peran === 'warga';
    }


    //Dapatkan nama route dashboard berdasarkan peran (role)
     
    public function getDashboardRouteName(): string
    {
        return match ($this->peran) {
            'administrator', 'admin' => 'admin.dashboard',
            'dinas'                 => 'dinas.dashboard',
            default                 => 'warga.dashboard',
        };
    }

    /**
     * Dapetin semua nama atribut
     */
    public function getNamaLengkapAttribute(): string
    {
        return $this->attributes['nama_lengkap'];
    }

    /**
     * Get unread notifications count
     */
    public function getNotifikasiBelumDibacaCountAttribute(): int
    {
        return $this->notifikasi()->where('sudah_dibaca', false)->count();
    }
}