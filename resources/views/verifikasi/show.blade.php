@extends('layouts.admin')

@section('title', 'Verifikasi - ' . $laporan->kode_laporan)
@section('page_title', 'Verifikasi Laporan')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@section('content')
<div class="space-y-6">
    {{-- Breadcrumb --}}
    <nav class="text-sm text-slate-400" aria-label="Breadcrumb">
        <ol class="flex items-center gap-2">
            <li><a href="{{ route('admin.verifikasi.index') }}" class="hover:text-emerald-700 transition-colors">Verifikasi</a></li>
            <li aria-hidden="true">/</li>
            <li class="text-slate-700 font-medium" aria-current="page">{{ $laporan->kode_laporan }}</li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main content --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Report detail --}}
            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <div class="flex items-start justify-between gap-3 mb-4">
                    <div>
                        <span class="text-xs font-mono text-slate-400">{{ $laporan->kode_laporan }}</span>
                        <h2 class="text-lg font-bold text-slate-900 mt-1">{{ $laporan->judul }}</h2>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-semibold {{ $laporan->warna }} whitespace-nowrap">
                        {{ $laporan->status_label }}
                    </span>
                </div>

                <div class="flex flex-wrap items-center gap-2 mb-4">
                    @if($laporan->kategoriHambatan)
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-slate-100 text-sm text-slate-700">
                            <span class="w-2.5 h-2.5 rounded-full" style="background-color: {{ $laporan->kategoriHambatan->warna_penanda }}" aria-hidden="true"></span>
                            {{ $laporan->kategoriHambatan->nama }}
                        </span>
                    @endif
                    <span class="text-xs text-slate-400">{{ $laporan->created_at->format('d M Y H:i') }}</span>
                </div>

                <p class="text-slate-700 leading-relaxed mb-4">{{ $laporan->deskripsi }}</p>

                <div class="flex items-center gap-2 text-sm text-slate-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                    {{ $laporan->alamat_lengkap }}
                </div>
            </div>

            {{-- Photos --}}
            @if($laporan->fotoLaporan->count() > 0)
                <div class="bg-white rounded-xl border border-slate-200 p-6">
                    <h3 class="font-semibold text-slate-900 mb-4">Foto Laporan</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        @foreach($laporan->fotoLaporan as $foto)
                            <div class="relative overflow-hidden rounded-lg">
                                <img src="{{ $foto->url }}" alt="Foto laporan {{ $loop->iteration }}" class="w-full h-40 object-cover" loading="lazy">
                                @if($foto->adalah_utama)
                                    <span class="absolute top-1.5 left-1.5 px-1.5 py-0.5 bg-emerald-600 text-white text-[10px] font-bold rounded-md">Utama</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Map --}}
            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <h3 class="font-semibold text-slate-900 mb-4">Lokasi</h3>
                <div id="verifikasi-map" class="w-full h-64 rounded-xl" role="application" aria-label="Peta lokasi laporan"></div>
            </div>

            {{-- Duplicate reports --}}
            @if($laporan->laporanInduk)
                <div class="bg-amber-50 rounded-xl border border-amber-200 p-6">
                    <h3 class="font-semibold text-amber-800 mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Laporan Duplikat
                    </h3>
                    <p class="text-sm text-amber-700 mb-2">Laporan ini terdeteksi sebagai duplikat dari:</p>
                    <a href="{{ route('admin.verifikasi.show', $laporan->laporanInduk) }}" class="inline-flex items-center gap-1 text-sm font-medium text-amber-800 hover:text-amber-900">
                        {{ $laporan->laporanInduk->kode_laporan }} — {{ $laporan->laporanInduk->judul }} →
                    </a>
                </div>
            @endif

            {{-- Verification history --}}
            @if($laporan->verifikasi->count() > 0)
                <div class="bg-white rounded-xl border border-slate-200 p-6">
                    <h3 class="font-semibold text-slate-900 mb-4">Riwayat Verifikasi</h3>
                    <div class="space-y-4">
                        @foreach($laporan->verifikasi as $v)
                            <div class="flex gap-3 p-3 rounded-lg bg-slate-50">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-semibold {{ $v->warna }} shrink-0">{{ $v->keputusan_label }}</span>
                                <div>
                                    <p class="text-sm text-slate-700">{{ $v->catatan_admin }}</p>
                                    <p class="text-xs text-slate-400 mt-1">{{ $v->admin->nama_lengkap ?? 'Sistem' }} • {{ $v->created_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- Sidebar: Actions & Info --}}
        <div class="space-y-6">
            {{-- Priority Score --}}
            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <h3 class="font-semibold text-slate-900 mb-4 text-sm uppercase tracking-wider">Skor Prioritas</h3>
                @if($laporan->skor_prioritas)
                    <div class="text-center mb-4">
                        <p class="text-3xl font-bold {{ $laporan->tingkat_prioritas === 'tinggi' ? 'text-red-600' : ($laporan->tingkat_prioritas === 'sedang' ? 'text-amber-600' : 'text-blue-600') }}">
                            {{ number_format($laporan->skor_prioritas, 2) }}
                        </p>
                        <p class="text-xs text-slate-400 uppercase mt-1">{{ $laporan->tingkat_prioritas }}</p>
                    </div>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between"><span class="text-slate-500">Keparahan</span><span class="font-medium">{{ number_format($laporan->skor_keparahan, 2) }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-500">Pelapor</span><span class="font-medium">{{ number_format($laporan->skor_pelapor, 2) }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-500">Fasilitas</span><span class="font-medium">{{ number_format($laporan->skor_fasilitas, 2) }}</span></div>
                        <div class="flex justify-between"><span class="text-slate-500">Jumlah Pelapor</span><span class="font-medium">{{ $laporan->jumlah_pelapor }}</span></div>
                    </div>
                @else
                    <p class="text-sm text-slate-400 text-center py-4">Skor belum dihitung</p>
                @endif
            </div>

            {{-- Reporter --}}
            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <h3 class="font-semibold text-slate-900 mb-3 text-sm uppercase tracking-wider">Pelapor</h3>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-700 font-semibold text-sm">
                        {{ strtoupper(substr($laporan->pelapor->nama_lengkap ?? 'NA', 0, 2)) }}
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-700">{{ $laporan->pelapor->nama_lengkap ?? '-' }}</p>
                        <p class="text-xs text-slate-400">{{ $laporan->pelapor->email ?? '-' }}</p>
                    </div>
                </div>
            </div>

            {{-- Verification Actions --}}
            @if(in_array($laporan->status, ['menunggu_verifikasi', 'diverifikasi', 'dalam_perbaikan']))
                <div class="bg-white rounded-xl border border-slate-200 p-6">
                    <h3 class="font-semibold text-slate-900 mb-4">Aksi Verifikasi</h3>

                    {{-- Verification form --}}
                    <form id="verifikasi-form" method="POST" action="" class="space-y-4">
                        @csrf
                        <div>
                            <label for="catatan_admin" class="block text-sm font-medium text-slate-700 mb-1.5">Catatan Admin</label>
                            <textarea id="catatan_admin" name="catatan_admin" rows="3" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm" placeholder="Tambahkan catatan verifikasi..."></textarea>
                        </div>
                        <div>
                            <label for="kategori_koreksi" class="block text-sm font-medium text-slate-700 mb-1.5">Kategori Koreksi (opsional)</label>
                            <select id="kategori_koreksi" name="kategori_koreksi" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                                <option value="">Tidak ada koreksi</option>
                                <option value="kategori_salah">Kategori Salah</option>
                                <option value="lokasi_tidak_tepat">Lokasi Tidak Tepat</option>
                                <option value="duplikat">Duplikat</option>
                                <option value="tidak_relevan">Tidak Relevan</option>
                                <option value="informasi_kurang">Informasi Kurang</option>
                            </select>
                        </div>
                    </form>

                    {{-- Action buttons --}}
                    <div class="space-y-2 mt-4">
                        @if($laporan->status === 'menunggu_verifikasi')
                            <button type="button" onclick="submitVerifikasi('{{ route("admin.verifikasi.approve", $laporan) }}')" class="w-full inline-flex items-center justify-center gap-2 bg-emerald-600 text-white font-medium px-4 py-2.5 rounded-xl hover:bg-emerald-700 transition-colors text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Setujui Laporan
                            </button>
                            <button type="button" onclick="submitVerifikasi('{{ route("admin.verifikasi.reject", $laporan) }}')" class="w-full inline-flex items-center justify-center gap-2 bg-white text-red-600 font-medium px-4 py-2.5 rounded-xl border border-red-200 hover:bg-red-50 transition-colors text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                Tolak Laporan
                            </button>
                            <button type="button" onclick="submitVerifikasi('{{ route("admin.verifikasi.return", $laporan) }}')" class="w-full inline-flex items-center justify-center gap-2 bg-white text-amber-600 font-medium px-4 py-2.5 rounded-xl border border-amber-200 hover:bg-amber-50 transition-colors text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                                Kembalikan ke Warga
                            </button>
                        @elseif($laporan->status === 'diverifikasi')
                            <button type="button" onclick="confirmAction('{{ route("admin.verifikasi.in-progress", $laporan) }}', 'Tandai sebagai dalam perbaikan?')" class="w-full inline-flex items-center justify-center gap-2 bg-teal-600 text-white font-medium px-4 py-2.5 rounded-xl hover:bg-teal-700 transition-colors text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
                                Tandai Dalam Perbaikan
                            </button>
                        @elseif($laporan->status === 'dalam_perbaikan')
                            <button type="button" onclick="confirmAction('{{ route("admin.verifikasi.completed", $laporan) }}', 'Tandai sebagai selesai?')" class="w-full inline-flex items-center justify-center gap-2 bg-green-600 text-white font-medium px-4 py-2.5 rounded-xl hover:bg-green-700 transition-colors text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Tandai Selesai
                            </button>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const map = L.map('verifikasi-map', { center: [{{ $laporan->latitude }}, {{ $laporan->longitude }}], zoom: 16 });
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OSM', maxZoom: 19 }).addTo(map);
    L.marker([{{ $laporan->latitude }}, {{ $laporan->longitude }}]).addTo(map).bindPopup('{{ addslashes($laporan->judul) }}').openPopup();
});

function submitVerifikasi(action) {
    const form = document.getElementById('verifikasi-form');
    form.action = action;
    form.submit();
}

function confirmAction(action, message) {
    if (confirm(message)) {
        const form = document.getElementById('verifikasi-form');
        form.action = action;
        form.submit();
    }
}
</script>
@endpush
