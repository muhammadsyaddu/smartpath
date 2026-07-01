<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'notifikasi';

    protected $fillable = [
        'penerima_id',
        'laporan_id',
        'jenis',
        'judul',
        'pesan',
        'tautan',
        'sudah_dibaca',
        'dibaca_pada'
    ];

    protected $casts = [
        'sudah_dibaca' => 'boolean',
        'dibaca_pada' => 'datetime',
    ];

    /**
     * Penerima notifikasi
     */
    public function penerima(): BelongsTo
    {
        return $this->belongsTo(User::class, 'penerima_id');
    }

    /**
     * Laporan terkait (if any)
     */
    public function laporan(): BelongsTo
    {
        return $this->belongsTo(Laporan::class, 'laporan_id');
    }

    /**
     * Scope for unread notifications
     */
    public function scopeBelumDibaca($query)
    {
        return $query->where('sudah_dibaca', false);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(): void
    {
        $this->update([
            'sudah_dibaca' => true,
            'dibaca_pada' => now(),
        ]);
    }

    /**
     * Get jenis label
     */
    public function getJenisLabelAttribute(): string
    {
        return match ($this->jenis) {
            'laporan_diterima' => 'Laporan Diterima',
            'laporan_diverifikasi' => 'Laporan Diverifikasi',
            'laporan_ditolak' => 'Laporan Ditolak',
            'laporan_dikembalikan' => 'Laporan Dikembalikan',
            'laporan_dalam_perbaikan' => 'Laporan Dalam Perbaikan',
            'laporan_selesai' => 'Laporan Selesai',
            'duplikat_digabung' => 'Duplikat Digabung',
            'sistem' => 'Notifikasi Sistem',
            default => $this->jenis,
        };
    }
}