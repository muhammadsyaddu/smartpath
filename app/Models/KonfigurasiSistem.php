<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KonfigurasiSistem extends Model
{
    use HasFactory;

    protected $table = 'konfigurasi_sistem';
    
    protected $fillable = [
        'kunci',
        'nilai',
        'tipe_nilai',
        'keterangan',
        'dapat_diedit_ui'
    ];

    protected $casts = [
        'dapat_diedit_ui' => 'boolean',
    ];

    /**
     * Get configuration value with type casting
     */
    public static function getValue(string $key, $default = null)
    {
        $config = static::where('kunci', $key)->first();
        if (!$config) {
            return $default;
        }

        return match ($config->tipe_nilai) {
            'angka' => (int) $config->nilai,
            'desimal' => (float) $config->nilai,
            'boolean' => filter_var($config->nilai, FILTER_VALIDATE_BOOLEAN),
            'json' => json_decode($config->nilai, true),
            default => $config->nilai,
        };
    }

    /**
     * Set configuration value
     */
    public static function setValue(string $key, $value, string $tipe = null): void
    {
        $tipe = $tipe ?? match (true) {
            is_int($value) => 'angka',
            is_float($value) => 'desimal',
            is_bool($value) => 'boolean',
            is_array($value) => 'json',
            default => 'teks',
        };

        $nilai = is_array($value) ? json_encode($value) : (string) $value;

        static::updateOrCreate(
            ['kunci' => $key],
            ['nilai' => $nilai, 'tipe_nilai' => $tipe]
        );
    }
}