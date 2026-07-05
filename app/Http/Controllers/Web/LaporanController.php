<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Laporan\StoreLaporanRequest;
use App\Http\Requests\Laporan\UpdateLaporanRequest;
use App\Models\Laporan;
use App\Models\KategoriHambatan;
use App\Models\Wilayah;
use App\Services\LaporanService;
use App\Services\GeocodingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    protected $laporanService;
    protected $geocodingService;

    public function __construct(
        LaporanService $laporanService,
        GeocodingService $geocodingService
    ) {
        $this->laporanService = $laporanService;
        $this->geocodingService = $geocodingService;
    }

    /**
     * Daftar laporan
     */
    public function index(Request $request)
    {
        $filters = $request->only(['status', 'kategori_id', 'wilayah_id', 'q']);
        $laporan = $this->laporanService->getFilteredReports($filters);
        
        $kategori = KategoriHambatan::aktif()->urutTampil()->get();
        $wilayah = Wilayah::level('kecamatan')->aktif()->get();

        return view('laporan.index', compact('laporan', 'kategori', 'wilayah'));
    }

    /**
     * Detail laporan
     */
    public function show(Laporan $laporan)
    {
        $laporan->load([
            'pelapor',
            'kategoriHambatan',
            'wilayah',
            'fasilitasTerdekat',
            'foto',
            'laporanAnak.pelapor',
            'verifikasi.admin',
            'riwayatStatus.diubahOleh'
        ]);

        // Get similar reports
        $similar = Laporan::where('kategori_hambatan_id', $laporan->kategori_hambatan_id)
            ->where('id', '!=', $laporan->id)
            ->induk()
            ->aktif()
            ->limit(5)
            ->get();

        return view('laporan.show', compact('laporan', 'similar'));
    }

    /**
     * Form buat laporan
     */
    public function create()
    {
        $kategori = KategoriHambatan::aktif()->urutTampil()->get();
        $wilayah = Wilayah::level('kecamatan')->aktif()->get();
        
        return view('laporan.create', compact('kategori', 'wilayah'));
    }

    /**
     * Simpan laporan
     */
    public function store(StoreLaporanRequest $request)
    {
        $validated = $request->validated();
        
        try {
            $laporan = $this->laporanService->createLaporan(
                Auth::user(),
                $validated,
                $request->file('foto')
            );
            
            return redirect()
                ->route('laporan.show', $laporan)
                ->with('success', 'Laporan berhasil dibuat! Menunggu verifikasi.');
                
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal membuat laporan: ' . $e->getMessage());
        }
    }

    /**
     * Form edit laporan
     */
    public function edit(Laporan $laporan)
    {
        // Check ownership
        if (!Auth::user()->isAdmin() && Auth::id() !== $laporan->pelapor_id) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit laporan ini.');
        }
        
        // Only allow edit if status is pending or rejected
        if (!in_array($laporan->status, ['menunggu_verifikasi', 'ditolak'])) {
            return back()->with('error', 'Laporan tidak dapat diedit karena sudah dalam proses.');
        }
        
        $kategori = KategoriHambatan::aktif()->urutTampil()->get();
        
        return view('laporan.edit', compact('laporan', 'kategori'));
    }

    /**
     * Update laporan
     */
    public function update(UpdateLaporanRequest $request, Laporan $laporan)
    {
        // Check ownership
        if (!Auth::user()->isAdmin() && Auth::id() !== $laporan->pelapor_id) {
            abort(403, 'Anda tidak memiliki izin untuk mengupdate laporan ini.');
        }
        
        try {
            $this->laporanService->updateLaporan($laporan, $request->validated());
            
            return redirect()
                ->route('laporan.show', $laporan)
                ->with('success', 'Laporan berhasil diupdate.');
                
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal mengupdate laporan: ' . $e->getMessage());
        }
    }

    /**
     * Hapus laporan (soft delete)
     */
    public function destroy(Laporan $laporan)
    {
        // Check ownership
        if (!Auth::user()->isAdmin() && Auth::id() !== $laporan->pelapor_id) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus laporan ini.');
        }
        
        // Only allow delete if status is pending or rejected
        if (!in_array($laporan->status, ['menunggu_verifikasi', 'ditolak'])) {
            return back()->with('error', 'Laporan tidak dapat dihapus karena sudah dalam proses.');
        }
        
        $this->laporanService->deleteLaporan($laporan);
        
        return redirect()
            ->route('laporan.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }

    /**
     * Laporan saya
     */
    public function myReports(Request $request)
    {
        $laporan = Laporan::where('pelapor_id', Auth::id())
            ->with(['kategoriHambatan', 'wilayah'])
            ->orderBy('dibuat_pada', 'desc')
            ->paginate(10);
            
        return view('laporan.my', compact('laporan'));
    }

    /**
     * Filter laporan by category
     */
    public function filterByCategory($slug)
    {
        $kategori = KategoriHambatan::where('slug', $slug)->firstOrFail();
        
        $laporan = Laporan::with(['kategoriHambatan', 'wilayah', 'pelapor'])
            ->where('kategori_hambatan_id', $kategori->id)
            ->induk()
            ->aktif()
            ->whereIn('status', ['diverifikasi', 'dalam_perbaikan', 'selesai'])
            ->orderBy('dibuat_pada', 'desc')
            ->paginate(12);

        return view('laporan.filter', compact('laporan', 'kategori'));
    }

    /**
     * Nearby reports for map
     */
    public function nearby(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'radius' => 'nullable|numeric|min:100|max:5000',
        ]);

        $radius = $request->radius ?? 1000; // default 1km
        
        $laporan = $this->laporanService->getNearbyReports(
            $request->lat,
            $request->lng,
            $radius
        );

        return response()->json([
            'status' => 'success',
            'data' => $laporan
        ]);
    }
}