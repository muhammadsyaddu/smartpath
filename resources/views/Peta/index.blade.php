@extends('layouts.app')

@section('title', 'Peta Interaktif')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map-container { height: calc(100vh - 64px - 80px); min-height: 500px; width: 100%; }
    @media (max-width: 768px) { #map-container { height: calc(100vh - 64px - 60px); min-height: 400px; } }
    
    .leaflet-popup-content-wrapper { border-radius: 0.75rem; font-family: 'Inter', sans-serif; }
    .leaflet-popup-content { margin: 12px 16px; }
    
    /* Custom marker dengan pulse untuk prioritas tinggi */
    .marker-pulse {
        animation: pulse-marker 2s infinite;
    }
    @keyframes pulse-marker {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.2); opacity: 0.6; }
        100% { transform: scale(1); opacity: 1; }
    }
    
    /* Sidebar transisi */
    .map-sidebar {
        transition: transform 0.3s ease-in-out;
    }
    .map-sidebar.closed {
        transform: translateX(-100%);
    }
    @media (min-width: 1024px) {
        .map-sidebar.closed {
            transform: translateX(0);
        }
        .map-sidebar {
            transform: translateX(0);
        }
        .map-sidebar.hidden {
            display: block !important;
        }
    }
    
    .facility-marker-icon div {
        background: #0d9488;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        border: 3px solid #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .facility-marker-icon svg {
        width: 12px;
        height: 12px;
        fill: white;
    }

    /* User location marker */
    .user-location-marker {
        background: #059669;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        border: 3px solid #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
    }
</style>
@endpush

