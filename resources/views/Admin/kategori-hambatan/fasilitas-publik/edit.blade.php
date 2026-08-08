@extends('layouts.admin')

@section('title', 'Edit Fasilitas Publik')
@section('page_title', 'Edit Fasilitas Publik')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>#facility-map { height: 280px; border-radius: 0.75rem; }</style>
@endpush

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <nav class="text-sm text-slate-400" aria-label="Breadcrumb">
        <ol class="flex items-center gap-2">
            <li><a href="{{ route('admin.fasilitas-publik.index') }}" class="hover:text-emerald-700 transition-colors">Fasilitas Publik</a></li>
            <li aria-hidden="true">/</li>
            <li class="text-slate-700 font-medium" aria-current="page">Edit: {{ $fasilitasPublik->nama }}</li>
        </ol>
    </nav>

    <div class="bg-white rounded-xl border border-slate-200 p-6">
        <form method="POST" action="{{ route('admin.fasilitas-publik.update', $fasilitasPublik) }}" novalidate>
            @csrf @method('PUT')
            <div class="space-y-4">
                <div>
                    <label for="nama" class="block text-sm font-medium text-slate-700 mb-1.5">Nama Fasilitas <span class="text-red-500" aria-hidden="true">*</span></label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama', $fasilitasPublik->nama) }}" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm" required>
                    @error('nama')<p class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>@enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="jenis" class="block text-sm font-medium text-slate-700 mb-1.5">Jenis <span class="text-red-500" aria-hidden="true">*</span></label>
                        <select id="jenis" name="jenis" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm" required>
                            @foreach(['rumah_sakit'=>'Rumah Sakit','sekolah'=>'Sekolah','stasiun'=>'Stasiun','halte_bus'=>'Halte Bus','pasar'=>'Pasar','kantor_pemerintah'=>'Kantor Pemerintah','taman'=>'Taman','masjid'=>'Masjid','lainnya'=>'Lainnya'] as $val => $label)
                                <option value="{{ $val }}" {{ old('jenis', $fasilitasPublik->jenis) === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('jenis')<p class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="wilayah_id" class="block text-sm font-medium text-slate-700 mb-1.5">Wilayah</label>
                        <select id="wilayah_id" name="wilayah_id" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                            <option value="">Pilih Wilayah</option>
                            @foreach($wilayah as $w)
                                <option value="{{ $w->id }}" {{ old('wilayah_id', $fasilitasPublik->wilayah_id) == $w->id ? 'selected' : '' }}>{{ $w->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label for="alamat" class="block text-sm font-medium text-slate-700 mb-1.5">Alamat</label>
                    <input type="text" id="alamat" name="alamat" value="{{ old('alamat', $fasilitasPublik->alamat) }}" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Lokasi pada Peta</label>
                    <div id="facility-map" class="mb-3" role="application" aria-label="Peta lokasi fasilitas"></div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="latitude" class="block text-xs font-medium text-slate-500 mb-1">Latitude</label>
                            <input type="text" id="latitude" name="latitude" value="{{ old('latitude', $fasilitasPublik->latitude) }}" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm font-mono" readonly>
                        </div>
                        <div>
                            <label for="longitude" class="block text-xs font-medium text-slate-500 mb-1">Longitude</label>
                            <input type="text" id="longitude" name="longitude" value="{{ old('longitude', $fasilitasPublik->longitude) }}" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm font-mono" readonly>
                        </div>
                    </div>
                </div>
                <div>
                    <label for="bobot_vital" class="block text-sm font-medium text-slate-700 mb-1.5">Bobot Vital <span class="text-red-500" aria-hidden="true">*</span></label>
                    <input type="number" id="bobot_vital" name="bobot_vital" value="{{ old('bobot_vital', $fasilitasPublik->bobot_vital) }}" step="0.1" min="0.1" max="5" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm" required>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" id="aktif" name="aktif" value="1" {{ old('aktif', $fasilitasPublik->aktif) ? 'checked' : '' }} class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                    <label for="aktif" class="text-sm font-medium text-slate-700">Aktif</label>
                </div>
            </div>
            <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-slate-200">
                <a href="{{ route('admin.fasilitas-publik.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-700">Batal</a>
                <button type="submit" class="inline-flex items-center gap-2 bg-emerald-600 text-white font-semibold px-6 py-2.5 rounded-xl hover:bg-emerald-700 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 shadow-sm text-sm">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const lat = {{ $fasilitasPublik->latitude ?? -6.4025 }};
    const lng = {{ $fasilitasPublik->longitude ?? 106.8197 }};
    const map = L.map('facility-map', { center: [lat, lng], zoom: 16 });
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OSM', maxZoom: 19 }).addTo(map);
    let marker = L.marker([lat, lng], { draggable: true }).addTo(map);
    marker.on('dragend', function(e) {
        const p = e.target.getLatLng();
        document.getElementById('latitude').value = p.lat.toFixed(7);
        document.getElementById('longitude').value = p.lng.toFixed(7);
    });
    map.on('click', function(e) {
        if (marker) map.removeLayer(marker);
        marker = L.marker([e.latlng.lat, e.latlng.lng], { draggable: true }).addTo(map);
        document.getElementById('latitude').value = e.latlng.lat.toFixed(7);
        document.getElementById('longitude').value = e.latlng.lng.toFixed(7);
        marker.on('dragend', function(ev) {
            const p = ev.target.getLatLng();
            document.getElementById('latitude').value = p.lat.toFixed(7);
            document.getElementById('longitude').value = p.lng.toFixed(7);
        });
    });
});
</script>
@endpush
