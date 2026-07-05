<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\KategoriHambatan;
use App\Models\Wilayah;
use App\Models\FasilitasPublik;

class BerandaController extends Controller
{
    /**
     * Tampilkan halaman beranda publik.
     */
    public function index()
    {
        $totalLaporan = Laporan::induk()->count();
        $totalTerverifikasi = Laporan::terverifikasi()->count();
        $totalDalamPerbaikan = Laporan::status('dalam_perbaikan')->count();
        $totalSelesai = Laporan::status('selesai')->count();
        $kategoriHambatan = KategoriHambatan::aktif()->urutTampil()->get();
        $wilayah = Wilayah::aktif()->level('kota_kabupaten')->first();

        $laporanTerbaru = Laporan::induk()
            ->with(['kategoriHambatan', 'pelapor', 'wilayah', 'foto'])
            ->terverifikasi()
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $laporanPrioritasTinggi = Laporan::induk()
            ->with(['kategoriHambatan', 'wilayah'])
            ->terverifikasi()
            ->where('skor_prioritas', '>=', 70)
            ->orderByDesc('skor_prioritas')
            ->limit(5)
            ->get();

        return view('beranda.index', compact(
            'totalLaporan',
            'totalTerverifikasi',
            'totalDalamPerbaikan',
            'totalSelesai',
            'kategoriHambatan',
            'wilayah',
            'laporanTerbaru',
            'laporanPrioritasTinggi'
        ));
    }
}