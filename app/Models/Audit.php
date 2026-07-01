<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Audit extends Model
{
    use HasFactory;

    protected $table = 'audit';

    protected $fillable = [
        'pengguna_id',
        'aksi',
        'tabel_terkait',
        'id_terkait',
        'data_lama',
        'data_baru',
        'ip_address',
        'user_agent',
        'keterangan'
    ];

    protected $casts = [
        'data_lama' => 'array',
        'data_baru' => 'array',
    ];

    /**
     * Pengguna who performed the action
     */
    public function pengguna(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    /**
     * Scope for specific action
     */
    public function scopeAksi($query, string $aksi)
    {
        return $query->where('aksi', $aksi);
    }

    /**
     * Scope for specific table
     */
    public function scopeTabel($query, string $tabel)
    {
        return $query->where('tabel_terkait', $tabel);
    }

    /**
     * Log an audit event
     */
    public static function log(
        ?int $penggunaId,
        string $aksi,
        ?string $tabel = null,
        ?int $id = null,
        $dataLama = null,
        $dataBaru = null,
        ?string $keterangan = null
    ): self {
        return static::create([
            'pengguna_id' => $penggunaId,
            'aksi' => $aksi,
            'tabel_terkait' => $tabel,
            'id_terkait' => $id,
            'data_lama' => $dataLama,
            'data_baru' => $dataBaru,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'keterangan' => $keterangan,
        ]);
    }
}