<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\VerifikasiLaporan;
use App\Models\RiwayatStatusLaporan;
use App\Models\Notifikasi;
use App\Models\Audit;
use App\Http\Requests\StoreVerifikasiRequest;

class VerifikasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Laporan::induk()
            ->with(['kategoriHambatan', 'pelapor', 'wilayah', 'foto']);

        if ($request->filled('status')) {
            $query->status($request->status);
        } else {
            $query->where('status', 'menunggu_verifikasi');
        }

        $laporan = $query->orderBy('created_at')->paginate(15);

        return view('verifikasi.index', compact('laporan'));
    }

      public function show(Laporan $laporan)
    {
        $laporan->load([
            'kategoriHambatan',
            'pelapor',
            'wilayah',
            'foto',
            'verifikasi.admin',
            'riwayatStatus.diubahOleh',
            'laporanAnak.pelapor',
        ]);

        return view('verifikasi.show', compact('laporan'));
    }

    public function approve(StoreVerifikasiRequest $request, Laporan $laporan)
    {
        $statusSebelumnya = $laporan->status;

        $verifikasi = VerifikasiLaporan::create([
            'laporan_id' => $laporan->id,
            'admin_id' => auth()->id(),
            'keputusan' => 'disetujui',
            'catatan_admin' => $request->catatan_admin,
        ]);

        $laporan->update(['status' => 'diverifikasi']);

        // Hitung skor prioritas otomatis
        $this->calculateAndSavePriority($laporan);

        // Catat riwayat status
        RiwayatStatusLaporan::create([
            'laporan_id' => $laporan->id,
            'diubah_oleh_id' => auth()->id(),
            'status_sebelumnya' => $statusSebelumnya,
            'status_baru' => 'diverifikasi',
            'keterangan' => 'Laporan diverifikasi dan disetujui',
        ]);

        // Kirim notifikasi ke pelapor
        Notifikasi::create([
            'penerima_id' => $laporan->pelapor_id,
            'laporan_id' => $laporan->id,
            'jenis' => 'laporan_diverifikasi',
            'judul' => 'Laporan Diverifikasi',
            'pesan' => "Laporan Anda dengan kode {$laporan->kode_laporan} telah diverifikasi dan ditampilkan di peta publik.",
            'tautan' => route('laporan.show', $laporan->id),
        ]);
          Audit::log(
            auth()->id(),
            'verifikasi_setujui',
            'laporan',
            $laporan->id,
            ['status' => $statusSebelumnya],
            ['status' => 'diverifikasi'],
            "Laporan disetujui: {$laporan->kode_laporan}"
        );

        return redirect()->route('admin.verifikasi.index')
            ->with('sukses', 'Laporan berhasil diverifikasi dan skor prioritas telah dihitung.');
    }

    //tolak laporan
     public function reject(StoreVerifikasiRequest $request, Laporan $laporan)
    {
        $statusSebelumnya = $laporan->status;

        $verifikasi = VerifikasiLaporan::create([
            'laporan_id' => $laporan->id,
            'admin_id' => auth()->id(),
            'keputusan' => 'ditolak',
            'catatan_admin' => $request->catatan_admin,
            'kategori_koreksi' => $request->kategori_koreksi,
        ]);

        $laporan->update(['status' => 'ditolak']);

        RiwayatStatusLaporan::create([
            'laporan_id' => $laporan->id,
            'diubah_oleh_id' => auth()->id(),
            'status_sebelumnya' => $statusSebelumnya,
            'status_baru' => 'ditolak',
            'keterangan' => $request->catatan_admin ?? 'Laporan ditolak',
        ]);

        Notifikasi::create([
            'penerima_id' => $laporan->pelapor_id,
            'laporan_id' => $laporan->id,
            'jenis' => 'laporan_ditolak',
            'judul' => 'Laporan Ditolak',
            'pesan' => "Laporan Anda dengan kode {$laporan->kode_laporan} ditolak. Alasan: " . ($request->catatan_admin ?? 'Tidak memenuhi kriteria'),
            'tautan' => route('laporan.show', $laporan->id),
        ]);

        Audit::log(
            auth()->id(),
            'verifikasi_tolak',
            'laporan',
            $laporan->id,
            ['status' => $statusSebelumnya],
            ['status' => 'ditolak'],
            "Laporan ditolak: {$laporan->kode_laporan}"
        );

        return redirect()->route('admin.verifikasi.index')
            ->with('sukses', 'Laporan telah ditolak.');
    }

    //laporan dikembalikan untuk diperbaiki
     public function return(StoreVerifikasiRequest $request, Laporan $laporan)
    {
        $statusSebelumnya = $laporan->status;

        VerifikasiLaporan::create([
            'laporan_id' => $laporan->id,
            'admin_id' => auth()->id(),
            'keputusan' => 'dikembalikan',
            'catatan_admin' => $request->catatan_admin,
            'kategori_koreksi' => $request->kategori_koreksi,
        ]);

        $laporan->update(['status' => 'menunggu_verifikasi']);

        RiwayatStatusLaporan::create([
            'laporan_id' => $laporan->id,
            'diubah_oleh_id' => auth()->id(),
            'status_sebelumnya' => $statusSebelumnya,
            'status_baru' => 'menunggu_verifikasi',
            'keterangan' => 'Laporan dikembalikan untuk diperbaiki: ' . ($request->catatan_admin ?? ''),
        ]);

        Notifikasi::create([
            'penerima_id' => $laporan->pelapor_id,
            'laporan_id' => $laporan->id,
            'jenis' => 'laporan_dikembalikan',
            'judul' => 'Laporan Dikembalikan',
            'pesan' => "Laporan Anda dengan kode {$laporan->kode_laporan} dikembalikan untuk diperbaiki. Catatan: " . ($request->catatan_admin ?? ''),
            'tautan' => route('laporan.show', $laporan->id),
        ]);

        Audit::log(
            auth()->id(),
            'verifikasi_kembalikan',
            'laporan',
            $laporan->id,
            ['status' => $statusSebelumnya],
            ['status' => 'menunggu_verifikasi'],
            "Laporan dikembalikan: {$laporan->kode_laporan}"
        );

        return redirect()->route('admin.verifikasi.index')
            ->with('sukses', 'Laporan telah dikembalikan untuk diperbaiki.');
    }

      public function markInProgress(Request $request, Laporan $laporan)
    {
        $statusSebelumnya = $laporan->status;

        $laporan->update(['status' => 'dalam_perbaikan']);

        RiwayatStatusLaporan::create([
            'laporan_id' => $laporan->id,
            'diubah_oleh_id' => auth()->id(),
            'status_sebelumnya' => $statusSebelumnya,
            'status_baru' => 'dalam_perbaikan',
            'keterangan' => $request->keterangan ?? 'Perbaikan dimulai',
        ]);

        Notifikasi::create([
            'penerima_id' => $laporan->pelapor_id,
            'laporan_id' => $laporan->id,
            'jenis' => 'laporan_dalam_perbaikan',
            'judul' => 'Perbaikan Dimulai',
            'pesan' => "Laporan Anda dengan kode {$laporan->kode_laporan} sedang dalam perbaikan.",
            'tautan' => route('laporan.show', $laporan->id),
        ]);

        Audit::log(
            auth()->id(),
            'status_dalam_perbaikan',
            'laporan',
            $laporan->id,
            ['status' => $statusSebelumnya],
            ['status' => 'dalam_perbaikan'],
            "Laporan dalam perbaikan: {$laporan->kode_laporan}"
        );

        return back()->with('sukses', 'Status laporan diubah menjadi Dalam Perbaikan.');
    }
        //ubah laporan ke selesai
     public function markCompleted(Request $request, Laporan $laporan)
    {
        $statusSebelumnya = $laporan->status;

        $laporan->update(['status' => 'selesai']);

        RiwayatStatusLaporan::create([
            'laporan_id' => $laporan->id,
            'diubah_oleh_id' => auth()->id(),
            'status_sebelumnya' => $statusSebelumnya,
            'status_baru' => 'selesai',
            'keterangan' => $request->keterangan ?? 'Perbaikan selesai',
        ]);

        Notifikasi::create([
            'penerima_id' => $laporan->pelapor_id,
            'laporan_id' => $laporan->id,
            'jenis' => 'laporan_selesai',
            'judul' => 'Perbaikan Selesai',
            'pesan' => "Laporan Anda dengan kode {$laporan->kode_laporan} telah selesai diperbaiki.",
            'tautan' => route('laporan.show', $laporan->id),
        ]);

        Audit::log(
            auth()->id(),
            'status_selesai',
            'laporan',
            $laporan->id,
            ['status' => $statusSebelumnya],
            ['status' => 'selesai'],
            "Laporan selesai: {$laporan->kode_laporan}"
        );

        return back()->with('sukses', 'Status laporan diubah menjadi Selesai.');
    }
    /**
     * Hitung dan simpan skor prioritas laporan.
     */
    protected function calculateAndSavePriority(Laporan $laporan): void
    {
        // Cari fasilitas terdekat
        $fasilitasTerdekat = \App\Models\FasilitasPublik::getNearest(
            (float) $laporan->latitude,
            (float) $laporan->longitude,
            500
        );

        if ($fasilitasTerdekat) {
            $jarak = $fasilitasTerdekat->calculateDistance(
                (float) $laporan->latitude,
                (float) $laporan->longitude
            );

            $laporan->fasilitas_terdekat_id = $fasilitasTerdekat->id;
            $laporan->jarak_fasilitas_meter = round($jarak, 2);
        }

        // Hitung skor
        $skor = $laporan->calculatePriorityScore();

        $laporan->update([
            'skor_keparahan' => $skor['skor_keparahan'],
            'skor_pelapor' => $skor['skor_pelapor'],
            'skor_fasilitas' => $skor['skor_fasilitas'],
            'skor_prioritas' => $skor['skor_prioritas'],
            'dihitung_pada' => now(),
        ]);
    }

}
