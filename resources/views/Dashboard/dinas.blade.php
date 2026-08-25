    @extends('layouts.admin')

    @section('title', 'Dashboard Dinas PUPR')
    @section('page_title', 'Monitoring Infrastruktur Dinas PUPR')

    @section('content')
    <div class="space-y-6">
        

        {{-- ==========================================================
        KARTU STATISTIK PENANGANAN
    ========================================================== --}}
    <div
        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4"
        role="region"
        aria-label="Statistik Penanganan PUPR"
    >

        {{-- 1. TOTAL MASUK --}}
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3">

                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    {{-- Icon bendera --}}
                    <svg
                        class="w-5 h-5 text-blue-600"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path d="M5 3a1 1 0 011-1h1v1h9.5l1.8 4-1.8 4H7v10H5V3z"/>
                    </svg>
                </div>

                <span class="text-xs font-semibold text-slate-400">
                    Total
                </span>

            </div>

            <p class="text-2xl font-bold text-slate-900">
                {{ $statistik['total'] ?? 0 }}
            </p>

            <p class="text-xs text-slate-500 mt-1">
                Laporan masuk
            </p>
        </div>


        {{-- 2. MENUNGGU VERIFIKASI --}}
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3">

                <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                    {{-- Icon jam pasir --}}
                    <svg
                        class="w-5 h-5 text-amber-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 4h12M6 20h12M8 4c0 4 2 5 4 6-2 1-4 2-4 6m8-12c0 4-2 5-4 6 2 1 4 2 4 6"
                        />
                    </svg>
                </div>

                <span class="text-xs font-semibold text-amber-600">
                    Menunggu
                </span>

            </div>

            <p class="text-2xl font-bold text-slate-900">
                {{ $statistik['menunggu'] ?? 0 }}
            </p>

            <p class="text-xs text-slate-500 mt-1">
                Perlu verifikasi
            </p>
        </div>


        {{-- 3. DALAM PERBAIKAN --}}
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3">

                <div class="w-10 h-10 bg-cyan-100 rounded-lg flex items-center justify-center">
                    {{-- Icon alat / perbaikan --}}
                    <svg
                        class="w-5 h-5 text-cyan-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M14.7 6.3a4 4 0 01-5.4 5.4L4 17l3 3 5.3-5.3a4 4 0 005.4-5.4l-2.2 2.2-2.1-.5-.5-2.1 2.2-2.2z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M13 13l6 6M19 13l-6 6"
                        />
                    </svg>
                </div>

                <span class="text-xs font-semibold text-cyan-600">
                    Proses
                </span>

            </div>

            <p class="text-2xl font-bold text-slate-900">
                {{ $statistik['dalam_perbaikan'] ?? 0 }}
            </p>

            <p class="text-xs text-slate-500 mt-1">
                Dalam perbaikan
            </p>
        </div>


        {{-- 4. SELESAI --}}
        <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-3">

                <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                    {{-- Icon centang --}}
                    <svg
                        class="w-5 h-5 text-emerald-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 12l2 2 4-4"
                        />
                        <circle
                            cx="12"
                            cy="12"
                            r="9"
                            stroke-width="2"
                        />
                    </svg>
                </div>

                <span class="text-xs font-semibold text-emerald-600">
                    Selesai
                </span>

            </div>

            <p class="text-2xl font-bold text-slate-900">
                {{ $statistik['selesai'] ?? 0 }}
            </p>

            <p class="text-xs text-slate-500 mt-1">
                Terkonfirmasi
            </p>
        </div>


        {{-- 5. KRITIS --}}
        <div class="bg-white rounded-xl border border-red-200 p-5 shadow-sm">

            <div class="flex items-center justify-between mb-3">

                <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                    {{-- Icon peringatan --}}
                    <svg
                        class="w-5 h-5 text-red-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 9v4m0 4h.01M10.3 3.8L2.7 17a2 2 0 001.7 3h15.2a2 2 0 001.7-3L13.7 3.8a2 2 0 00-3.4 0z"
                        />
                    </svg>
                </div>

                <span class="text-xs font-semibold text-red-600">
                    Kritis
                </span>

            </div>

            <p class="text-2xl font-bold text-slate-900">
                {{ $statistik['kritis'] ?? 0 }}
            </p>

            <p class="text-xs text-slate-500 mt-1">
                Prioritas tinggi
            </p>

        </div>

    </div>

        {{-- 2. PETA SEBARAN LOKASI & WIDGET PENANGANAN PRIORITAS --}}
       {{-- WIDGET REALISASI ANGGARAN --}}
