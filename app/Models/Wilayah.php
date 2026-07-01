<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wilayah extends Model
{
    use HasFactory;

    protected $table = 'wilayah';

    protected $fillable = [
        'induk_id',
        'nama',
        'level',
        'kode_bps',
        'latitude',
        'longitude',
        'aktif'
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    /**
     * Parent wilayah (self-reference)
     */
    public function induk(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class, 'induk_id');
    }

    /**
     * Child wilayah (daerah bawahan)
     */
    public function anak(): HasMany
    {
        return $this->hasMany(Wilayah::class, 'induk_id');
    }

    /**
     * Users in this wilayah
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'wilayah_id');
    }

    /**
     * Laporan in this wilayah
     */
    public function laporan(): HasMany
    {
        return $this->hasMany(Laporan::class, 'wilayah_id');
    }

    /**
     * Fasilitas publik in this wilayah
     */
    public function fasilitasPublik(): HasMany
    {
        return $this->hasMany(FasilitasPublik::class, 'wilayah_id');
    }

    /**
     * Scope for active wilayah
     */
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    /**
     * Scope for specific level
     */
    public function scopeLevel($query, string $level)
    {
        return $query->where('level', $level);
    }

    /**
     * Get full hierarchical name
     */
    public function getNamaLengkapAttribute(): string
    {
        $nama = $this->nama;
        if ($this->induk) {
            return $this->induk->nama_lengkap . ' > ' . $nama;
        }
        return $nama;
    }

    /**
     * Get children recursively
     */
    public function getAnakRecursive(): array
    {
        $children = [];
        foreach ($this->anak as $child) {
            $children[] = $child;
            $children = array_merge($children, $child->getAnakRecursive());
        }
        return $children;
    }
}