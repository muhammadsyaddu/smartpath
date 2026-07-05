<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KonfigurasiSistemController;
use App\Http\Controllers\PengaturanPrioritasController;

Route::get('home', function () {
    return view('welcome');
});

//konfigurasi sistem
Route::get('konfigurasi_sistem', [KonfigurasiSistemController::class, 'index'])->name('konfigurasi_sistem.index');
Route::post('konfigurasi_sistem/update', [KonfigurasiSistemController::class, 'update'])->name('konfigurasi_sistem.update');

//PENGATURAN PRIORITAS
Route::get('pengaturan_prioritas', [PengaturanPrioritasController::class, 'index'])->name('pengaturan_prioritas.index');
Route::get('pengaturan_prioritas/{id}/edit', [PengaturanPrioritasController::class, 'edit'])->name('pengaturan_prioritas.edit');
Route::put('pengaturan_prioritas/{id}', [PengaturanPrioritasController::class, 'update'])->name('pengaturan_prioritas.update');
Route::post('pengaturan_prioritas/activate/{id}', [PengaturanPrioritasController::class, 'activate'])->name('pengaturan_prioritas.activate');
