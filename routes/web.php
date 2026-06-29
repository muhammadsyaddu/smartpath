<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KonfigurasiSistemController;

Route::get('home', function () {
    return view('welcome');
});

    //route konfigurasi sistem
    Route::get('/konfigurasi_sistem', [KonfigurasiSistemController::class, 'index'])->name('konfigurasi_sistem.index');
    Route::get('/konfigurasi_sistem/{id}/edit', [KonfigurasiSistemController::class, 'edit'])->name('konfigurasi_sistem.edit');
    Route::put('/konfigurasi_sistem/{id}', [KonfigurasiSistemController::class, 'update'])->name('konfigurasi_sistem.update');
    Route::delete('/konfigurasi_sistem/{id}', [KonfigurasiSistemController::class, 'destroy'])->name('konfigurasi_sistem.destroy');

    //pengaturan prioritas
    
