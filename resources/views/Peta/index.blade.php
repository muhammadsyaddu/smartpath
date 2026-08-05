@extends('layouts.app')

@section('title', 'Peta Aksesibilitas Infrastruktur Disabilitas - SmartPath')

@push('styles')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>
    #map {
        height: calc(100vh - 65px);
        width: 100%;
        z-index: 1;
    }
    .custom-marker {
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: white;
        font-weight: bold;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        border: 2px solid white;
    }
    .marker-high { background-color: #ef4444; }
    .marker-medium { background-color: #f59e0b; }
    .marker-low { background-color: #10b981; }
</style>
@endpush

@section('content')
<div class="flex flex-col h-screen overflow-hidden bg-slate-100 dark:bg-slate-900">
    
    <!-- TOP BAR NAVIGATION (Persis Gambar Wireframe) -->
    <header className="h-16 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 px-4 flex items-center justify-between z-20 shadow-sm">
        <div class="flex items-center space-x-3">
            <button id="toggleSidebar" class="p-2 rounded-lg text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800 lg:hidden">
                <i class="fas fa-bars text-lg"></i>
            </button>
            <a href="{{ route('beranda') }}" class="flex items-center space-x-2">
                <div class="w-8 h-8 rounded-lg bg-emerald-600 flex items-center justify-center text-white font-bold">
                    <i class="fas fa-cog animate-spin-slow"></i>
                </div>
                <span class="font-bold text-lg text-slate-900 dark:text-white">SmartPath</span>
            </a>
        </div>

        <!-- Center Counter Stats -->
        <div class="hidden md:flex items-center space-x-6 text-sm font-semibold text-slate-700 dark:text-slate-300">
            <div class="flex items-center space-x-2">
                <span class="w-3 h-3 rounded-full bg-red-500"></span>
                <span>Prioritas Tinggi: <strong id="topHighCount" class="text-slate-900 dark:text-white">12</strong></span>
            </div>
            <div class="flex items-center space-x-2">
                <span class="w-3 h-3 rounded-lg border border-slate-400 bg-slate-100 dark:bg-slate-800"></span>
                <span>Total: <strong id="topTotalCount" class="text-slate-900 dark:text-white">155</strong></span>
            </div>
        </div>

        <!-- Right Buttons -->
        <div class="flex items-center space-x-3">
            <a href="{{ route('laporan.create') }}" class="px-3.5 py-1.5 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-sm font-semibold rounded-lg hover:bg-slate-50 transition flex items-center space-x-1.5">
                <i class="fas fa-plus text-xs"></i>
                <span>+ Lapor</span>
            </a>
            <button id="btnExport" class="px-3.5 py-1.5 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-slate-800 dark:text-slate-200 text-sm font-semibold rounded-lg hover:bg-slate-50 transition flex items-center space-x-1.5">
                <i class="fas fa-download text-xs"></i>
                <span>Ekspor</span>
            </button>
        </div>
    </header>

    <!-- MAIN GIS BODY -->
    <div class="flex flex-1 relative overflow-hidden">
        
        <!-- LEFT SIDEBAR: FILTER PETA (Persis Gambar Wireframe) -->
        <aside id="sidebarFilter" class="w-80 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 p-5 overflow-y-auto z-20 flex-shrink-0 transition-all duration-300">
            <div class="flex items-center justify-between mb-4 pb-2 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-filter text-emerald-600"></i>
                    <h2 class="font-extrabold text-base text-slate-900 dark:text-white">Filter Peta</h2>
                </div>
            </div>
            <p class="text-xs text-slate-500 dark:text-slate-400 mb-5">Sesuai tampilan data pada peta</p>

            <!-- SECTION 1: STATUS LAPORAN -->
            <div class="mb-6">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-3">
                    STATUS LAPORAN
                </label>
                <div class="space-y-2.5">
                    @php
                        $statuses = [
                            ['key' => 'menunggu_verifikasi', 'label' => 'Menunggu Verifikasi', 'count' => 34, 'checked' => true],
                            ['key' => 'diverifikasi', 'label' => 'Diverifikasi', 'count' => 55, 'checked' => true],
                            ['key' => 'dalam_perbaikan', 'label' => 'Dalam Perbaikan', 'count' => 42, 'checked' => true],
                            ['key' => 'selesai', 'label' => 'Selesai', 'count' => 25, 'checked' => true],
                        ];
                    @endphp
                    @foreach($statuses as $st)
                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center space-x-2.5 cursor-pointer">
                            <input type="checkbox" name="status[]" value="{{ $st['key'] }}" class="filter-status rounded text-emerald-600 focus:ring-emerald-500 w-4 h-4 border-slate-300" {{ $st['checked'] ? 'checked' : '' }}>
                            <span class="text-slate-700 dark:text-slate-300 font-medium">{{ $st['label'] }}</span>
                        </label>
                        <span class="text-xs font-bold px-2 py-0.5 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 rounded-md border border-slate-200 dark:border-slate-700">
                            {{ $st['count'] }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- SECTION 2: KATEGORI HAMBATAN -->
            <div class="mb-6 pt-4 border-t border-slate-100 dark:border-slate-800">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-3">
                    KATEGORI HAMBATAN
                </label>
                <div class="space-y-2.5">
                    @php
                        $categories = ['Trotoar', 'Ramp', 'Lift', 'Toilet', 'Parkir', 'Guiding Block', 'Halte'];
                    @endphp
                    @foreach($categories as $cat)
                    <label class="flex items-center space-x-2.5 cursor-pointer text-sm">
                        <input type="checkbox" name="kategori[]" value="{{ strtolower($cat) }}" class="filter-kategori rounded text-emerald-600 focus:ring-emerald-500 w-4 h-4 border-slate-300" checked>
                        <span class="text-slate-700 dark:text-slate-300 font-medium">{{ $cat }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- SECTION 3: FASILITAS PUBLIK TOGGLE -->
            <div class="mb-6 pt-4 border-t border-slate-100 dark:border-slate-800">
                <label class="flex items-center space-x-2.5 cursor-pointer text-sm font-semibold text-slate-800 dark:text-slate-200">
                    <input type="checkbox" id="toggleFasilitas" class="rounded text-emerald-600 focus:ring-emerald-500 w-4 h-4 border-slate-300">
                    <span>Tampilkan Fasilitas Publik</span>
                </label>
            </div>

            <!-- SECTION 4: PRIORITAS -->
            <div class="mb-6 pt-4 border-t border-slate-100 dark:border-slate-800">
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-3">
                    PRIORITAS
                </label>
                <div class="space-y-2">
                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <span class="w-3 h-3 rounded-full bg-red-500"></span>
                            <span class="text-slate-700 dark:text-slate-300 font-medium">Tinggi</span>
                        </label>
                        <span class="text-xs font-mono text-slate-500">Skor 7-10</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                            <span class="text-slate-700 dark:text-slate-300 font-medium">Sedang</span>
                        </label>
                        <span class="text-xs font-mono text-slate-500">Skor 4-6.9</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                            <span class="text-slate-700 dark:text-slate-300 font-medium">Rendah</span>
                        </label>
                        <span class="text-xs font-mono text-slate-500">Skor 0-3.9</span>
                    </div>
                </div>
            </div>

            <!-- INFO BOX -->
            <div class="p-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg flex items-start space-x-2 text-xs text-slate-600 dark:text-slate-400">
                <i class="fas fa-info-circle text-emerald-600 mt-0.5"></i>
                <span>Klik marker untuk melihat detail laporan hambatan.</span>
            </div>
        </aside>

        <!-- MAP CANVAS -->
        <main class="flex-1 relative">
            <div id="map"></div>

            <!-- FLOATING RINGKASAN CARD (Bottom Right, Persis Gambar Wireframe) -->
            <div class="absolute bottom-6 right-6 z-10 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border border-slate-300 dark:border-slate-700 rounded-xl p-4 shadow-lg w-52">
                <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 dark:text-slate-200 mb-2 border-b border-slate-200 dark:border-slate-800 pb-1">
                    RINGKASAN
                </h4>
                <div class="space-y-1.5 text-xs text-slate-700 dark:text-slate-300">
                    <div class="flex justify-between">
                        <span>Total Marker</span>
                        <strong id="ringkasanTotal">12</strong>
                    </div>
                    <div class="flex justify-between">
                        <span>Prioritas Tinggi</span>
                        <strong id="ringkasanTinggi" class="text-red-600 dark:text-red-400">12</strong>
                    </div>
                    <div class="flex justify-between">
                        <span>Dalam Area</span>
                        <strong id="ringkasanDalamArea">11</strong>
                    </div>
                </div>
            </div>
        </main>

    </div>
</div>
@endsection

@push('scripts')
<!-- Leaflet JS CDN -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Init Leaflet Map centered at Depok City (Pancoran Mas / Margonda)
        const map = L.map('map').setView([-6.4025, 106.7942], 13);

        // OpenStreetMap Tile Layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors | SmartPath Kota Depok'
        }).addTo(map);

        // Sample Markers matching wireframe coordinates in Depok (Beji, Margonda, Pancoran Mas, Kukusan)
        const reports = [
            { id: 'SP-001', title: 'Guiding Block Rusak', lat: -6.3731, lng: 106.8315, priority: 'high', category: 'trotoar', location: 'Jl. Margonda Raya' },
            { id: 'SP-002', title: 'Trotoar Terhalang Parkir', lat: -6.3901, lng: 106.8302, priority: 'medium', category: 'trotoar', location: 'Jl. Juanda' },
            { id: 'SP-003', title: 'Ramp Tidak Layak', lat: -6.3980, lng: 106.8250, priority: 'medium', category: 'ramp', location: 'Jl. Sawangan' },
            { id: 'SP-004', title: 'Lift Penyeberangan Mati', lat: -6.3680, lng: 106.8330, priority: 'high', category: 'lift', location: 'Stasiun UI' },
            { id: 'SP-005', title: 'Toilet Disabilitas Terkunci', lat: -6.3850, lng: 106.8210, priority: 'low', category: 'toilet', location: 'Taman Depok' },
            { id: 'SP-006', title: 'Parkir Khusus Diokupasi', lat: -6.4010, lng: 106.8190, priority: 'high', category: 'parkir', location: 'Balaikota Depok' }
        ];

        let activeMarkers = [];

        function renderMarkers() {
            // Clear existing
            activeMarkers.forEach(m => map.removeLayer(m));
            activeMarkers = [];

            let total = 0;
            let high = 0;

            reports.forEach(item => {
                let colorClass = item.priority === 'high' ? 'marker-high' : (item.priority === 'medium' ? 'marker-medium' : 'marker-low');
                
                let customIcon = L.divIcon({
                    className: 'custom-pin',
                    html: `<div class="custom-marker ${colorClass} w-7 h-7 text-xs"><i class="fas fa-exclamation"></i></div>`,
                    iconSize: [28, 28],
                    iconAnchor: [14, 14]
                });

                let marker = L.marker([item.lat, item.lng], { icon: customIcon }).addTo(map);
                
                marker.bindPopup(`
                    <div class="p-2 font-sans">
                        <span class="text-[10px] font-mono font-bold text-slate-400">${item.id}</span>
                        <h4 class="font-bold text-sm text-slate-900">${item.title}</h4>
                        <p class="text-xs text-slate-600 mt-1">${item.location}</p>
                    </div>
                `);

                activeMarkers.push(marker);
                total++;
                if (item.priority === 'high') high++;
            });

            // Update stats
            document.getElementById('ringkasanTotal').innerText = total;
            document.getElementById('ringkasanTinggi').innerText = high;
            document.getElementById('ringkasanDalamArea').innerText = total - 1;
        }

        renderMarkers();

        // Toggle Sidebar Mobile
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            document.getElementById('sidebarFilter').classList.toggle('-translate-x-full');
        });
    });
</script>
@endpush