@extends('layouts.app')

@section('title', 'Dashboard Warga')

@section('content')
    @include('partials.nav-public')

    <main class="max-w-7xl mx-auto w-full px-4 py-10 sm:px-6 lg:px-8">
        @if(session('sukses'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                {{ session('sukses') }}
            </div>
        @endif

        <div class="mb-8">
            <p class="text-sm font-semibold uppercase tracking-wide text-emerald-600">Dashboard warga</p>
            <h1 class="mt-2 text-3xl font-bold text-slate-900">Halo, {{ $user->nama_lengkap }}</h1>
            <p class="mt-2 text-slate-600">Kelola laporan aksesibilitas dan pantau perkembangannya di sini.</p>
        </div>

        <div class="grid gap-6 md:grid-cols-3">
            <a href="{{ route('laporan.create') }}" class="rounded-2xl bg-emerald-600 p-6 text-white shadow-sm transition hover:bg-emerald-700">
                <h2 class="text-lg font-bold">Buat laporan</h2>
                <p class="mt-2 text-sm text-emerald-50">Laporkan hambatan aksesibilitas di sekitar Anda.</p>
            </a>

            <a href="{{ route('laporan.index') }}" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:border-emerald-300">
                <p class="text-sm font-medium text-slate-500">Laporan saya</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">{{ $jumlahLaporan }}</p>
                <p class="mt-2 text-sm text-slate-600">Lihat laporan yang pernah dibuat.</p>
            </a>

            <a href="{{ route('peta.index') }}" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:border-emerald-300">
                <h2 class="text-lg font-bold text-slate-900">Peta aksesibilitas</h2>
                <p class="mt-2 text-sm text-slate-600">Jelajahi laporan dan fasilitas publik.</p>
            </a>
        </div>
    </main>
@endsection