@section('content')
<div class="relative" role="region" aria-label="Peta interaktif hambatan aksesibilitas">
    
    {{-- Sidebar filter --}}
    <div id="map-sidebar" class="map-sidebar fixed lg:absolute top-0 left-0 z-[1000] w-72 h-full bg-white shadow-lg border-r border-slate-200 overflow-y-auto transform -translate-x-full lg:translate-x-0 transition-transform duration-300" role="complementary" aria-label="Filter peta">
        <div class="p-4 border-b border-slate-200 flex justify-between items-center">
            <h2 class="font-semibold text-slate-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                Filter Peta
            </h2>
            <button id="close-sidebar" class="lg:hidden p-1 text-slate-500 hover:text-slate-700" aria-label="Tutup filter">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        

        {{-- Status filter --}}
        <div class="p-4 border-b border-slate-200">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Status Laporan</p>
            <div class="space-y-2">
                <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                    <input type="checkbox" class="filter-status rounded border-slate-300 text-emerald-600 focus:ring-emerald-500" value="menunggu_verifikasi" checked aria-label="Tampilkan menunggu verifikasi">
                    <span class="w-2 h-2 rounded-full bg-amber-400" aria-hidden="true"></span>
                    Menunggu Verifikasi
                </label>
                <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                    <input type="checkbox" class="filter-status rounded border-slate-300 text-emerald-600 focus:ring-emerald-500" value="diverifikasi" checked aria-label="Tampilkan diverifikasi">
                    <span class="w-2 h-2 rounded-full bg-emerald-500" aria-hidden="true"></span>
                    Diverifikasi
                </label>
                <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                    <input type="checkbox" class="filter-status rounded border-slate-300 text-emerald-600 focus:ring-emerald-500" value="dalam_perbaikan" checked aria-label="Tampilkan dalam perbaikan">
                    <span class="w-2 h-2 rounded-full bg-teal-500" aria-hidden="true"></span>
                    Dalam Perbaikan
                </label>
                <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                    <input type="checkbox" class="filter-status rounded border-slate-300 text-emerald-600 focus:ring-emerald-500" value="selesai" checked aria-label="Tampilkan selesai">
                    <span class="w-2 h-2 rounded-full bg-green-600" aria-hidden="true"></span>
                    Selesai
                </label>
            </div>
        </div>

        {{-- Kategori filter --}}
        <div class="p-4 border-b border-slate-200">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Kategori Hambatan</p>
            <div class="space-y-2" id="kategori-filters">
                {{-- Populated by JS --}}
            </div>
        </div>

        {{-- Fasilitas toggle --}}
        <div class="p-4 border-b border-slate-200">
            <label class="flex items-center gap-2 text-sm text-slate-700 cursor-pointer">
                <input type="checkbox" id="toggle-fasilitas" class="rounded border-slate-300 text-teal-600 focus:ring-teal-500" aria-label="Tampilkan fasilitas publik">
                <span class="w-2 h-2 rounded-full bg-teal-500" aria-hidden="true"></span>
                Tampilkan Fasilitas Publik
            </label>
        </div>

        {{-- Legend --}}
        <div class="p-4">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Prioritas</p>
            <div class="space-y-1.5">
                <div class="flex items-center gap-2 text-xs text-slate-600"><span class="w-3 h-3 rounded-full bg-red-500" aria-hidden="true"></span> Tinggi</div>
                <div class="flex items-center gap-2 text-xs text-slate-600"><span class="w-3 h-3 rounded-full bg-amber-500" aria-hidden="true"></span> Sedang</div>
                <div class="flex items-center gap-2 text-xs text-slate-600"><span class="w-3 h-3 rounded-full bg-blue-500" aria-hidden="true"></span> Rendah</div>
            </div>
        </div>
    </div>

    {{-- Mobile toggle button --}}
    <button id="toggle-sidebar" class="lg:hidden absolute top-3 left-3 z-[1001] bg-white shadow-md rounded-xl p-2.5 text-slate-600 hover:text-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500" aria-label="Toggle filter sidebar">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
    </button>

    {{-- Map container --}}
    <div id="map-container" class="w-full" role="application" aria-label="Peta Leaflet"></div>

    {{-- Overlay untuk mobile saat sidebar terbuka --}}
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/30 z-[999] hidden lg:hidden" aria-hidden="true"></div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    // ---- ELEMENTS ----
    const sidebar = document.getElementById('map-sidebar');
    const toggleBtn = document.getElementById('toggle-sidebar');
    const closeBtn = document.getElementById('close-sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    const mapContainer = document.getElementById('map-container');

    // ---- SIDEBAR TOGGLE (Mobile) ----
    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        // Trigger map resize after transition
        setTimeout(() => map.invalidateSize(), 350);
    }

    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
        document.body.style.overflow = '';
        setTimeout(() => map.invalidateSize(), 350);
    }

    // Toggle sidebar on mobile
    toggleBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        if (sidebar.classList.contains('-translate-x-full')) {
            openSidebar();
        } else {
            closeSidebar();
        }
    });

    closeBtn.addEventListener('click', closeSidebar);
    overlay.addEventListener('click', closeSidebar);

    // Close sidebar on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !sidebar.classList.contains('-translate-x-full') && window.innerWidth < 1024) {
            closeSidebar();
        }
    });

    // ---- MAP INIT ----
    const map = L.map('map-container', {
        center: [-6.4025, 106.8197],
        zoom: 13,
        zoomControl: true
    });

    // Tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    }).addTo(map);

    // Handle resize when sidebar toggles
    function handleMapResize() {
        setTimeout(() => map.invalidateSize(), 100);
    }

    // Listen to window resize to adjust map
    window.addEventListener('resize', handleMapResize);

    // ---- MARKER ICONS ----
    function getMarkerIcon(priority, status) {
        const colors = {
            tinggi: '#ef4444',
            sedang: '#f59e0b',
            rendah: '#3b82f6',
            default: '#6b7280'
        };
        const color = colors[priority] || colors.default;
        const size = priority === 'tinggi' ? 14 : priority === 'sedang' ? 11 : 9;
        const isHigh = priority === 'tinggi';

        return L.divIcon({
            className: 'custom-marker',
            html: `<div style="background:${color};width:${size*2}px;height:${size*2}px;border-radius:50%;border:3px solid #fff;box-shadow:0 2px 8px rgba(0,0,0,0.3);${isHigh ? 'animation:pulse-marker 2s infinite;' : ''}"></div>`,
            iconSize: [size*2, size*2],
            iconAnchor: [size, size],
            popupAnchor: [0, -size]
        });
    }

    function getFacilityIcon() {
        return L.divIcon({
            className: 'facility-marker-icon',
            html: `<div><svg viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg></div>`,
            iconSize: [22, 22],
            iconAnchor: [11, 11],
            popupAnchor: [0, -11]
        });
    }

    // ---- LAYER GROUPS ----
    const laporanLayer = L.layerGroup().addTo(map);
    const fasilitasLayer = L.layerGroup();

    // ---- STORE DATA FOR REUSE ----
    let cachedLaporanData = [];

    // ---- LOAD LAPORAN ----
    function loadLaporan() {
        const statuses = Array.from(document.querySelectorAll('.filter-status:checked')).map(cb => cb.value);
        const kategoris = Array.from(document.querySelectorAll('.filter-kategori:checked')).map(cb => cb.value);

        const params = new URLSearchParams();
        if (statuses.length) params.append('status', statuses.join(','));
        if (kategoris.length) params.append('kategori', kategoris.join(','));

        fetch('{{ route("peta.data") }}?' + params.toString())
            .then(res => {
                if (!res.ok) throw new Error('Gagal memuat data laporan');
                return res.json();
            })
            .then(data => {
                cachedLaporanData = data;
                renderLaporan(data);
                populateKategoriFilters(data);
            })
            .catch(err => {
                console.error('Error loading laporan:', err);
                // Tampilkan pesan error di map?
            });
    }

    function renderLaporan(data) {
        laporanLayer.clearLayers();
        data.forEach(item => {
            const marker = L.marker([item.latitude, item.longitude], {
                icon: getMarkerIcon(item.tingkat_prioritas, item.status)
            });
            const popupContent = `
                <div style="min-width:200px;max-width:280px;">
                    ${item.foto ? `<img src="${item.foto}" alt="Foto laporan" style="width:100%;height:120px;object-fit:cover;border-radius:8px;margin-bottom:8px;">` : ''}
                    <h3 style="font-weight:600;font-size:14px;margin-bottom:4px;color:#0f172a;">${item.judul}</h3>
                    <p style="font-size:12px;color:#64748b;margin-bottom:6px;">${item.kategori_nama || 'Tanpa kategori'}</p>
                    <div style="display:flex;align-items:center;gap:6px;margin-bottom:8px;flex-wrap:wrap;">
                        <span style="display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:6px;font-size:11px;font-weight:600;${item.status_warna || 'background:#e2e8f0;color:#475569;'}">${item.status_label || item.status}</span>
                        ${item.skor_prioritas ? `<span style="font-size:11px;color:#94a3b8;">Skor: ${item.skor_prioritas}</span>` : ''}
                    </div>
                    <a href="/laporan/${item.id}" style="display:inline-flex;align-items:center;gap:4px;font-size:13px;font-weight:500;color:#059669;text-decoration:none;">Lihat Detail →</a>
                </div>
            `;
            marker.bindPopup(popupContent, { maxWidth: 300 });
            laporanLayer.addLayer(marker);
        });
    }

    // ---- LOAD FASILITAS ----
    function loadFasilitas() {
        fetch('{{ route("peta.fasilitas") }}')
            .then(res => {
                if (!res.ok) throw new Error('Gagal memuat data fasilitas');
                return res.json();
            })
            .then(data => {
                fasilitasLayer.clearLayers();
                data.forEach(item => {
                    const marker = L.marker([item.latitude, item.longitude], { icon: getFacilityIcon() });
                    const popupContent = `
                        <div style="min-width:180px;">
                            <h3 style="font-weight:600;font-size:14px;margin-bottom:4px;color:#0f172a;">${item.nama}</h3>
                            <p style="font-size:12px;color:#64748b;">${item.jenis_label || 'Fasilitas'} • ${item.alamat || ''}</p>
                        </div>
                    `;
                    marker.bindPopup(popupContent);
                    fasilitasLayer.addLayer(marker);
                });
            })
            .catch(err => console.error('Error loading fasilitas:', err));
    }

    // ---- POPULATE KATEGORI FILTERS ----
    function populateKategoriFilters(data) {
        const container = document.getElementById('kategori-filters');
        // Use a Map to deduplicate
        const kategoriMap = new Map();
        data.forEach(item => {
            if (item.kategori_id && !kategoriMap.has(item.kategori_id)) {
                kategoriMap.set(item.kategori_id, {
                    id: item.kategori_id,
                    nama: item.kategori_nama || 'Tanpa Kategori',
                    warna: item.kategori_warna || '#6b7280'
                });
            }
        });

        // Only rebuild if empty or forced
        if (container.children.length === 0 && kategoriMap.size > 0) {
            kategoriMap.forEach(k => {
                const label = document.createElement('label');
                label.className = 'flex items-center gap-2 text-sm text-slate-700 cursor-pointer';
                label.innerHTML = `
                    <input type="checkbox" class="filter-kategori rounded border-slate-300 text-emerald-600 focus:ring-emerald-500" value="${k.id}" checked aria-label="Filter ${k.nama}">
                    <span class="w-2 h-2 rounded-full" style="background:${k.warna}" aria-hidden="true"></span>
                    ${k.nama}
                `;
                container.appendChild(label);
                label.querySelector('input').addEventListener('change', loadLaporan);
            });
        }
    }

    // ---- EVENT LISTENERS ----
    document.querySelectorAll('.filter-status').forEach(cb => {
        cb.addEventListener('change', loadLaporan);
    });

    document.getElementById('toggle-fasilitas').addEventListener('change', function() {
        if (this.checked) {
            fasilitasLayer.addTo(map);
        } else {
            map.removeLayer(fasilitasLayer);
        }
    });

    // ---- LOCATE USER ----
    const locateBtn = L.control({ position: 'topright' });
    locateBtn.onAdd = function() {
        const div = L.DomUtil.create('div', 'leaflet-bar leaflet-control');
        div.innerHTML = `<button aria-label="Lokasi saya" style="background:#fff;border:2px solid rgba(0,0,0,0.2);border-radius:4px;padding:8px 10px;cursor:pointer;font-size:16px;width:34px;height:34px;display:flex;align-items:center;justify-content:center;">📍</button>`;
        div.onclick = function() {
            map.locate({ setView: true, maxZoom: 16 });
        };
        return div;
    };
    locateBtn.addTo(map);

    let userMarker = null;
    let userCircle = null;
    map.on('locationfound', function(e) {
        if (userMarker) map.removeLayer(userMarker);
        if (userCircle) map.removeLayer(userCircle);
        
        userCircle = L.circle(e.latlng, {
            radius: e.accuracy / 2,
            color: '#059669',
            fillOpacity: 0.1,
            weight: 2
        }).addTo(map);
        
        userMarker = L.marker(e.latlng, {
            icon: L.divIcon({
                className: 'user-location-marker',
                html: '<div class="user-location-marker"></div>',
                iconSize: [16, 16],
                iconAnchor: [8, 8]
            })
        }).addTo(map).bindPopup('Lokasi Anda').openPopup();
    });

    map.on('locationerror', function(e) {
        console.warn('Location error:', e.message);
    });

    // ---- INITIAL LOAD ----
    loadLaporan();
    loadFasilitas();

    // Load fasilitas if toggle is checked by default (it's unchecked by default)
    // But we'll leave it off initially as per UI

    // ---- HANDLE SIDEBAR OFFSET ON DESKTOP ----
    // On desktop, sidebar is always visible, map should shift right
    function adjustMapForSidebar() {
        const isDesktop = window.innerWidth >= 1024;
        const isSidebarOpen = !sidebar.classList.contains('-translate-x-full') || isDesktop;
        if (isSidebarOpen && isDesktop) {
            mapContainer.style.marginLeft = '288px';
        } else {
            mapContainer.style.marginLeft = '0';
        }
        // Trigger map resize
        setTimeout(() => map.invalidateSize(), 50);
    }

    // Initial adjustment
    adjustMapForSidebar();

    // Re-adjust on resize
    window.addEventListener('resize', adjustMapForSidebar);

    // Also adjust when sidebar opens/closes on mobile
    const observer = new MutationObserver(() => {
        adjustMapForSidebar();
    });
    observer.observe(sidebar, { attributes: true, attributeFilter: ['class'] });

    // Clean up observer if needed (not critical for demo)

});
</script>
@endpush