<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriHambatan extends Model
{
    use HasFactory;

    protected $table = 'kategori_hambatan';

    protected $fillable = [
        'nama',
        'slug',
        'keterangan',
        'bobot_keparahan',
        'ikon',
        'warna_penanda',
        'urutan_tampil',
        'aktif'
    ];

    protected $casts = [
        'bobot_keparahan' => 'integer',
        'urutan_tampil' => 'integer',
        'aktif' => 'boolean',
    ];

    /**
     * Laporan with this category
     */
    public function laporan(): HasMany
    {
        return $this->hasMany(Laporan::class, 'kategori_hambatan_id');
    }

    /**
     * Verifikasi with category correction
     */
    public function verifikasiKoreksi(): HasMany
    {
        return $this->hasMany(VerifikasiLaporan::class, 'kategori_koreksi');
    }

    /**
     * Scope for active categories
     */
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    /**
     * Scope ordered by display order
     */
    public function scopeUrutTampil($query)
    {
        return $query->orderBy('urutan_tampil');
    }

    /**
     * Get severity level label
     */
    public function getTingkatKeparahanAttribute(): string
    {
        return match (true) {
            $this->bobot_keparahan >= 80 => 'Sangat Berat',
            $this->bobot_keparahan >= 60 => 'Berat',
            $this->bobot_keparahan >= 40 => 'Sedang',
            default => 'Ringan',
        };
    }
}