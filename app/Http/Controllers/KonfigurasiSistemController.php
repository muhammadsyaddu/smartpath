<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KonfigurasiSistem;
use App\Models\Audit;
use App\Http\Requests\StoreKonfigurasiSistemRequest;
class KonfigurasiSistemController extends Controller
{
    public function index()
    {
        $konfigurasi = KonfigurasiSistem::orderBy('kunci')->paginate(20);
        return view('admin.konfigurasi-sistem.index', compact('konfigurasi'));
    }

    public function edit(KonfigurasiSistem $konfigurasiSistem)
    {
        return view('admin.konfigurasi-sistem.edit', compact('konfigurasiSistem'));
    }

     public function update(Request $request, KonfigurasiSistem $konfigurasiSistem)
    {
        $validated = $request->validate([
            'nilai' => ['required', 'string'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ], [
            'nilai.required' => 'Nilai konfigurasi harus diisi.',
        ]);

        $dataLama = $konfigurasiSistem->toArray();
        $konfigurasiSistem->update($validated);

        Audit::log(auth()->id(), 'ubah_konfigurasi_sistem', 'konfigurasi_sistem', $konfigurasiSistem->id, $dataLama, $konfigurasiSistem->fresh()->toArray(), "Konfigurasi diubah: {$konfigurasiSistem->kunci}");

        return redirect()->route('admin.konfigurasi-sistem.index')->with('sukses', 'Konfigurasi berhasil diperbarui.');
    }

      public function store(StoreKonfigurasiSistemRequest $request)
    {
        $konfigurasiSistem = KonfigurasiSistem::create($request->validated());

        Audit::log(auth()->id(), 'buat_konfigurasi_sistem', 'konfigurasi_sistem', $konfigurasiSistem->id, null, $konfigurasiSistem->toArray(), "Konfigurasi baru: {$konfigurasiSistem->kunci}");

        return redirect()->route('admin.konfigurasi-sistem.index')->with('sukses', 'Konfigurasi berhasil ditambahkan.');
    }

}
