@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<section class="relative overflow-hidden bg-gradient-to-br from-emerald-700 via-emerald-800 to-teal-900" aria-labelledby="hero-heading">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="text-white">
                <p class="text-emerald-200 text-sm font-medium mb-2 tracking-wider uppercase">Platform Aksesibilitas Kota</p>
                <h1 id="hero-heading" class="text-3xl lg:text-5xl font-bold leading-tight mb-6">Pemetaan Aksesibilitas Infrastruktur Disabilitas</h1>
                <p class="text-emerald-100 text-lg leading-relaxed mb-8">SmartPath membantu menyaring, memetakan, dan memprioritaskan hambatan aksesibilitas infrastruktur publik bagi penyandang disabilitas secara data-driven.</p>
                <div class="flex flex-wrap gap-4">
                    @auth
                        <a href="{{ route('laporan.create') }}" class="inline-flex items-center gap-2 bg-white text-emerald-700 font-semibold px-6 py-3 rounded-xl hover:bg-emerald-50 transition-colors focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-emerald-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Laporkan Hambatan
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-white text-emerald-700 font-semibold px-6 py-3 rounded-xl hover:bg-emerald-50 transition-colors focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-emerald-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                            Masuk untuk Melapor
                        </a>
                    @endauth
                    <a href="{{ route('peta.index') }}" class="inline-flex items-center gap-2 border-2 border-white text-white font-semibold px-6 py-3 rounded-xl hover:bg-white/10 transition-colors focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-emerald-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                        Lihat Peta
                    </a>
                </div>
            </div>
            <div class="hidden lg:flex justify-center">
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20 w-full max-w-md">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-white/10 rounded-xl p-4 text-center">
                            <p class="text-2xl font-bold text-white">{{ $totalLaporan }}</p>
                            <p class="text-emerald-200 text-xs mt-1">Total Laporan</p>
                        </div>
                        <div class="bg-white/10 rounded-xl p-4 text-center">
                            <p class="text-2xl font-bold text-white">{{ $totalTerverifikasi }}</p>
                            <p class="text-emerald-200 text-xs mt-1">Terverifikasi</p>
                        </div>
                        <div class="bg-white/10 rounded-xl p-4 text-center">
                            <p class="text-2xl font-bold text-white">{{ $totalDalamPerbaikan }}</p>
                            <p class="text-emerald-200 text-xs mt-1">Dalam Perbaikan</p>
                        </div>
                        <div class="bg-white/10 rounded-xl p-4 text-center">
                            <p class="text-2xl font-bold text-white">{{ $totalSelesai }}</p>
                            <p class="text-emerald-200 text-xs mt-1">Selesai</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16" aria-labelledby="cara-kerja-heading">
    <div class="text-center mb-12">
        <h2 id="cara-kerja-heading" class="text-2xl font-bold text-slate-900 mb-3">Cara Kerja SmartPath</h2>
        <p class="text-slate-500 max-w-2xl mx-auto">Empat langkah sederhana untuk berkontribusi memperbaiki aksesibilitas kota</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        <div class="text-center">
            <div class="w-14 h-14 bg-emerald-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <h3 class="font-semibold text-slate-900 mb-2">Laporkan</h3>
            <p class="text-sm text-slate-500">Unggah foto, pilih kategori hambatan, dan tandai lokasi pada peta</p>
        </div>
        <div class="text-center">
            <div class="w-14 h-14 bg-teal-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="font-semibold text-slate-900 mb-2">Verifikasi</h3>
            <p class="text-sm text-slate-500">Administrator memverifikasi dan mengelompokkan laporan duplikat</p>
        </div>
        <div class="text-center">
            <div class="w-14 h-14 bg-amber-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </div>
            <h3 class="font-semibold text-slate-900 mb-2">Prioritaskan</h3>
            <p class="text-sm text-slate-500">Sistem menghitung skor prioritas secara otomatis berbasis aturan</p>
        </div>
        <div class="text-center">
            <div class="w-14 h-14 bg-slate-100 rounded-xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <h3 class="font-semibold text-slate-900 mb-2">Petakan</h3>
            <p class="text-sm text-slate-500">Hambatan divisualisasikan pada peta digital interaktif</p>
        </div>
    </div>
</section>

@if($laporanPrioritasTinggi->count() > 0)
<section class="bg-white border-y border-slate-200" aria-labelledby="prioritas-heading">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex items-center justify-between mb-8">
            <h2 id="prioritas-heading" class="text-xl font-bold text-slate-900">Laporan Prioritas Tinggi</h2>
            <a href="{{ route('peta.index') }}" class="text-sm font-medium text-emerald-700 hover:text-emerald-800 transition-colors">Lihat semua &rarr;</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($laporanPrioritasTinggi as $laporan)
                @include('components.laporan-card', ['laporan' => $laporan])
            @endforeach
        </div>
    </div>
</section>
@endif

@if($kategoriHambatan->count() > 0)
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16" aria-labelledby="kategori-heading">
    <div class="text-center mb-8">
        <h2 id="kategori-heading" class="text-xl font-bold text-slate-900 mb-2">Kategori Hambatan</h2>
        <p class="text-slate-500 text-sm">Jenis hambatan aksesibilitas yang dapat dilaporkan</p>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        @foreach($kategoriHambatan as $kategori)
            <div class="bg-white rounded-xl border border-slate-200 p-4 text-center hover:shadow-sm transition-shadow">
                <div class="w-3 h-3 rounded-full mx-auto mb-2" style="background-color: {{ $kategori->warna_penanda }}" aria-hidden="true"></div>
                <p class="text-sm font-medium text-slate-800">{{ $kategori->nama }}</p>
                <p class="text-xs text-slate-400 mt-1">{{ $kategori->tingkat_keparahan }}</p>
            </div>
        @endforeach
    </div>
</section>
@endif
@endsection