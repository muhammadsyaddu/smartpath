<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use App\Models\Audit;
use App\Http\Requests\StoreWilayahRequest;
use App\Http\Requests\UpdateWilayahRequest;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    public function index(Request $request)
    {
        $query = Wilayah::with(['induk', 'anak']);

        if ($request->filled('level')) {
            $query->level($request->level);
        }
        if ($request->filled('aktif') && $request->aktif === '1') {
            $query->aktif();
        }

        $wilayah = $query->orderBy('level')->orderBy('nama')->paginate(15);
        return view('admin.wilayah.index', compact('wilayah'));
    }

    public function create()
    {
        $wilayahList = Wilayah::aktif()->level('kota_kabupaten')->get();
        return view('admin.wilayah.create', compact('wilayahList'));
    }

    public function store(StoreWilayahRequest $request)
    {
        $validated = $request->validated();
        $wilayah = Wilayah::create($validated);

        Audit::log(auth()->id(), 'buat_wilayah', 'wilayah', $wilayah->id, null, $wilayah->toArray(), "Wilayah baru: {$wilayah->nama}");

        return redirect()->route('admin.wilayah.index')->with('sukses', 'Wilayah berhasil ditambahkan.');
    }

    public function edit(Wilayah $wilayah)
    {
        $wilayahList = Wilayah::aktif()->where('id', '!=', $wilayah->id)->level('kota_kabupaten')->get();
        return view('admin.wilayah.edit', compact('wilayah', 'wilayahList'));
    }

    public function update(UpdateWilayahRequest $request, Wilayah $wilayah)
    {
        $dataLama = $wilayah->toArray();
        $validated = $request->validated();
        $wilayah->update($validated);

        Audit::log(auth()->id(), 'ubah_wilayah', 'wilayah', $wilayah->id, $dataLama, $wilayah->fresh()->toArray(), "Wilayah diubah: {$wilayah->nama}");

        return redirect()->route('admin.wilayah.index')->with('sukses', 'Wilayah berhasil diperbarui.');
    }

    public function destroy(Wilayah $wilayah)
    {
        if ($wilayah->anak()->count() > 0) {
            return back()->with('galat', 'Wilayah yang memiliki sub-wilayah tidak dapat dihapus.');
        }
        if ($wilayah->laporan()->count() > 0) {
            return back()->with('galat', 'Wilayah yang memiliki laporan terkait tidak dapat dihapus.');
        }

        $wilayah->delete();
        return redirect()->route('admin.wilayah.index')->with('sukses', 'Wilayah berhasil dihapus.');
    }
}