<div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm flex flex-col justify-between">
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-semibold text-slate-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Realisasi Anggaran {{ date('Y') }}
            </h2>
        </div>

        <div class="space-y-4">
            @if(isset($dataAnggaran) && count($dataAnggaran) > 0)
                @foreach($dataAnggaran as $item)
                    @php
                        $persen = $item->pagu > 0 ? min(100, round(($item->realisasi / $item->pagu) * 100)) : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between items-center text-xs mb-1">
                            <span class="font-semibold text-slate-700">{{ $item->nama_kategori }}</span>
                            <span class="font-bold text-slate-900">{{ $persen }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden mb-1">
                            <div class="bg-slate-700 h-2 rounded-full transition-all duration-300" style="width: {{ $persen }}%"></div>
                        </div>
                        <div class="flex justify-between text-[11px] text-slate-400">
                            <span>Rp {{ number_format($item->realisasi, 0, ',', '.') }}</span>
                            <span>Rp {{ number_format($item->pagu, 0, ',', '.') }}</span>
                        </div>
                    </div>
                @endforeach
            @else
                {{-- Fallback Statis Sesuai Mockup --}}
                <div>
                    <div class="flex justify-between items-center text-xs mb-1">
                        <span class="font-semibold text-slate-700">Trotoar & Pedestrian</span>
                        <span class="font-bold text-slate-900">78%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden mb-1">
                        <div class="bg-slate-700 h-2 rounded-full" style="width: 78%"></div>
                    </div>
                    <div class="flex justify-between text-[11px] text-slate-400">
                        <span>Rp 2.3M</span>
                        <span>Rp 3M</span>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center text-xs mb-1">
                        <span class="font-semibold text-slate-700">Ramp & Aksesibilitas</span>
                        <span class="font-bold text-slate-900">45%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden mb-1">
                        <div class="bg-slate-700 h-2 rounded-full" style="width: 45%"></div>
                    </div>
                    <div class="flex justify-between text-[11px] text-slate-400">
                        <span>Rp 900JT</span>
                        <span>Rp 2M</span>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center text-xs mb-1">
                        <span class="font-semibold text-slate-700">Fasilitas Publik</span>
                        <span class="font-bold text-slate-900">62%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden mb-1">
                        <div class="bg-slate-700 h-2 rounded-full" style="width: 62%"></div>
                    </div>
                    <div class="flex justify-between text-[11px] text-slate-400">
                        <span>Rp 3.1M</span>
                        <span>Rp 5M</span>
                    </div>
                </div>

                <div>
                    <div class="flex justify-between items-center text-xs mb-1">
                        <span class="font-semibold text-slate-700">Penerangan & Marka</span>
                        <span class="font-bold text-slate-900">90%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden mb-1">
                        <div class="bg-slate-700 h-2 rounded-full" style="width: 90%"></div>
                    </div>
                    <div class="flex justify-between text-[11px] text-slate-400">
                        <span>Rp 1.8M</span>
                        <span>Rp 2M</span>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Total Ringkasan Anggaran --}}
    <div class="mt-4 pt-3 border-t border-slate-100 text-xs bg-slate-50 p-2.5 rounded-lg border border-slate-200">
        <div class="flex justify-between font-semibold text-slate-700">
            <span>Total Anggaran:</span>
            <span>Rp 12M</span>
        </div>
        <div class="flex justify-between font-bold text-slate-900 mt-0.5">
            <span>Realisasi:</span>
            <span>Rp 8.1M (67.5%)</span>
        </div>
    </div>
