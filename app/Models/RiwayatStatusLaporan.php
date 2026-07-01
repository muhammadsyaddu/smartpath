<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatStatusLaporan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_status_laporan';

    protected $fillable = [
        'laporan_id',
        'diubah_oleh_id',
        'status_sebelumnya',
        'status_baru',
        'keterangan'
    ];

    /**
     * Laporan this status history belongs to
     */
    public function laporan(): BelongsTo
    {
        return $this->belongsTo(Laporan::class, 'laporan_id');
    }

    /**
     * User who changed the status
     */
    public function diubahOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'diubah_oleh_id');
    }

    /**
     * Get status label
     */
    public function getStatusBaruLabelAttribute(): string
    {
        return $this->getStatusLabel($this->status_baru);
    }

    /**
     * Get status sebelumnya label
     */
    public function getStatusSebelumnyaLabelAttribute(): ?string
    {
        return $this->status_sebelumnya ? $this->getStatusLabel($this->status_sebelumnya) : null;
    }

    /**
     * Helper to get status label
     */
    protected function getStatusLabel(string $status): string
    {
        return match ($status) {
            'menunggu_verifikasi' => 'Menunggu Verifikasi',
            'diverifikasi' => 'Terverifikasi',
            'ditolak' => 'Ditolak',
            'dalam_perbaikan' => 'Dalam Perbaikan',
            'selesai' => 'Selesai',
            'diarsipkan' => 'Diarsipkan',
            default => $status,
        };
    }
}