@extends('layouts.app')

@section('title', 'Dashboard Warga - SmartPath')

@section('content')
    @include('partials.nav-public')

    <main class="max-w-7xl mx-auto w-full px-4 py-10 sm:px-6 lg:px-8">
        @if(session('sukses'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                {{ session('sukses') }}
            </div>
        @endif

        <div class="mb-8">
            <p class="text-sm font-semibold uppercase tracking-wide text-emerald-600">Dashboard Warga</p>
            <h1 class="mt-2 text-3xl font-bold text-slate-900">Halo, {{ $user->nama_lengkap ?? 'Warga' }}</h1>
            <p class="mt-2 text-slate-600">Kelola laporan aksesibilitas dan pantau perkembangannya di sini.</p>
        </div>

        <div class="grid gap-6 md:grid-cols-3">
            <!-- Buat Laporan -->
            <a href="{{ route('laporan.create') }}" class="rounded-2xl bg-emerald-600 p-6 text-white shadow-sm transition hover:bg-emerald-700 flex flex-col justify-between">
                <div>
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/30 flex items-center justify-center mb-4">
                        <i data-lucide="plus-circle" class="w-6 h-6 text-white"></i>
                    </div>
                    <h2 class="text-lg font-bold">Buat Laporan</h2>
                    <p class="mt-2 text-sm text-emerald-50">Laporkan hambatan aksesibilitas di sekitar Anda.</p>
                </div>
            </a>

            <!-- Laporan Saya (Mengarah ke Halaman Laporan) -->
            <a href="{{ route('laporan.index') }}" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:border-emerald-500 hover:shadow-md flex flex-col justify-between group">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                            <i data-lucide="file-text" class="w-6 h-6"></i>
                        </div>
                        <span class="text-3xl font-bold text-slate-900">{{ $jumlahLaporan ?? 0 }}</span>
                    </div>
                    <h2 class="text-lg font-bold text-slate-900 group-hover:text-emerald-600 transition">Laporan Saya</h2>
                    <p class="mt-2 text-sm text-slate-600">Lihat dan kelola seluruh laporan yang pernah Anda buat.</p>
                </div>
            </a>

            <!-- Peta Aksesibilitas -->
            <a href="{{ route('peta.index') }}" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:border-emerald-500 hover:shadow-md flex flex-col justify-between group">
                <div>
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 mb-4">
                        <i data-lucide="map-pin" class="w-6 h-6"></i>
                    </div>
                    <h2 class="text-lg font-bold text-slate-900 group-hover:text-emerald-600 transition">Peta Aksesibilitas</h2>
                    <p class="mt-2 text-sm text-slate-600">Jelajahi laporan dan fasilitas publik disabilitas.</p>
                </div>
            </a>
        </div>
    </main>
@endsection