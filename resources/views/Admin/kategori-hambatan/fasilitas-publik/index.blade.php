@extends('layouts.admin')

@section('title', 'Fasilitas Publik')
@section('page_title', 'Fasilitas Publik')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-lg font-semibold text-slate-900">Fasilitas Publik</h2>
            <p class="text-sm text-slate-500">Kelola fasilitas publik untuk perhitungan prioritas</p>
        </div>
        <a href="{{ route('admin.fasilitas-publik.create') }}" class="inline-flex items-center gap-2 bg-emerald-600 text-white font-semibold px-5 py-2.5 rounded-xl hover:bg-emerald-700 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 shadow-sm text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Fasilitas
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm" role="table" aria-label="Daftar fasilitas publik">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/50">
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider" scope="col">Nama</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider" scope="col">Jenis</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider" scope="col">Wilayah</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider" scope="col">Bobot Vital</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider" scope="col">Koordinat</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider" scope="col">Status</th>
                        <th class="text-right px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider" scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($fasilitasPublik as $fasilitas)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-3 font-medium text-slate-800">{{ $fasilitas->nama }}</td>
                            <td class="px-6 py-3 text-slate-600">{{ ucfirst(str_replace('_', ' ', $fasilitas->jenis)) }}</td>
                            <td class="px-6 py-3 text-slate-600">{{ $fasilitas->wilayah->nama ?? '-' }}</td>
                            <td class="px-6 py-3 text-slate-600">{{ $fasilitas->bobot_vital }}</td>
                            <td class="px-6 py-3 text-xs font-mono text-slate-400">{{ $fasilitas->latitude }}, {{ $fasilitas->longitude }}</td>
                            <td class="px-6 py-3">
                                @if($fasilitas->aktif)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-semibold bg-green-100 text-green-700">Aktif</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-semibold bg-slate-100 text-slate-500">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-3 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.fasilitas-publik.edit', $fasilitas) }}" class="text-emerald-700 hover:text-emerald-800 font-medium text-xs transition-colors">Edit</a>
                                    <form method="POST" action="{{ route('admin.fasilitas-publik.destroy', $fasilitas) }}" onsubmit="return confirm('Yakin hapus fasilitas ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700 font-medium text-xs transition-colors">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-6 py-12 text-center text-slate-400">Belum ada fasilitas publik</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($fasilitasPublik->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 flex justify-center">{{ $fasilitasPublik->withQueryString()->links('pagination::tailwind') }}</div>
        @endif
    </div>
</div>
@endsection