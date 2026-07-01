<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengaturanPrioritas extends Model
{
    use HasFactory;

    protected $table = 'pengaturan_prioritas';

    protected $fillable = [
        'dibuat_oleh_id',
        'label',
        'bobot_keparahan',
        'bobot_pelapor',
        'bobot_fasilitas',
        'radius_deduplikasi_m',
        'radius_fasilitas_m',
        'adalah_aktif',
        'catatan',
        'berlaku_sejak',
        'berlaku_hingga'
    ];

    protected $casts = [
        'bobot_keparahan' => 'decimal:2',
        'bobot_pelapor' => 'decimal:2',
        'bobot_fasilitas' => 'decimal:2',
        'radius_deduplikasi_m' => 'integer',
        'radius_fasilitas_m' => 'integer',
        'adalah_aktif' => 'boolean',
        'berlaku_sejak' => 'datetime',
        'berlaku_hingga' => 'datetime',
    ];

    /**
     * User who created this configuration
     */
    public function dibuatOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibuat_oleh_id');
    }

    /**
     * Scope for active configuration
     */
    public function scopeAktif($query)
    {
        return $query->where('adalah_aktif', true);
    }

    /**
     * Get the active configuration
     */
    public static function getActive()
    {
        return static::where('adalah_aktif', true)->first();
    }

    /**
     * Activate this configuration (deactivate others)
     */
    public function activate(): void
    {
        static::where('adalah_aktif', true)->update(['adalah_aktif' => false]);
        $this->update([
            'adalah_aktif' => true,
            'berlaku_sejak' => now(),
        ]);
    }

    /**
     * Check if weights sum to 1
     */
    public function isValidWeights(): bool
    {
        $total = $this->bobot_keparahan + $this->bobot_pelapor + $this->bobot_fasilitas;
        return round($total, 2) === 1.00;
    }
}