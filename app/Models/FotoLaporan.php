<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FotoLaporan extends Model
{
    use HasFactory;

    protected $table = 'foto_laporan';

    protected $fillable = [
        'laporan_id',
        'nama_file',
        'nama_asli',
        'path_file',
        'mime_type',
        'ukuran_byte',
        'lebar_px',
        'tinggi_px',
        'adalah_utama',
        'urutan'
    ];

    protected $casts = [
        'ukuran_byte' => 'integer',
        'lebar_px' => 'integer',
        'tinggi_px' => 'integer',
        'adalah_utama' => 'boolean',
        'urutan' => 'integer',
    ];

    /**
     * Laporan this photo belongs to
     */
    public function laporan(): BelongsTo
    {
        return $this->belongsTo(Laporan::class, 'laporan_id');
    }

    /**
     * Scope for main photo
     */
    public function scopeUtama($query)
    {
        return $query->where('adalah_utama', true);
    }

    /**
     * Get full storage URL
     */
    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path_file);
    }

    /**
     * Get file size in human readable format
     */
    public function getUkuranFormattedAttribute(): string
    {
        $bytes = $this->ukuran_byte;
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }
}