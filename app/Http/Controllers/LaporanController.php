<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\FotoLaporan;
use App\Models\RiwayatStatusLaporan;
use App\Models\Notifikasi;
use App\Models\Audit;
use App\Models\FasilitasPublik;
use App\Models\KonfigurasiSistem;
use App\Http\Requests\StoreLaporanRequest;
use App\Http\Requests\UpdateLaporanRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LaporanController extends Controller
{
    /**
     * Daftar laporan pengguna.
     */
    public function index(Request $request)
    {
        $query = Laporan::induk()->with(['kategoriHambatan', 'pelapor', 'wilayah', 'foto']);

        if ($request->filled('status')) {
            $query->status($request->status);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori_hambatan_id', $request->kategori);
        }

        $laporan = $query->orderByDesc('created_at')->paginate(12);

        return view('laporan.index', compact('laporan'));
    }

    /**
     * Tampilkan form pelaporan baru.
     */
    public function create()
    {
        $kategoriHambatan = \App\Models\KategoriHambatan::aktif()->urutTampil()->get();
        $wilayahList = \App\Models\Wilayah::aktif()->level('kecamatan')->get();

        return view('laporan.create', compact('kategoriHambatan', 'wilayahList'));
    }

    /**
     * Simpan laporan baru ke database.
     */
    public function store(StoreLaporanRequest $request)
    {
        $validated = $request->validated();

        // Deduplikasi: cek laporan sejenis dalam radius
        $laporanInduk = $this->findDuplicateReport(
            (float) $validated['latitude'],
            (float) $validated['longitude'],
            (int) $validated['kategori_hambatan_id']
        );

        $laporan = new Laporan();
        $laporan->pelapor_id = auth()->id();
        $laporan->kategori_hambatan_id = $validated['kategori_hambatan_id'];
        $laporan->wilayah_id = $validated['wilayah_id'] ?? null;
        $laporan->latitude = $validated['latitude'];
        $laporan->longitude = $validated['longitude'];
        $laporan->alamat_lengkap = $validated['alamat_lengkap'] ?? null;
        $laporan->judul = $validated['judul'];
        $laporan->deskripsi = $validated['deskripsi'] ?? null;
        $laporan->sumber_koordinat = $validated['sumber_koordinat'] ?? 'gps_otomatis';
        $laporan->platform_pelapor = 'web';

        if ($laporanInduk) {
            $laporan->laporan_induk_id = $laporanInduk->id;
            $laporan->status = 'menunggu_verifikasi';
            $laporanInduk->increment('jumlah_pelapor');
        } else {
            $laporan->status = 'menunggu_verifikasi';
            $laporan->jumlah_pelapor = 1;
        }

        $laporan->save();

        // Upload foto
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $index => $file) {
                $namaFile = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $pathFile = $file->storeAs('laporan/' . $laporan->id, $namaFile, 'public');

                FotoLaporan::create([
                    'laporan_id' => $laporan->id,
                    'nama_file' => $namaFile,
                    'nama_asli' => $file->getClientOriginalName(),
                    'path_file' => $pathFile,
                    'mime_type' => $file->getMimeType(),
                    'ukuran_byte' => $file->getSize(),
                    'lebar_px' => null,
                    'tinggi_px' => null,
                    'adalah_utama' => $index === 0,
                    'urutan' => $index,
                ]);
            }
        }

        // Catat riwayat status
        RiwayatStatusLaporan::create([
            'laporan_id' => $laporan->id,
            'diubah_oleh_id' => auth()->id(),
            'status_sebelumnya' => null,
            'status_baru' => 'menunggu_verifikasi',
            'keterangan' => 'Laporan baru dibuat',
        ]);

        // Kirim notifikasi ke pelapor
        Notifikasi::create([
            'penerima_id' => auth()->id(),
            'laporan_id' => $laporan->id,
            'jenis' => 'laporan_diterima',
            'judul' => 'Laporan Diterima',
            'pesan' => "Laporan Anda dengan kode {$laporan->kode_laporan} telah diterima dan menunggu verifikasi.",
            'tautan' => route('laporan.show', $laporan->id),
        ]);

        // Jika duplikat, notifikasi juga
        if ($laporanInduk) {
            Notifikasi::create([
                'penerima_id' => auth()->id(),
                'laporan_id' => $laporan->id,
                'jenis' => 'duplikat_digabung',
                'judul' => 'Laporan Digabung',
                'pesan' => "Laporan Anda telah digabung dengan laporan {$laporanInduk->kode_laporan} pada lokasi yang sama.",
                'tautan' => route('laporan.show', $laporanInduk->id),
            ]);
        }

        // Log audit
        Audit::log(
            auth()->id(),
            'buat_laporan',
            'laporan',
            $laporan->id,
            null,
            $laporan->toArray(),
            "Laporan baru: {$laporan->kode_laporan}"
        );

        return redirect()->route('laporan.show', $laporan->id)
            ->with('sukses', 'Laporan berhasil dikirim dan menunggu verifikasi.');
    }

    /**
     * Tampilkan detail laporan.
     */
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
            'fasilitasTerdekat',
        ]);

        return view('laporan.show', compact('laporan'));
    }

    /**
     * Tampilkan form edit laporan.
     */
    public function edit(Laporan $laporan)
    {
        $this->authorizeEdit($laporan);

        $kategoriHambatan = \App\Models\KategoriHambatan::aktif()->urutTampil()->get();
        $wilayahList = \App\Models\Wilayah::aktif()->level('kecamatan')->get();

        return view('laporan.edit', compact('laporan', 'kategoriHambatan', 'wilayahList'));
    }

    /**
     * Update laporan.
     */
    public function update(UpdateLaporanRequest $request, Laporan $laporan)
    {
        $this->authorizeEdit($laporan);

        $dataLama = $laporan->toArray();
        $validated = $request->validated();
        $laporan->update($validated);

        Audit::log(
            auth()->id(),
            'ubah_laporan',
            'laporan',
            $laporan->id,
            $dataLama,
            $laporan->fresh()->toArray(),
            "Laporan diubah: {$laporan->kode_laporan}"
        );

        return redirect()->route('laporan.show', $laporan->id)
            ->with('sukses', 'Laporan berhasil diperbarui.');
    }

    /**
     * Hapus laporan (soft delete).
     */
    public function destroy(Laporan $laporan)
    {
        $this->authorizeEdit($laporan);

        Audit::log(
            auth()->id(),
            'hapus_laporan',
            'laporan',
            $laporan->id,
            $laporan->toArray(),
            null,
            "Laporan dihapus: {$laporan->kode_laporan}"
        );

        $laporan->delete();

        return redirect()->route('laporan.index')
            ->with('sukses', 'Laporan berhasil dihapus.');
    }

    /**
     * Cari laporan duplikat berdasarkan radius dan kategori.
     */
    protected function findDuplicateReport(float $latitude, float $longitude, int $kategoriHambatanId): ?Laporan
    {
        $radiusMeter = (int) KonfigurasiSistem::getValue('radius_deduplikasi_meter', 50);

        $laporan = Laporan::induk()
            ->where('kategori_hambatan_id', $kategoriHambatanId)
            ->whereNotIn('status', ['ditolak', 'diarsipkan'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        foreach ($laporan as $item) {
            $distance = $this->calculateHaversineDistance(
                $latitude,
                $longitude,
                (float) $item->latitude,
                (float) $item->longitude
            );

            if ($distance <= $radiusMeter) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Hitung jarak antara dua titik koordinat (Haversine formula).
     */
    protected function calculateHaversineDistance(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $earthRadius = 6371000;
        $latFrom = deg2rad($lat1);
        $latTo = deg2rad($lat2);
        $lngFrom = deg2rad($lng1);
        $lngTo = deg2rad($lng2);

        $latDelta = $latTo - $latFrom;
        $lngDelta = $lngTo - $lngFrom;

        $a = sin($latDelta / 2) ** 2 + cos($latFrom) * cos($latTo) * sin($lngDelta / 2) ** 2;
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    /**
     * Autorisasi edit: hanya pelapor atau admin.
     */
    protected function authorizeEdit(Laporan $laporan): void
    {
        if (!auth()->user()->isAdmin() && $laporan->pelapor_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki izin untuk mengubah laporan ini.');
        }
    }
}