</div>
            
            {{-- Interactive Map --}}
            <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm lg:col-span-2 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="font-semibold text-slate-900 flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Peta Sebaran Infrastruktur
                        </h2>
                        <span class="text-xs text-slate-400">Peta Real-time</span>
                    </div>
                    
                    {{-- Container Leaflet Map --}}
                    <div id="map-pemerintah" class="h-80 w-full rounded-lg border border-slate-200 bg-slate-50 z-0"></div>
                </div>

                {{-- Legend Peta --}}
                <div class="mt-4 pt-3 border-t border-slate-100 flex flex-wrap items-center gap-4 text-xs text-slate-600">
                    <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-red-500"></span> Prioritas Tinggi</span>
                    <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-amber-500"></span> Prioritas Sedang</span>
                    <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-blue-500"></span> Prioritas Rendah</span>
                </div>
            </div>

            {{-- Prioritas Perbaikan Cepat --}}
            <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm flex flex-col justify-between">
                <div>
                    <h2 class="font-semibold text-slate-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Realisasi Anggaran
                    </h2>

                    <div class="space-y-3">
                        @if(isset($laporanPrioritasTinggi) && $laporanPrioritasTinggi->count() > 0)
                            @foreach($laporanPrioritasTinggi->take(4) as $laporan)
                                <div class="p-3 rounded-lg border border-red-100 bg-red-50/50 flex items-start justify-between gap-3">
                                    <div class="min-w-0 flex-1">
                                        <p class="text-xs font-bold text-slate-800 truncate">{{ $laporan->judul }}</p>
                                        <p class="text-[11px] text-slate-500 mt-0.5">{{ $laporan->kode_laporan }} • {{ Str::limit($laporan->fasilitasTerdekat->nama ?? 'Lokasi Umum', 20) }}</p>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <span class="inline-block text-xs font-black text-red-600 bg-white px-2 py-0.5 rounded border border-red-200">
                                            Skor {{ number_format($laporan->skor_prioritas ?? 0, 1) }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-xs text-slate-400 text-center py-6">Tidak ada laporan kritis saat ini.</p>
                        @endif
                    </div>
                </div>

            @if(auth()->user()->isAdmin())
        <a href="{{ route('admin.verifikasi.index') }}" 
        class="mt-4 block text-center w-full py-2 bg-slate-900 text-white text-xs font-semibold rounded-lg hover:bg-slate-800 transition-colors">
            Kelola Semua Perbaikan →
        </a>
    @endif
            </div>
        </div>

        {{-- 3. TABEL DAFTAR LAPORAN MASUK UNTUK VERIFIKASI --}}
        <div class="bg-white rounded-xl border border-slate-200 overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <h2 class="font-semibold text-slate-900">Antrian Laporan Terbaru Dinas PUPR</h2>
                <a href="{{ route('admin.verifikasi.index') }}" class="text-xs font-semibold text-emerald-700 hover:text-emerald-800 transition-colors">Lihat Semua Antrian →</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left text-slate-600">
                    <thead class="border-b border-slate-100 bg-slate-50 text-slate-400 uppercase tracking-wider text-[11px]">
                        <tr>
                            <th class="px-6 py-3 font-semibold">Kode</th>
                            <th class="px-6 py-3 font-semibold">Judul Laporan</th>
                            <th class="px-6 py-3 font-semibold">Kategori Hambatan</th>
                            <th class="px-6 py-3 font-semibold">Status</th>
                            <th class="px-6 py-3 font-semibold text-center">Skor Prioritas</th>
                            <th class="px-6 py-3 font-semibold text-right">Tanggal Masuk</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @if(isset($laporanTerbaru) && count($laporanTerbaru) > 0)
                            @foreach($laporanTerbaru as $item)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-3 font-mono font-bold text-slate-700">{{ $item->kode_laporan }}</td>
                                    <td class="px-6 py-3 font-semibold text-slate-800">
                                        <a href="{{ route('admin.verifikasi.show', $item) }}" class="hover:text-emerald-700">
                                            {{ Str::limit($item->judul, 45) }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-3">
                                        <span class="inline-flex items-center gap-1.5">
                                            <span class="w-2 h-2 rounded-full" style="background-color: {{ $item->kategoriHambatan->warna_penanda ?? '#64748b' }}"></span>
                                            {{ $item->kategoriHambatan->nama ?? 'Umum' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold {{ $item->warna }}">
                                            {{ $item->status_label }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-3 text-center font-bold text-red-600">
                                        {{ number_format($item->skor_prioritas ?? 0, 1) }}
                                    </td>
                                    <td class="px-6 py-3 text-right text-slate-400">
                                        {{ $item->created_at->format('d M Y H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-slate-400">Belum ada data laporan masuk.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    @endsection

    @push('scripts')
    {{-- Leaflet JS & CSS untuk Peta --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi Peta
        var map = L.map('map-pemerintah').setView([-6.4025, 106.7942], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Render Data Marker Peta dari Backend Controller
        var petaData = @json($petaLaporan ?? []);

        if (Array.isArray(petaData) && petaData.length > 0) {
            var bounds = [];

            petaData.forEach(function(laporan) {
                if (laporan.latitude && laporan.longitude) {
                    var lat = parseFloat(laporan.latitude);
                    var lng = parseFloat(laporan.longitude);

                    var marker = L.marker([lat, lng]).addTo(map);
                    
                    var popupHtml = `
                        <div style="font-size:12px; min-width:140px;">
                            <strong style="color:#0f172a;">${laporan.kode_laporan}</strong><br>
                            <span style="color:#64748b;">${laporan.judul ?? ''}</span><br>
                            <div style="margin-top:4px;">Skor: <b style="color:#dc2626;">${laporan.skor_prioritas ?? '-'}</b></div>
                        </div>
                    `;
                    marker.bindPopup(popupHtml);
                    bounds.push([lat, lng]);
                }
            });

            if (bounds.length > 0) {
                map.fitBounds(bounds, { padding: [30, 30] });
            }
        }
    });
    </script>
    @endpush