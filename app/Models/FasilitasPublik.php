<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FasilitasPublik extends Model
{
    use HasFactory;

    protected $table = 'fasilitas_publik';

    protected $fillable = [
        'nama',
        'jenis',
        'wilayah_id',
        'alamat',
        'latitude',
        'longitude',
        'bobot_vital',
        'sumber_data',
        'osm_id',
        'aktif'
    ];

    protected $casts = [
        'bobot_vital' => 'integer',
        'aktif' => 'boolean',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    /**
     * Wilayah of this facility
     */
    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class, 'wilayah_id');
    }

    /**
     * Laporan where this facility is nearest
     */
    public function laporanTerdekat(): HasMany
    {
        return $this->hasMany(Laporan::class, 'fasilitas_terdekat_id');
    }

    /**
     * Scope for active facilities
     */
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    /**
     * Scope for specific type
     */
    public function scopeJenis($query, string $jenis)
    {
        return $query->where('jenis', $jenis);
    }

    /**
     * Get vital level label
     */
    public function getTingkatVitalAttribute(): string
    {
        return match (true) {
            $this->bobot_vital >= 80 => 'Sangat Vital',
            $this->bobot_vital >= 60 => 'Vital',
            $this->bobot_vital >= 40 => 'Penting',
            default => 'Biasa',
        };
    }

    /**
     * Calculate distance from coordinates
     */
    public function calculateDistance(float $lat, float $lng): float
    {
        $earthRadius = 6371000; // meters

        $latFrom = deg2rad($this->latitude);
        $latTo = deg2rad($lat);
        $lngFrom = deg2rad($this->longitude);
        $lngTo = deg2rad($lng);

        $latDelta = $latTo - $latFrom;
        $lngDelta = $lngTo - $lngFrom;

        $a = sin($latDelta / 2) ** 2 + cos($latFrom) * cos($latTo) * sin($lngDelta / 2) ** 2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    /**
     * Get nearest facility from coordinates
     */
    public static function getNearest(float $lat, float $lng, float $radius = 500)
    {
        $facilities = static::aktif()->get();
        $nearest = null;
        $minDistance = $radius;

        foreach ($facilities as $facility) {
            $distance = $facility->calculateDistance($lat, $lng);
            if ($distance < $minDistance) {
                $minDistance = $distance;
                $nearest = $facility;
            }
        }

        return $nearest;
    }
}