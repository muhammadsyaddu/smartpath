@extends('layouts.admin')

@section('title', 'Dashboard Monitoring Aksesibilitas Kota Depok')

@push('styles')
<!-- Leaflet.js CDN (Tanpa Perlu Vite) -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
    .custom-gis-marker { background: transparent; border: none; }
    .leaflet-popup-content-wrapper { border-radius: 0.75rem; padding: 0; overflow: hidden; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); }
    .leaflet-popup-content { margin: 0; }
</style>
@endpush

@section('content')
<div class="space-y-6">

    <!-- Flash Alert Sukses / Info -->
    @if(session('sukses') || session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-2">
                <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600"></i>
                <span class="font-medium">{{ session('sukses') ?? session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-800">✕</button>
        </div>
    @endif

    <!-- 1. BANNER HEADER DASHBOARD -->
    <div class="bg-gradient-to-r from-emerald-900 via-slate-900 to-slate-900 text-white rounded-2xl p-6 shadow-md border border-emerald-800/40 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-semibold border border-emerald-500/30 mb-2">
                <i data-lucide="shield-check" class="w-3.5 h-3.5"></i>
                <span>SmartPath • Sistem Monitoring Disabilitas & Pejalan Kaki</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-white leading-tight">
                Panel Administrator & Verifikasi Laporan
            </h1>
            <p class="text-xs sm:text-sm text-slate-300 mt-1">
                Wilayah Kota Depok • Rata-rata Skor Urgensi: <strong class="text-emerald-400">{{ number_format($rataRataSkor ?? 0, 1) }}/100</strong> • Total Pelapor Aktif: <strong class="text-white">{{ number_format($totalPelapor ?? 0) }} Warga</strong>
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.verifikasi.index') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-semibold rounded-xl shadow-xs transition-colors flex items-center gap-2">
                <i data-lucide="check-square" class="w-4 h-4"></i>
                <span>Verifikasi Laporan Masuk ({{ $menungguVerifikasi ?? 0 }})</span>
            </a>
        </div>
    </div>

    <!-- 2. KARTU STATISTIK METRICS UTAMA (Variables Dari Controller Anda) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Laporan -->
        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Laporan Induk</span>
                <div class="w-9 h-9 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center">
                    <i data-lucide="file-text" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="text-2xl font-bold text-slate-900 tracking-tight">{{ number_format($totalLaporan ?? 0) }}</div>
            <p class="text-[11px] text-slate-500 mt-1 flex items-center gap-1">
                <span class="text-emerald-700 font-semibold">{{ $perKategori->count() }} Kategori</span> terdaftar di sistem
            </p>
        </div>

        <!-- Menunggu Verifikasi -->
        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold text-amber-700 uppercase tracking-wider">Menunggu Verifikasi</span>
                <div class="w-9 h-9 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                    <i data-lucide="clock" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="text-2xl font-bold text-slate-900 tracking-tight">{{ number_format($menungguVerifikasi ?? 0) }}</div>
            <p class="text-[11px] text-amber-600 mt-1 font-medium">Membutuhkan validasi foto & koordinat</p>
        </div>

        <!-- Terverifikasi / Dalam Perbaikan -->
        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold text-emerald-700 uppercase tracking-wider">Proses Penanganan</span>
                <div class="w-9 h-9 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <i data-lucide="wrench" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="text-2xl font-bold text-slate-900 tracking-tight">{{ number_format(($diverifikasi ?? 0) + ($dalamPerbaikan ?? 0)) }}</div>
            <p class="text-[11px] text-slate-500 mt-1">
                {{ $dalamPerbaikan ?? 0 }} dalam perbaikan fisik di lokasi
            </p>
        </div>

        <!-- Selesai Disterilkan -->
        <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-xs">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold text-green-700 uppercase tracking-wider">Hambatan Selesai</span>
                <div class="w-9 h-9 rounded-lg bg-green-50 text-green-600 flex items-center justify-center">
                    <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                </div>
            </div>
            <div class="text-2xl font-bold text-slate-900 tracking-tight">{{ number_format($selesai ?? 0) }}</div>
            <p class="text-[11px] text-green-700 mt-1 font-medium">Trotoar kembali ramah disabilitas</p>
        </div>
    </div>

    <!-- 3. PETA GEOSPASIAL GIS LEAFLET & PRIORITAS TINGGI -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Leaflet Map Container -->
        <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 shadow-xs overflow-hidden flex flex-col">
            <div class="p-4 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-700 flex items-center justify-center font-bold">
                        <i data-lucide="map" class="w-4 h-4"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-slate-900 text-sm">Peta Sebaran Titik Hambatan Kota Depok</h3>
                        <p class="text-[11px] text-slate-500">Visualisasi geospasial laporan aktif berbasis OpenStreetMap & Leaflet.js</p>
                    </div>
                </div>
                <button onclick="mapRecenter()" class="px-2 py-1 rounded-lg border border-slate-200 text-slate-600 hover:text-emerald-700 text-xs flex items-center gap-1">
                    <i data-lucide="compass" class="w-3.5 h-3.5"></i>
                    <span>Pusat Depok</span>
                </button>
            </div>
            <div class="relative w-full h-[360px] bg-slate-100">
                <div id="smartpath-leaflet-map" class="w-full h-full z-0"></div>
            </div>
        </div>

        <!-- Panel 10 Laporan Prioritas Tinggi -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-xs flex flex-col">
            <div class="p-4 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <i data-lucide="alert-triangle" class="w-4 h-4 text-rose-600"></i>
                    <h3 class="font-semibold text-slate-900 text-sm">Prioritas Tinggi (Skor ≥ 70)</h3>
                </div>
                <span class="text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-200 px-2 py-0.5 rounded">
                    Algoritma AI Prioritas
                </span>
            </div>
            <div class="p-3 divide-y divide-slate-100 overflow-y-auto max-h-[360px]">
                @forelse($prioritasTinggi as $item)
                    <div class="py-2.5 first:pt-0 last:pb-0 space-y-1">
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-mono font-bold text-slate-900 text-[11px]">{{ $item->kode_laporan ?? ('#LAP-' . $item->id) }}</span>
                            <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-rose-100 text-rose-800">
                                Skor {{ number_format($item->skor_prioritas, 0) }}
                            </span>
                        </div>
                        <h4 class="font-semibold text-slate-800 text-xs line-clamp-1">{{ $item->judul }}</h4>
                        <p class="text-[11px] text-slate-500 line-clamp-1">
                            📍 Kec. {{ $item->wilayah->nama ?? '-' }} • {{ $item->kategoriHambatan->nama ?? 'Umum' }}
                        </p>
                    </div>
                @empty
                    <div class="p-6 text-center text-slate-400 text-xs">
                        Tidak ada laporan dengan urgensi tinggi saat ini.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- 4. TABEL LAPORAN TERBARU MASUK -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="p-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div>
                <h3 class="font-semibold text-slate-900 text-sm">Antrean Laporan Terbaru (Menunggu Verifikasi)</h3>
                <p class="text-[11px] text-slate-500">Laporan terbaru yang dikirimkan warga masyarakat melalui platform SmartPath</p>
            </div>
            <a href="{{ route('admin.verifikasi.index') }}" class="text-xs font-semibold text-emerald-700 hover:text-emerald-800 flex items-center gap-1">
                <span>Buka Panel Verifikasi Lengkap</span>
                <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-slate-700 uppercase tracking-wider font-semibold text-[11px] border-b border-slate-200">
                    <tr>
                        <th class="py-3 px-4">Kode Tiket</th>
                        <th class="py-3 px-4">Judul Hambatan</th>
                        <th class="py-3 px-4">Kategori</th>
                        <th class="py-3 px-4">Pelapor</th>
                        <th class="py-3 px-4">Waktu Lapor</th>
                        <th class="py-3 px-4 text-center">Aksi Cepat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($laporanBaru as $laporan)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 px-4 font-mono font-bold text-slate-900">
                                {{ $laporan->kode_laporan ?? ('#LAP-' . $laporan->id) }}
                            </td>
                            <td class="py-3 px-4 max-w-[260px]">
                                <span class="font-semibold text-slate-900 block line-clamp-1">{{ $laporan->judul }}</span>
                                <span class="text-[11px] text-slate-500 line-clamp-1">{{ $laporan->deskripsi }}</span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    {{ $laporan->kategoriHambatan->nama ?? 'Hambatan Akses' }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="font-medium text-slate-800 block">{{ $laporan->pelapor->name ?? 'Warga Depok' }}</span>
                            </td>
                            <td class="py-3 px-4 text-slate-500 font-mono text-[11px]">
                                {{ $laporan->created_at->format('d M Y H:i') }}
                            </td>
                            <td class="py-3 px-4 text-center">
                                <a href="{{ route('admin.verifikasi.show', $laporan->id) }}" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-emerald-600 text-white font-semibold text-xs hover:bg-emerald-700 shadow-xs transition-colors">
                                    <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                    <span>Tinjau</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">
                                <i data-lucide="check-circle" class="w-6 h-6 mx-auto mb-1 text-slate-300"></i>
                                <p class="font-medium">Semua laporan telah diverifikasi!</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    let mapInstance;
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        // Inisialisasi Peta Leaflet (Pusat Kota Depok)
        mapInstance = L.map('smartpath-leaflet-map', {
            center: [-6.3850, 106.8300],
            zoom: 13,
            zoomControl: true
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors | SmartPath Kota Depok'
        }).addTo(mapInstance);

        // Ambil Data Titik Laporan Terverifikasi dari Controller
        const points = @json($prioritasTinggi ?? []);
        if (Array.isArray(points)) {
            points.forEach(function(item) {
                if (item.latitude && item.longitude) {
                    const customPin = L.divIcon({
                        className: 'custom-gis-marker',
                        html: '<div class="w-7 h-7 rounded-full bg-rose-600 border-2 border-white shadow-md flex items-center justify-center text-white text-xs font-bold">📍</div>',
                        iconSize: [28, 28],
                        iconAnchor: [14, 28]
                    });

                    const marker = L.marker([item.latitude, item.longitude], { icon: customPin }).addTo(mapInstance);
                    marker.bindPopup(
                        '<div class="p-2 text-xs font-sans">' +
                        '<strong class="text-slate-900 block">' + (item.judul || 'Hambatan') + '</strong>' +
                        '<span class="text-rose-600 font-bold text-[10px] block mt-0.5">Skor Prioritas: ' + (item.skor_prioritas || 0) + '</span>' +
                        '</div>'
                    );
                }
            });
        }
    });

    function mapRecenter() {
        if (mapInstance) {
            mapInstance.flyTo([-6.3850, 106.8300], 13);
        }
    }
</script>
@endpush