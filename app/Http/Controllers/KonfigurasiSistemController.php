<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KonfigurasiSistem;

class KonfigurasiSistemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $konfigurasi = KonfigurasiSistem::all();
        return view('konfigurasi_sistem.index', compact('konfigurasi'));
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
        $konfigurasi = KonfigurasiSistem::findOrfail($id);
        return view('konfigurasi_sistem.edit', compact('konfigurasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $request->validate([
            'nilai' => 'required',
           
        ]);

        //CARI DATA  
        $konfigurasi = KonfigurasiSistem::findOrFail($id);
        $konfigurasi->update($request->all());

        return redirect(route('konfigurasi_sistem.index'))->with('success', 'Konfigurasi sistem berhasil diperbarui.');   

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $konfigurasi = KonfigurasiSistem::findOrFail($id);
        $konfigurasi->delete();

        return redirect(route('konfigurasi_sistem.index'))->with('success', 'Konfigurasi sistem berhasil dihapus.');
    }
}
