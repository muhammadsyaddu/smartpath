<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\KategoriHambatan;
use App\Models\Wilayah;
use App\Services\LaporanService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $laporanService;

    public function __construct(LaporanService $laporanService)
    {
        $this->laporanService = $laporanService;
    }

    /**
     * Halaman utama dengan map dan statistik
     */
    public function index()
    {
        // Statistik laporan
        $statistics = $this->laporanService->getHomeStatistics();
        
        // Laporan terbaru
        $latestReports = Laporan::with(['kategoriHambatan', 'wilayah', 'pelapor'])
            ->induk()
            ->aktif()
            ->whereIn('status', ['diverifikasi', 'dalam_perbaikan', 'selesai'])
            ->orderBy('dibuat_pada', 'desc')
            ->limit(6)
            ->get();
        
        // Kategori populer
        $popularCategories = KategoriHambatan::withCount(['laporan' => function($query) {
                $query->induk()->aktif();
            }])
            ->aktif()
            ->having('laporan_count', '>', 0)
            ->orderBy('laporan_count', 'desc')
            ->limit(8)
            ->get();
        
        // Wilayah dengan laporan terbanyak
        $topWilayah = Wilayah::withCount(['laporan' => function($query) {
                $query->induk()->aktif();
            }])
            ->level('kecamatan')
            ->having('laporan_count', '>', 0)
            ->orderBy('laporan_count', 'desc')
            ->limit(10)
            ->get();
        
        // Data untuk map (markers)
        $markers = Laporan::with(['kategoriHambatan'])
            ->induk()
            ->aktif()
            ->whereIn('status', ['diverifikasi', 'dalam_perbaikan', 'selesai'])
            ->get()
            ->map(function ($laporan) {
                return [
                    'id' => $laporan->id,
                    'lat' => (float) $laporan->latitude,
                    'lng' => (float) $laporan->longitude,
                    'title' => $laporan->judul,
                    'category' => $laporan->kategoriHambatan->nama,
                    'color' => $laporan->kategoriHambatan->warna_penanda ?? '#718096',
                    'priority' => $laporan->tingkat_prioritas,
                    'status' => $laporan->status_label,
                ];
            });

        return view('home.index', compact(
            'statistics',
            'latestReports',
            'popularCategories',
            'topWilayah',
            'markers'
        ));
    }
}