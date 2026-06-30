<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KonfigurasiSistemController;
use App\Http\Controllers\PengaturanController;

Route::get('home', function () {
    return view('welcome');
});

    //route konfigurasi sistem
    Route::get('/konfigurasi_sistem', [KonfigurasiSistemController::class, 'index'])->name('konfigurasi_sistem.index');
    Route::get('/konfigurasi_sistem/{id}/edit', [KonfigurasiSistemController::class, 'edit'])->name('konfigurasi_sistem.edit');
    Route::put('/konfigurasi_sistem/{id}', [KonfigurasiSistemController::class, 'update'])->name('konfigurasi_sistem.update');
    Route::delete('/konfigurasi_sistem/{id}', [KonfigurasiSistemController::class, 'destroy'])->name('konfigurasi_sistem.destroy');

    //pengaturan prioritas
    Route::get('/pengaturan_prioritas', [PengaturanController::class, 'index'])->name('pengaturan_prioritas.index');
    Route::get('/pengaturan_prioritas/{id}/edit', [PengaturanController::class, 'edit'])->name('pengaturan_prioritas.edit');
    Route::put('/pengaturan_prioritas/{id}', [PengaturanController::class, 'update'])->name('pengaturan_prioritas.update');
