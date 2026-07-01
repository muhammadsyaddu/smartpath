<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VerifikasiLaporan extends Model
{
    use HasFactory;

    protected $table = 'verifikasi_laporan';

    protected $fillable = [
        'laporan_id',
        'admin_id',
        'keputusan',
        'catatan_admin',
        'kategori_koreksi'
    ];

    /**
     * Laporan being verified
     */
    public function laporan(): BelongsTo
    {
        return $this->belongsTo(Laporan::class, 'laporan_id');
    }

    /**
     * Admin who performed verification
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Corrected category (if any)
     */
    public function kategoriKoreksi(): BelongsTo
    {
        return $this->belongsTo(KategoriHambatan::class, 'kategori_koreksi');
    }

    /**
     * Get keputusan label
     */
    public function getKeputusanLabelAttribute(): string
    {
        return match ($this->keputusan) {
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
            'dikembalikan' => 'Dikembalikan',
            default => $this->keputusan,
        };
    }

    /**
     * Get keputusan badge color
     */
    public function getKeputusanWarnaAttribute(): string
    {
        return match ($this->keputusan) {
            'disetujui' => 'success',
            'ditolak' => 'danger',
            'dikembalikan' => 'warning',
            default => 'secondary',
        };
    }
}