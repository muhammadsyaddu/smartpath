<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\KategoriHambatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BerandaController extends Controller
{
    /**
     * Menampilkan Halaman Beranda Utama (Landing Page)
     */
    public function index()
    {
        // 1. Statistik Laporan
        $totalLaporan = Laporan::induk()->aktif()->count();
        
        $totalTerverifikasi = Laporan::induk()->aktif()
            ->whereIn('status', ['diverifikasi', 'dalam_perbaikan', 'selesai'])
            ->count();
            
        $totalDalamPerbaikan = Laporan::induk()->aktif()
            ->status('dalam_perbaikan')
            ->count();
            
        $totalSelesai = Laporan::induk()->aktif()
            ->status('selesai')
            ->count();

        // 2. Laporan Prioritas Tinggi (Top 3 berdasarkan skor_prioritas)
        $laporanPrioritas = Laporan::induk()
            ->aktif()
            ->with(['kategoriHambatan', 'foto'])
            ->orderByDesc('skor_prioritas')
            ->orderByDesc('created_at')
            ->take(3)
            ->get();

        // 3. Kategori Hambatan Aktif
        $kategoriHambatan = KategoriHambatan::aktif()
            ->urutTampil()
            ->get();

        return view('beranda', compact(
            'totalLaporan',
            'totalTerverifikasi',
            'totalDalamPerbaikan',
            'totalSelesai',
            'laporanPrioritas',
            'kategoriHambatan'
        ));
    }
    public function tentang()
{
    return view('tentang');
}

    /**
     * Mengelola Langganan Newsletter
     */
    public function subscribeNewsletter(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        return redirect()->back()->with('success', 'Terima kasih telah berlangganan newsletter SmartPath!');
    }
}