@extends('layouts.admin')

@section('title', 'Edit Kategori Hambatan')
@section('page_title', 'Edit Kategori Hambatan')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <nav class="text-sm text-slate-400" aria-label="Breadcrumb">
        <ol class="flex items-center gap-2">
            <li><a href="{{ route('admin.kategori-hambatan.index') }}" class="hover:text-emerald-700 transition-colors">Kategori Hambatan</a></li>
            <li aria-hidden="true">/</li>
            <li class="text-slate-700 font-medium" aria-current="page">Edit: {{ $kategoriHambatan->nama }}</li>
        </ol>
    </nav>

    <div class="bg-white rounded-xl border border-slate-200 p-6">
        <form method="POST" action="{{ route('admin.kategori-hambatan.update', $kategoriHambatan) }}" novalidate>
            @csrf @method('PUT')
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 rounded-xl p-4 mb-6" role="alert">
                    <ul class="text-sm list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif

            <div class="space-y-4">
                <div>
                    <label for="nama" class="block text-sm font-medium text-slate-700 mb-1.5">Nama Kategori <span class="text-red-500" aria-hidden="true">*</span></label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama', $kategoriHambatan->nama) }}" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm" required>
                    @error('nama')<p class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="slug" class="block text-sm font-medium text-slate-700 mb-1.5">Slug</label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug', $kategoriHambatan->slug) }}" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm font-mono">
                    @error('slug')<p class="mt-1 text-sm text-red-600" role="alert">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="keterangan" class="block text-sm font-medium text-slate-700 mb-1.5">Keterangan</label>
                    <textarea id="keterangan" name="keterangan" rows="3" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">{{ old('keterangan', $kategoriHambatan->keterangan) }}</textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="bobot_keparahan" class="block text-sm font-medium text-slate-700 mb-1.5">Bobot Keparahan <span class="text-red-500" aria-hidden="true">*</span></label>
                        <input type="number" id="bobot_keparahan" name="bobot_keparahan" value="{{ old('bobot_keparahan', $kategoriHambatan->bobot_keparahan) }}" step="0.1" min="0.1" max="5" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm" required>
                    </div>
                    <div>
                        <label for="urutan_tampil" class="block text-sm font-medium text-slate-700 mb-1.5">Urutan Tampil</label>
                        <input type="number" id="urutan_tampil" name="urutan_tampil" value="{{ old('urutan_tampil', $kategoriHambatan->urutan_tampil) }}" min="0" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="warna_penanda" class="block text-sm font-medium text-slate-700 mb-1.5">Warna Penanda <span class="text-red-500" aria-hidden="true">*</span></label>
                        <input type="color" id="warna_penanda" name="warna_penanda" value="{{ old('warna_penanda', $kategoriHambatan->warna_penanda) }}" class="w-full h-10 rounded-xl border-slate-300 cursor-pointer">
                    </div>
                    <div>
                        <label for="ikon" class="block text-sm font-medium text-slate-700 mb-1.5">Ikon</label>
                        <input type="text" id="ikon" name="ikon" value="{{ old('ikon', $kategoriHambatan->ikon) }}" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" id="aktif" name="aktif" value="1" {{ old('aktif', $kategoriHambatan->aktif) ? 'checked' : '' }} class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                    <label for="aktif" class="text-sm font-medium text-slate-700">Aktif</label>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-slate-200">
                <a href="{{ route('admin.kategori-hambatan.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-700">Batal</a>
                <button type="submit" class="inline-flex items-center gap-2 bg-emerald-600 text-white font-semibold px-6 py-2.5 rounded-xl hover:bg-emerald-700 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 shadow-sm text-sm">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
