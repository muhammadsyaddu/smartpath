<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengaturanPrioritas;
use App\Models\Laporan;
use App\Models\Audit;
use App\Http\Requests\StorePengaturanPrioritasRequest;
use App\Http\Requests\UpdatePengaturanPrioritasRequest;

class PengaturanPrioritasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengaturanPrioritas = PengaturanPrioritas::with('dibuatOleh')->orderByDesc('created_at')->paginate(15);
        $aktif = PengaturanPrioritas::where('adalah_aktif', true)->first();
        return view('admin.pengaturan-prioritas.index', compact('pengaturanPrioritas', 'aktif'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pengaturan-prioritas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validated();
        $validated['dibuat_oleh_id'] = auth()->id();

        $pengaturanPrioritas = PengaturanPrioritas::create($validated);

        Audit::log(auth()->id(), 'buat_pengaturan_prioritas', 'pengaturan_prioritas', $pengaturanPrioritas->id, null, $pengaturanPrioritas->toArray(), "Pengaturan prioritas baru: {$pengaturanPrioritas->label}");

        return redirect()->route('admin.pengaturan-prioritas.index')->with('sukses', 'Pengaturan prioritas berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.pengaturan-prioritas.edit', compact('pengaturanPrioritas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dataLama = $pengaturanPrioritas->toArray();
        $validated = $request->validated();
        $pengaturanPrioritas->update($validated);

        Audit::log(auth()->id(), 'ubah_pengaturan_prioritas', 'pengaturan_prioritas', $pengaturanPrioritas->id, $dataLama, $pengaturanPrioritas->fresh()->toArray(), "Pengaturan prioritas diubah: {$pengaturanPrioritas->label}");

        return redirect()->route('admin.pengaturan-prioritas.index')->with('sukses', 'Pengaturan prioritas berhasil diperbarui.');
    }
    public function activate(PengaturanPrioritas $pengaturanPrioritas)
    {
        $pengaturanPrioritas->activate();

        Audit::log(auth()->id(), 'aktifkan_pengaturan_prioritas', 'pengaturan_prioritas', $pengaturanPrioritas->id, null, null, "Pengaturan prioritas diaktifkan: {$pengaturanPrioritas->label}");

        return redirect()->route('admin.pengaturan-prioritas.index')->with('sukses', 'Pengaturan prioritas berhasil diaktifkan.');
    }

      public function recalculate()
    {
        $laporanList = Laporan::induk()->terverifikasi()->whereNotNull('skor_prioritas')->get();
        $count = 0;

        foreach ($laporanList as $laporan) {
            $fasilitasTerdekat = \App\Models\FasilitasPublik::getNearest((float) $laporan->latitude, (float) $laporan->longitude, 500);

            if ($fasilitasTerdekat) {
                $jarak = $fasilitasTerdekat->calculateDistance((float) $laporan->latitude, (float) $laporan->longitude);
                $laporan->fasilitas_terdekat_id = $fasilitasTerdekat->id;
                $laporan->jarak_fasilitas_meter = round($jarak, 2);
            }

            $skor = $laporan->calculatePriorityScore();
            $laporan->update([
                'skor_keparahan' => $skor['skor_keparahan'],
                'skor_pelapor' => $skor['skor_pelapor'],
                'skor_fasilitas' => $skor['skor_fasilitas'],
                'skor_prioritas' => $skor['skor_prioritas'],
                'dihitung_pada' => now(),
            ]);
            $count++;
        }

        Audit::log(auth()->id(), 'hitung_ulang_prioritas', 'laporan', null, null, null, "Hitung ulang skor prioritas untuk {$count} laporan");

        return redirect()->route('admin.pengaturan-prioritas.index')->with('sukses', "Skor prioritas berhasil dihitung ulang untuk {$count} laporan.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if ($pengaturanPrioritas->adalah_aktif) {
            return back()->with('galat', 'Pengaturan yang aktif tidak dapat dihapus.');
        }

        $pengaturanPrioritas->delete();
        return redirect()->route('admin.pengaturan-prioritas.index')->with('sukses', 'Pengaturan prioritas berhasil dihapus.');
    }
 

}
