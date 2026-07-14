@extends('layouts.app')

@section('title', 'Laporan Saya')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Laporan Saya</h1>
            <p class="text-sm text-slate-500 mt-1">Daftar laporan hambatan yang Anda buat</p>
        </div>
        <a href="{{ route('laporan.create') }}" class="inline-flex items-center gap-2 bg-emerald-600 text-white font-semibold px-5 py-2.5 rounded-xl hover:bg-emerald-700 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Laporan Baru
        </a>
    </div>

    {{-- Filter tabs --}}
    <div class="bg-white rounded-xl border border-slate-200 p-1 mb-6 inline-flex gap-1" role="tablist" aria-label="Filter status laporan">
        <a href="{{ route('laporan.index') }}" class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ !request('status') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-500 hover:text-slate-700' }}" role="tab" aria-selected="{{ !request('status') ? 'true' : 'false' }}">Semua</a>
        <a href="{{ route('laporan.index', ['status' => 'menunggu_verifikasi']) }}" class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ request('status') === 'menunggu_verifikasi' ? 'bg-amber-50 text-amber-700' : 'text-slate-500 hover:text-slate-700' }}" role="tab" aria-selected="{{ request('status') === 'menunggu_verifikasi' ? 'true' : 'false' }}">Menunggu</a>
        <a href="{{ route('laporan.index', ['status' => 'diverifikasi']) }}" class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ request('status') === 'diverifikasi' ? 'bg-emerald-50 text-emerald-700' : 'text-slate-500 hover:text-slate-700' }}" role="tab" aria-selected="{{ request('status') === 'diverifikasi' ? 'true' : 'false' }}">Diverifikasi</a>
        <a href="{{ route('laporan.index', ['status' => 'dalam_perbaikan']) }}" class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ request('status') === 'dalam_perbaikan' ? 'bg-teal-50 text-teal-700' : 'text-slate-500 hover:text-slate-700' }}" role="tab" aria-selected="{{ request('status') === 'dalam_perbaikan' ? 'true' : 'false' }}">Perbaikan</a>
        <a href="{{ route('laporan.index', ['status' => 'selesai']) }}" class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ request('status') === 'selesai' ? 'bg-green-50 text-green-700' : 'text-slate-500 hover:text-slate-700' }}" role="tab" aria-selected="{{ request('status') === 'selesai' ? 'true' : 'false' }}">Selesai</a>
    </div>

    {{-- Reports list --}}
    @if($laporan->count() > 0)
        <div class="space-y-4">
            @foreach($laporan as $item)
                <article class="bg-white rounded-xl border border-slate-200 hover:shadow-sm transition-shadow overflow-hidden" aria-label="Laporan: {{ $item->judul }}">
                    <div class="flex flex-col sm:flex-row">
                        {{-- Photo --}}
                        @if($item->fotoUtama)
                            <div class="sm:w-48 h-40 sm:h-auto flex-shrink-0">
                                <img src="{{ $item->fotoUtama->url }}" alt="Foto: {{ $item->judul }}" class="w-full h-full object-cover" loading="lazy">
                            </div>
                        @else
                            <div class="sm:w-48 h-40 sm:h-auto flex-shrink-0 bg-slate-100 flex items-center justify-center">
                                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif

                        {{-- Content --}}
                        <div class="flex-1 p-4 sm:p-5">
                            <div class="flex items-start justify-between gap-3">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 mb-1.5">
                                        <span class="text-xs font-mono text-slate-400">{{ $item->kode_laporan }}</span>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-semibold {{ $item->warna }}">{{ $item->status_label }}</span>
                                        @if($item->tingkat_prioritas === 'tinggi')
                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded-md text-[10px] font-bold bg-red-100 text-red-700">Prioritas Tinggi</span>
                                        @endif
                                    </div>
                                    <h3 class="font-semibold text-slate-900 mb-1">
                                        <a href="{{ route('laporan.show', $item) }}" class="hover:text-emerald-700 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 rounded">
                                            {{ $item->judul }}
                                        </a>
                                    </h3>
                                    <p class="text-sm text-slate-500 line-clamp-2 mb-2">{{ $item->deskripsi }}</p>
                                    <div class="flex items-center gap-4 text-xs text-slate-400">
                                        @if($item->kategoriHambatan)
                                            <span class="flex items-center gap-1">
                                                <span class="w-2 h-2 rounded-full" style="background-color: {{ $item->kategoriHambatan->warna_penanda }}" aria-hidden="true"></span>
                                                {{ $item->kategoriHambatan->nama }}
                                            </span>
                                        @endif
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                            {{ Str::limit($item->alamat_lengkap, 40) }}
                                        </span>
                                        <time datetime="{{ $item->created_at->format('Y-m-d') }}">{{ $item->created_at->diffForHumans() }}</time>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end gap-2">
                                    @if($item->skor_prioritas)
                                        <div class="text-center bg-slate-50 rounded-lg px-2.5 py-1.5" title="Skor Prioritas">
                                            <p class="text-lg font-bold text-slate-700">{{ number_format($item->skor_prioritas, 1) }}</p>
                                            <p class="text-[10px] text-slate-400 uppercase">Prioritas</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($laporan->hasPages())
            <div class="mt-8 flex justify-center" role="navigation" aria-label="Navigasi halaman">
                {{ $laporan->withQueryString()->links('pagination::tailwind', [
                    'aria-label' => 'Halaman laporan'
                ]) }}
            </div>
        @endif
    @else
        <div class="text-center py-16 bg-white rounded-xl border border-slate-200">
            <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <h3 class="text-lg font-semibold text-slate-600 mb-2">Belum Ada Laporan</h3>
            <p class="text-sm text-slate-400 mb-6">Anda belum membuat laporan hambatan apapun</p>
            <a href="{{ route('laporan.create') }}" class="inline-flex items-center gap-2 bg-emerald-600 text-white font-semibold px-5 py-2.5 rounded-xl hover:bg-emerald-700 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Buat Laporan Pertama
            </a>
        </div>
    @endif
</div>
@endsection