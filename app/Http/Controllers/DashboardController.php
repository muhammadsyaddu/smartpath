<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\KategoriHambatan;
use App\Models\Wilayah;
use App\Models\FasilitasPublik;
use App\Models\User;
use App\Models\PengaturanPrioritas;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Dashboard utama administrator/dinas.
     */
    public function index()
    {
        $totalLaporan = Laporan::induk()->count();
        $menungguVerifikasi = Laporan::status('menunggu_verifikasi')->count();
        $diverifikasi = Laporan::status('diverifikasi')->count();
        $dalamPerbaikan = Laporan::status('dalam_perbaikan')->count();
        $selesai = Laporan::status('selesai')->count();
        $ditolak = Laporan::status('ditolak')->count();

        // Distribusi per kategori
        $perKategori = KategoriHambatan::withCount(['laporan' => function ($query) {
            $query->induk();
        }])->aktif()->urutTampil()->get();

        // Distribusi per wilayah
        $perWilayah = Wilayah::withCount(['laporan' => function ($query) {
            $query->induk();
        }])->aktif()->level('kecamatan')->having('laporan_count', '>', 0)->get();

        // Laporan prioritas tinggi
        $prioritasTinggi = Laporan::induk()
            ->with(['kategoriHambatan', 'wilayah', 'pelapor'])
            ->terverifikasi()
            ->where('skor_prioritas', '>=', 70)
            ->orderByDesc('skor_prioritas')
            ->limit(10)
            ->get();

        // Laporan terbaru menunggu verifikasi
        $laporanBaru = Laporan::induk()
            ->with(['kategoriHambatan', 'pelapor'])
            ->status('menunggu_verifikasi')
            ->orderBy('created_at')
            ->limit(10)
            ->get();

        // Statistik skor rata-rata
        $rataRataSkor = Laporan::induk()
            ->terverifikasi()
            ->whereNotNull('skor_prioritas')
            ->avg('skor_prioritas');

        // Total pelapor unik
        $totalPelapor = Laporan::induk()->sum('jumlah_pelapor');

        // Pengaturan prioritas aktif
        $pengaturanAktif = PengaturanPrioritas::where('adalah_aktif', true)->first();

        return view('dashboard.dinas', compact(
            'totalLaporan',
            'menungguVerifikasi',
            'diverifikasi',
            'dalamPerbaikan',
            'selesai',
            'ditolak',
            'perKategori',
            'perWilayah',
            'prioritasTinggi',
            'laporanBaru',
            'rataRataSkor',
            'totalPelapor',
            'pengaturanAktif'
        ));
    }
    public function indexDinas()
{
    return $this->index();
}

    /**
     * Fallback sementara sampai dashboard warga dibuat.
     */
    public function indexWarga()
    {
        $user = auth()->user();
        $jumlahLaporan = Laporan::where('pelapor_id', $user->id)->count();

        return view('dashboard.warga', compact('user', 'jumlahLaporan'));
    }

    /**
     * API endpoint untuk data chart dashboard.
     */
    public function getChartData(Request $request)
    {
        $type = $request->get('type', 'status');

        return match ($type) {
            'status' => $this->getStatusChartData(),
            'kategori' => $this->getKategoriChartData(),
            'tren' => $this->getTrenChartData(),
            'prioritas' => $this->getPrioritasChartData(),
            default => response()->json([]),
        };
    }

    protected function getStatusChartData()
    {
        $data = [
            ['status' => 'Menunggu Verifikasi', 'count' => Laporan::status('menunggu_verifikasi')->induk()->count()],
            ['status' => 'Terverifikasi', 'count' => Laporan::status('diverifikasi')->induk()->count()],
            ['status' => 'Dalam Perbaikan', 'count' => Laporan::status('dalam_perbaikan')->induk()->count()],
            ['status' => 'Selesai', 'count' => Laporan::status('selesai')->induk()->count()],
            ['status' => 'Ditolak', 'count' => Laporan::status('ditolak')->induk()->count()],
        ];

        return response()->json($data);
    }

    protected function getKategoriChartData()
    {
        $data = KategoriHambatan::withCount(['laporan' => function ($q) {
            $q->induk();
        }])->aktif()->urutTampil()->get()->map(fn($k) => [
            'nama' => $k->nama,
            'count' => $k->laporan_count,
            'warna' => $k->warna_penanda,
        ]);

        return response()->json($data);
    }

    protected function getTrenChartData()
    {
        $data = Laporan::induk()
            ->selectRaw("DATE(created_at) as tanggal, COUNT(*) as jumlah")
            ->where('created_at', '>=', now()->subDays(30))
            ->groupByRaw("DATE(created_at)")
            ->orderBy('tanggal')
            ->get();

        return response()->json($data);
    }

    protected function getPrioritasChartData()
    {
        $tinggi = Laporan::induk()->terverifikasi()->where('skor_prioritas', '>=', 70)->count();
        $sedang = Laporan::induk()->terverifikasi()->whereBetween('skor_prioritas', [40, 69.99])->count();
        $rendah = Laporan::induk()->terverifikasi()->where('skor_prioritas', '<', 40)->count();

        return response()->json([
            ['tingkat' => 'Tinggi', 'count' => $tinggi, 'warna' => '#DC2626'],
            ['tingkat' => 'Sedang', 'count' => $sedang, 'warna' => '#D97706'],
            ['tingkat' => 'Rendah', 'count' => $rendah, 'warna' => '#059669'],
        ]);
    }
}