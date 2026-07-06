<?php

namespace App\Http\Controllers;

use App\Models\KategoriHambatan;
use App\Models\Audit;
use App\Http\Requests\StoreKategoriHambatanRequest;
use App\Http\Requests\UpdateKategoriHambatanRequest;
use Illuminate\Http\Request;

class KategoriHambatanController extends Controller
{
    public function index(Request $request)
    {
        $query = KategoriHambatan::withCount('laporan');

        if ($request->filled('aktif') && $request->aktif === '1') {
            $query->aktif();
        }

        $kategoriHambatan = $query->urutTampil()->paginate(15);
        return view('admin.kategori-hambatan.index', compact('kategoriHambatan'));
    }

    public function create()
    {
        return view('admin.kategori-hambatan.create');
    }

    public function store(StoreKategoriHambatanRequest $request)
    {
        $validated = $request->validated();
        $kategoriHambatan = KategoriHambatan::create($validated);

        Audit::log(auth()->id(), 'buat_kategori_hambatan', 'kategori_hambatan', $kategoriHambatan->id, null, $kategoriHambatan->toArray(), "Kategori hambatan baru: {$kategoriHambatan->nama}");

        return redirect()->route('admin.kategori-hambatan.index')->with('sukses', 'Kategori hambatan berhasil ditambahkan.');
    }

    public function show(KategoriHambatan $kategoriHambatan)
    {
        $kategoriHambatan->load(['laporan' => fn($q) => $q->induk()->orderByDesc('created_at')->limit(10)]);
        return view('admin.kategori-hambatan.show', compact('kategoriHambatan'));
    }

    public function edit(KategoriHambatan $kategoriHambatan)
    {
        return view('admin.kategori-hambatan.edit', compact('kategoriHambatan'));
    }

    public function update(UpdateKategoriHambatanRequest $request, KategoriHambatan $kategoriHambatan)
    {
        $dataLama = $kategoriHambatan->toArray();
        $validated = $request->validated();
        $kategoriHambatan->update($validated);

        Audit::log(auth()->id(), 'ubah_kategori_hambatan', 'kategori_hambatan', $kategoriHambatan->id, $dataLama, $kategoriHambatan->fresh()->toArray(), "Kategori hambatan diubah: {$kategoriHambatan->nama}");

        return redirect()->route('admin.kategori-hambatan.index')->with('sukses', 'Kategori hambatan berhasil diperbarui.');
    }

    public function destroy(KategoriHambatan $kategoriHambatan)
    {
        if ($kategoriHambatan->laporan()->count() > 0) {
            return back()->with('galat', 'Kategori tidak dapat dihapus karena masih memiliki laporan terkait.');
        }

        Audit::log(auth()->id(), 'hapus_kategori_hambatan', 'kategori_hambatan', $kategoriHambatan->id, $kategoriHambatan->toArray(), null, "Kategori hambatan dihapus: {$kategoriHambatan->nama}");
        $kategoriHambatan->delete();

        return redirect()->route('admin.kategori-hambatan.index')->with('sukses', 'Kategori hambatan berhasil dihapus.');
    }
}