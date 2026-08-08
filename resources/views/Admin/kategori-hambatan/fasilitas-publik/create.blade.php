@extends('layouts.admin')

@section('title', 'Tambah Fasilitas Publik')
@section('page_title', 'Tambah Fasilitas Publik')

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
            <li class="text-slate-700 font-medium" aria-current="page">Tambah</li>
        </ol>
    </nav>

    <div class="bg-white rounded-xl border border-slate-200 p-6">
        <form method="POST" action="{{ route('admin.fasilitas-publik.store') }}" novalidate>
            @csrf
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 rounded-xl p-4 mb-6" role="alert">
                    <ul class="text-sm list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif

            <div class="space-y-4">
                <div>
                    <label for="nama" class="block text-sm font-medium text-slate-700 mb-1.5">Nama Fasilitas <span class="text-red-500" aria-hidden="true">*</span></label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama') }}" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm" required>
                    @error('nama')<p class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>@enderror
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="jenis" class="block text-sm font-medium text-slate-700 mb-1.5">Jenis <span class="text-red-500" aria-hidden="true">*</span></label>
                        <select id="jenis" name="jenis" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm" required>
                            <option value="">Pilih Jenis</option>
                            <option value="rumah_sakit" {{ old('jenis') === 'rumah_sakit' ? 'selected' : '' }}>Rumah Sakit</option>
                            <option value="sekolah" {{ old('jenis') === 'sekolah' ? 'selected' : '' }}>Sekolah</option>
                            <option value="stasiun" {{ old('jenis') === 'stasiun' ? 'selected' : '' }}>Stasiun</option>
                            <option value="halte_bus" {{ old('jenis') === 'halte_bus' ? 'selected' : '' }}>Halte Bus</option>
                            <option value="pasar" {{ old('jenis') === 'pasar' ? 'selected' : '' }}>Pasar</option>
                            <option value="kantor_pemerintah" {{ old('jenis') === 'kantor_pemerintah' ? 'selected' : '' }}>Kantor Pemerintah</option>
                            <option value="taman" {{ old('jenis') === 'taman' ? 'selected' : '' }}>Taman</option>
                            <option value="masjid" {{ old('jenis') === 'masjid' ? 'selected' : '' }}>Masjid</option>
                            <option value="lainnya" {{ old('jenis') === 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('jenis')<p class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="wilayah_id" class="block text-sm font-medium text-slate-700 mb-1.5">Wilayah</label>
                        <select id="wilayah_id" name="wilayah_id" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                            <option value="">Pilih Wilayah</option>
                            @foreach($wilayah as $w)
                                <option value="{{ $w->id }}" {{ old('wilayah_id') == $w->id ? 'selected' : '' }}>{{ $w->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div>
                    <label for="alamat" class="block text-sm font-medium text-slate-700 mb-1.5">Alamat</label>
                    <input type="text" id="alamat" name="alamat" value="{{ old('alamat') }}" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Lokasi pada Peta <span class="text-red-500" aria-hidden="true">*</span></label>
                    <div id="facility-map" class="mb-3" role="application" aria-label="Peta pemilih lokasi fasilitas"></div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="latitude" class="block text-xs font-medium text-slate-500 mb-1">Latitude</label>
                            <input type="text" id="latitude" name="latitude" value="{{ old('latitude') }}" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm font-mono" readonly>
                            @error('latitude')<p class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="longitude" class="block text-xs font-medium text-slate-500 mb-1">Longitude</label>
                            <input type="text" id="longitude" name="longitude" value="{{ old('longitude') }}" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm font-mono" readonly>
                            @error('longitude')<p class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
                <div>
                    <label for="bobot_vital" class="block text-sm font-medium text-slate-700 mb-1.5">Bobot Vital <span class="text-red-500" aria-hidden="true">*</span></label>
                    <input type="number" id="bobot_vital" name="bobot_vital" value="{{ old('bobot_vital', 1) }}" step="0.1" min="0.1" max="5" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm" required>
                    @error('bobot_vital')<p class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>@enderror
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" id="aktif" name="aktif" value="1" {{ old('aktif', true) ? 'checked' : '' }} class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                    <label for="aktif" class="text-sm font-medium text-slate-700">Aktif</label>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-slate-200">
                <a href="{{ route('admin.fasilitas-publik.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-700">Batal</a>
                <button type="submit" class="inline-flex items-center gap-2 bg-emerald-600 text-white font-semibold px-6 py-2.5 rounded-xl hover:bg-emerald-700 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 shadow-sm text-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const map = L.map('facility-map', { center: [-6.4025, 106.8197], zoom: 14 });
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OSM', maxZoom: 19 }).addTo(map);
    let marker = null;
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
