@extends('layouts.app')

@section('title', 'Laporan Saya - SmartPath')

@section('content')
    @include('partials.nav-public')

    <main class="max-w-7xl mx-auto w-full px-4 py-8 sm:px-6 lg:px-8">
        {{-- Flash Message --}}
        @if(session('sukses'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800 flex items-center gap-2">
                <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600"></i>
                <span>{{ session('sukses') }}</span>
            </div>
        @endif

        {{-- Header Page --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Laporan Saya</h1>
                <p class="text-sm text-slate-500 mt-1">Daftar laporan hambatan yang Anda buat</p>
            </div>
            <div>
                <a href="{{ route('laporan.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-white border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-800 shadow-sm transition hover:bg-slate-50">
                    <i data-lucide="plus" class="w-4 h-4"></i>
                    Buat Laporan Baru
                </a>
            </div>
        </div>

        {{-- Filter Tabs Status --}}
        <div class="flex items-center gap-2 overflow-x-auto pb-2 mb-6 text-sm">
            <button class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-slate-900 bg-white font-medium text-slate-900 shadow-sm shrink-0">
                <i data-lucide="list-filter" class="w-4 h-4"></i>
                Semua
            </button>
            <button class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-slate-200 bg-white font-medium text-slate-600 hover:border-slate-300 shrink-0">
                <i data-lucide="clock" class="w-4 h-4"></i>
                Menunggu <span class="bg-slate-100 text-slate-700 text-xs px-2 py-0.5 rounded-full font-bold">3</span>
            </button>
            <button class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-slate-200 bg-white font-medium text-slate-600 hover:border-slate-300 shrink-0">
                <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                Diverifikasi <span class="bg-slate-100 text-slate-700 text-xs px-2 py-0.5 rounded-full font-bold">2</span>
            </button>
            <button class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-slate-200 bg-white font-medium text-slate-600 hover:border-slate-300 shrink-0">
                <i data-lucide="wrench" class="w-4 h-4"></i>
                Perbaikan <span class="bg-slate-100 text-slate-700 text-xs px-2 py-0.5 rounded-full font-bold">2</span>
            </button>
            <button class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-slate-200 bg-white font-medium text-slate-600 hover:border-slate-300 shrink-0">
                <i data-lucide="star" class="w-4 h-4"></i>
                Selesai <span class="bg-slate-100 text-slate-700 text-xs px-2 py-0.5 rounded-full font-bold">1</span>
            </button>
        </div>

        {{-- List Cards Laporan --}}
        <div class="space-y-4">
            @forelse($laporan ?? [] as $item)
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4 p-4 rounded-2xl border border-slate-200 bg-white shadow-sm hover:border-slate-300 transition">
                    <div class="flex flex-col sm:flex-row items-start gap-4 w-full lg:w-auto flex-1">
                        
                        {{-- Box Placeholder Gambar Wireframe / Foto --}}
                        <div class="w-full sm:w-36 h-28 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center shrink-0 overflow-hidden relative">
                            @if(isset($item->foto))
                                <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Laporan" class="w-full h-full object-cover">
                            @else
                                {{-- Visual Silang Wireframe Sesuai Design --}}
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-full h-full border-t border-b border-slate-200 transform -rotate-12 scale-125"></div>
                                    <div class="w-full h-full border-t border-b border-slate-200 transform rotate-12 scale-125 absolute"></div>
                                    <i data-lucide="image" class="w-7 h-7 text-slate-300 z-10 bg-slate-50 rounded-full p-1"></i>
                                </div>
                            @endif
                        </div>

                        {{-- Info Detail Laporan --}}
                        <div class="flex-1 space-y-1.5">
                            <div class="flex flex-wrap items-center gap-2 text-xs">
                                <span class="font-bold text-slate-700">{{ $item->kode ?? 'LAP-2024-081' }}</span>
                                
                                <span class="px-2.5 py-0.5 rounded-md border border-slate-300 text-slate-700 font-medium">
                                    {{ $item->status ?? 'Menunggu Verifikasi' }}
                                </span>
                                
                                <span class="px-2.5 py-0.5 rounded-md border border-slate-300 text-slate-700 font-medium flex items-center gap-1">
                                    <i data-lucide="alert-triangle" class="w-3 h-3 text-amber-500"></i>
                                    {{ $item->prioritas_label ?? 'Prioritas Tinggi' }}
                                </span>
                            </div>

                            <h3 class="text-base font-bold text-slate-900 leading-snug">
                                <a href="{{ route('laporan.show', $item->id ?? 1) }}" class="hover:text-emerald-600 transition">
                                    {{ $item->judul ?? 'Trotoar Rusak di Jalan Margonda Raya' }}
                                </a>
                            </h3>

                            <p class="text-sm text-slate-600 line-clamp-1">
                                {{ $item->deskripsi ?? 'Trotoar mengalami kerusakan parah dengan lubang besar yang membahayakan pejalan kaki.' }}
                            </p>

                            <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500 pt-1">
                                <span class="flex items-center gap-1">
                                    <i data-lucide="disc" class="w-3.5 h-3.5"></i>
                                    {{ $item->kategori ?? 'Trotoar' }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                                    {{ $item->lokasi ?? 'Jl. Margonda Raya No. 123, Depok' }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <i data-lucide="calendar" class="w-3.5 h-3.5"></i>
                                    {{ isset($item->created_at) ? $item->created_at->format('d M Y') : '14 Jul 2024' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Box Skor Prioritas (Sebelah Kanan) --}}
                    <div class="self-end lg:self-center shrink-0">
                        <div class="w-20 h-16 rounded-xl border border-slate-300 flex flex-col items-center justify-center p-2 text-center bg-white shadow-xs">
                            <span class="text-xl font-extrabold text-slate-900 leading-none">
                                {{ $item->skor_prioritas ?? '9.2' }}
                            </span>
                            <span class="text-[9px] font-bold tracking-wider text-slate-500 uppercase mt-1">
                                PRIORITAS
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                    <i data-lucide="folder-open" class="w-10 h-10 text-slate-400 mx-auto mb-2"></i>
                    <p class="text-slate-600 font-medium">Belum ada laporan yang Anda buat.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="flex items-center justify-end gap-2 mt-6 text-sm font-medium text-slate-600">
            <button class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-50">
                <i data-lucide="chevron-left" class="w-4 h-4"></i> Sebelumnya
            </button>
            <button class="px-3 py-1.5 rounded-lg border border-slate-900 bg-white text-slate-900 font-bold">1</button>
            <button class="px-3 py-1.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-50">2</button>
            <button class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-50">
                Selanjutnya <i data-lucide="chevron-right" class="w-4 h-4"></i>
            </button>
        </div>
    </main>
@endsection