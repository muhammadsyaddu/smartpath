<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\PetaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\VerifikasiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriHambatanController;
use App\Http\Controllers\FasilitasPublikController;
use App\Http\Controllers\PengaturanPrioritasController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\KonfigurasiSistemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuditController;

/*
|--------------------------------------------------------------------------
| Web Routes - SmartPath Platform Pemetaan Aksesibilitas Disabilitas
|--------------------------------------------------------------------------
*/

// ============================================
// RUTE PUBLIK (Tanpa Autentikasi)
// ============================================
Route::get('/', [BerandaController::class, 'index'])->name('beranda');

// Rute Newsletter
Route::post('/newsletter/subscribe', [BerandaController::class, 'subscribeNewsletter'])->name('newsletter.subscribe');

// Rute Peta Interaktif Leaflet.js & GIS
Route::get('peta', [PetaController::class, 'index'])->name('peta.index');
Route::get('peta/data', [PetaController::class, 'getLaporanData'])->name('peta.data');
Route::get('peta/fasilitas', [PetaController::class, 'getFasilitasData'])->name('peta.fasilitas');

// ============================================
// RUTE AUTENTIKASI
// ============================================
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// ============================================
// RUTE WARGA / TERAUTENTIKASI
// ============================================
Route::middleware(['auth'])->group(function () {
    // Laporan
    Route::resource('laporan', LaporanController::class)->except(['index']);
    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');

    // Notifikasi
    Route::get('notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');
    Route::post('notifikasi/{notifikasi}/baca', [NotifikasiController::class, 'markAsRead'])->name('notifikasi.read');
    Route::post('notifikasi/baca-semua', [NotifikasiController::class, 'markAllAsRead'])->name('notifikasi.read-all');
    Route::get('notifikasi/belum-dibaca', [NotifikasiController::class, 'unreadCount'])->name('notifikasi.unread-count');

    // Profil
    Route::get('profil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profil', [ProfileController::class, 'update'])->name('profile.update');
});

// ============================================
// RUTE ADMIN & DINAS (Autentikasi + Role Dinas)
// ============================================
Route::middleware(['auth', 'dinas'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard/chart', [DashboardController::class, 'getChartData'])->name('dashboard.chart');

    // Verifikasi Laporan
    Route::get('verifikasi', [VerifikasiController::class, 'index'])->name('verifikasi.index');
    Route::get('verifikasi/{laporan}', [VerifikasiController::class, 'show'])->name('verifikasi.show');
    Route::post('verifikasi/{laporan}/setujui', [VerifikasiController::class, 'approve'])->name('verifikasi.approve');
    Route::post('verifikasi/{laporan}/tolak', [VerifikasiController::class, 'reject'])->name('verifikasi.reject');
    Route::post('verifikasi/{laporan}/kembalikan', [VerifikasiController::class, 'return'])->name('verifikasi.return');
    Route::post('verifikasi/{laporan}/perbaikan', [VerifikasiController::class, 'markInProgress'])->name('verifikasi.in-progress');
    Route::post('verifikasi/{laporan}/selesai', [VerifikasiController::class, 'markCompleted'])->name('verifikasi.completed');
});

// ============================================
// RUTE ADMINISTRATOR SAJA
// ============================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Kategori Hambatan
    Route::resource('kategori-hambatan', KategoriHambatanController::class)->parameters([
        'kategori-hambatan' => 'kategoriHambatan',
    ]);

    // Fasilitas Publik
    Route::resource('fasilitas-publik', FasilitasPublikController::class)->parameters([
        'fasilitas-publik' => 'fasilitasPublik',
    ]);

    // Pengaturan Prioritas
    Route::resource('pengaturan-prioritas', PengaturanPrioritasController::class)->parameters([
        'pengaturan-prioritas' => 'pengaturanPrioritas',
    ]);
    Route::post('pengaturan-prioritas/{pengaturanPrioritas}/aktifkan', [PengaturanPrioritasController::class, 'activate'])->name('pengaturan-prioritas.activate');
    Route::post('pengaturan-prioritas/hitung-ulang', [PengaturanPrioritasController::class, 'recalculate'])->name('pengaturan-prioritas.recalculate');

    // Wilayah
    Route::resource('wilayah', WilayahController::class);

    // Konfigurasi Sistem
    Route::resource('konfigurasi-sistem', KonfigurasiSistemController::class)->except(['create', 'show', 'destroy'])->parameters([
        'konfigurasi-sistem' => 'konfigurasiSistem',
    ]);

    // User Management
    Route::resource('user', UserController::class);

    // Audit Log
    Route::get('audit', [AuditController::class, 'index'])->name('audit.index');
    Route::get('audit/{audit}', [AuditController::class, 'show'])->name('audit.show');
});