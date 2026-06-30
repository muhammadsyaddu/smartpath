<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengaturanPrioritas;

class PengaturanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prioritas = PengaturanPrioritas::all();
        return view('pengaturan_prioritas.index', compact('prioritas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        $prioritas = PengaturanPrioritas::findOrFail($id);
        return view('pengaturan_prioritas.edit', compact('prioritas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request ->validate([
            'nama_prioritas' => 'required|string|max:100',
            'bobot' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            [
                'nama_prioritas' => 'Nama prioritas tidak boleh kosong.',
                'bobot' => 'Bobot nilai wajib diisi.',
                'bobot.numeric' => 'Bobot harus berupa angka/desimal.',
            ]
        ]);

        $prioritas = PengaturanPrioritas::findOrFail($id);
        $prioritas->update($request->all());
        return redirect()->route('pengaturan_prioritas.index')->with('success', 'Prioritas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    
    }
}
