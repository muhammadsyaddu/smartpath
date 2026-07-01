<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Laporan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'laporan';

    protected $fillable = [
        'kode_laporan',
        'pelapor_id',
        'kategori_hambatan_id',
        'wilayah_id',
        'laporan_induk_id',
        'latitude',
        'longitude',
        'alamat_lengkap',
        'judul',
        'deskripsi',
        'status',
        'skor_prioritas',
        'skor_keparahan',
        'skor_pelapor',
        'skor_fasilitas',
        'fasilitas_terdekat_id',
        'jarak_fasilitas_meter',
        'jumlah_pelapor',
        'sumber_koordinat',
        'platform_pelapor',
        'dihitung_pada'
    ];

    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'skor_prioritas' => 'decimal:2',
        'skor_keparahan' => 'decimal:2',
        'skor_pelapor' => 'decimal:2',
        'skor_fasilitas' => 'decimal:2',
        'jarak_fasilitas_meter' => 'decimal:2',
        'jumlah_pelapor' => 'integer',
        'dihitung_pada' => 'datetime',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted()
    {
        static::creating(function ($laporan) {
            if (empty($laporan->kode_laporan)) {
                $laporan->kode_laporan = $laporan->generateKodeLaporan();
            }
        });
    }

    /**
     * Generate unique laporan code
     */
    protected function generateKodeLaporan(): string
    {
        $yearMonth = now()->format('Ym');
        $count = static::where('kode_laporan', 'like', "LP-{$yearMonth}-%")->count() + 1;
        return sprintf('LP-%s-%05d', $yearMonth, $count);
    }

    /**
     * Pelapor (user who created this report)
     */
    public function pelapor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pelapor_id');
    }

    /**
     * Kategori hambatan
     */
    public function kategoriHambatan(): BelongsTo
    {
        return $this->belongsTo(KategoriHambatan::class, 'kategori_hambatan_id');
    }

    /**
     * Wilayah
     */
    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class, 'wilayah_id');
    }

    /**
     * Induk laporan (for deduplication)
     */
    public function laporanInduk(): BelongsTo
    {
        return $this->belongsTo(Laporan::class, 'laporan_induk_id');
    }

    /**
     * Anak laporan (duplicates grouped under this report)
     */
    public function laporanAnak(): HasMany
    {
        return $this->hasMany(Laporan::class, 'laporan_induk_id');
    }

    /**
     * Fasilitas terdekat
     */
    public function fasilitasTerdekat(): BelongsTo
    {
        return $this->belongsTo(FasilitasPublik::class, 'fasilitas_terdekat_id');
    }

    /**
     * Foto laporan
     */
    public function foto(): HasMany
    {
        return $this->hasMany(FotoLaporan::class, 'laporan_id');
    }

    /**
     * Verifikasi laporan
     */
    public function verifikasi(): HasMany
    {
        return $this->hasMany(VerifikasiLaporan::class, 'laporan_id');
    }

    /**
     * Riwayat status
     */
    public function riwayatStatus(): HasMany
    {
        return $this->hasMany(RiwayatStatusLaporan::class, 'laporan_id');
    }

    /**
     * Notifikasi terkait
     */
    public function notifikasi(): HasMany
    {
        return $this->hasMany(Notifikasi::class, 'laporan_id');
    }

    /**
     * Scope for main reports (not duplicates)
     */
    public function scopeInduk($query)
    {
        return $query->whereNull('laporan_induk_id');
    }

    /**
     * Scope for active reports
     */
    public function scopeAktif($query)
    {
        return $query->whereNull('deleted_at');
    }

    /**
     * Scope for specific status
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for verified reports
     */
    public function scopeTerverifikasi($query)
    {
        return $query->whereIn('status', ['diverifikasi', 'dalam_perbaikan', 'selesai']);
    }

    /**
     * Get priority level
     */
    public function getTingkatPrioritasAttribute(): string
    {
        if ($this->skor_prioritas === null) {
            return 'Belum Dinilai';
        }

        return match (true) {
            $this->skor_prioritas >= 70 => 'Tinggi',
            $this->skor_prioritas >= 40 => 'Sedang',
            default => 'Rendah',
        };
    }

    /**
     * Get status label in Bahasa Indonesia
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'menunggu_verifikasi' => 'Menunggu Verifikasi',
            'diverifikasi' => 'Terverifikasi',
            'ditolak' => 'Ditolak',
            'dalam_perbaikan' => 'Dalam Perbaikan',
            'selesai' => 'Selesai',
            'diarsipkan' => 'Diarsipkan',
            default => $this->status,
        };
    }

    /**
     * Get status badge color
     */
    public function getStatusWarnaAttribute(): string
    {
        return match ($this->status) {
            'menunggu_verifikasi' => 'warning',
            'diverifikasi' => 'success',
            'ditolak' => 'danger',
            'dalam_perbaikan' => 'info',
            'selesai' => 'primary',
            'diarsipkan' => 'secondary',
            default => 'secondary',
        };
    }

    /**
     * Calculate priority score
     */
    public function calculatePriorityScore(): array
    {
        $config = PengaturanPrioritas::where('adalah_aktif', true)->first();

        if (!$config) {
            $config = PengaturanPrioritas::first();
        }

        // Skor keparahan from category
        $skorKeparahan = $this->kategoriHambatan->bobot_keparahan ?? 50;

        // Skor pelapor (normalize: 1 = 0, max 10 = 100)
        $skorPelapor = min(100, ($this->jumlah_pelapor - 1) * 10);

        // Skor fasilitas (inverse: closer = higher)
        $skorFasilitas = 0;
        if ($this->jarak_fasilitas_meter !== null && $this->jarak_fasilitas_meter > 0) {
            $radius = $config->radius_fasilitas_m ?? 500;
            $skorFasilitas = max(0, 100 - (($this->jarak_fasilitas_meter / $radius) * 100));
            $skorFasilitas = min(100, $skorFasilitas);
        }

        // Calculate weighted score
        $skorPrioritas = (
            ($skorKeparahan * $config->bobot_keparahan) +
            ($skorPelapor * $config->bobot_pelapor) +
            ($skorFasilitas * $config->bobot_fasilitas)
        );

        return [
            'skor_prioritas' => round($skorPrioritas, 2),
            'skor_keparahan' => round($skorKeparahan, 2),
            'skor_pelapor' => round($skorPelapor, 2),
            'skor_fasilitas' => round($skorFasilitas, 2),
        ];
    }
}