@extends('layouts.admin')

@section('title', 'Verifikasi Laporan')
@section('page_title', 'Verifikasi Laporan')

@section('content')
<div class="space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-lg font-semibold text-slate-900">Antrian Verifikasi</h2>
            <p class="text-sm text-slate-500">Kelola dan verifikasi laporan hambatan dari warga</p>
        </div>
        <div class="flex items-center gap-3">
            {{-- Filter status --}}
            <select id="filter-status" class="rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm" aria-label="Filter status">
                <option value="menunggu_verifikasi" {{ request('status', 'menunggu_verifikasi') === 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                <option value="diverifikasi" {{ request('status') === 'diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                <option value="dalam_perbaikan" {{ request('status') === 'dalam_perbaikan' ? 'selected' : '' }}>Dalam Perbaikan</option>
                <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                <option value="" {{ request('status') === '' ? 'selected' : '' }}>Semua Status</option>
            </select>
        </div>
    </div>

    {{-- Reports table --}}
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm" role="table" aria-label="Daftar laporan untuk verifikasi">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/50">
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider" scope="col">Kode</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider" scope="col">Judul</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider" scope="col">Kategori</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider" scope="col">Pelapor</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider" scope="col">Status</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider" scope="col">Prioritas</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider" scope="col">Tanggal</th>
                        <th class="text-right px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider" scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($laporan as $item)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-4 py-3 font-mono text-xs text-slate-500">{{ $item->kode_laporan }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    @if($item->fotoUtama)
                                        <img src="{{ $item->fotoUtama->url }}" alt="" class="w-8 h-8 rounded-lg object-cover" aria-hidden="true">
                                    @endif
                                    <a href="{{ route('admin.verifikasi.show', $item) }}" class="font-medium text-slate-800 hover:text-emerald-700 transition-colors">
                                        {{ Str::limit($item->judul, 35) }}
                                    </a>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-slate-600">
                                @if($item->kategoriHambatan)
                                    <span class="inline-flex items-center gap-1">
                                        <span class="w-2 h-2 rounded-full" style="background-color: {{ $item->kategoriHambatan->warna_penanda }}" aria-hidden="true"></span>
                                        {{ $item->kategoriHambatan->nama }}
                                    </span>
                                @else
                                    <span class="text-slate-400">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-slate-600">{{ $item->pelapor->nama_lengkap ?? '-' }}</td>
                            <td class="px-4 py-3"><span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-semibold {{ $item->warna }}">{{ $item->status_label }}</span></td>
                            <td class="px-4 py-3">
                                @if($item->skor_prioritas)
                                    <span class="font-medium {{ $item->tingkat_prioritas === 'tinggi' ? 'text-red-600' : ($item->tingkat_prioritas === 'sedang' ? 'text-amber-600' : 'text-blue-600') }}">
                                        {{ number_format($item->skor_prioritas, 1) }}
                                    </span>
                                @else
                                    <span class="text-slate-400">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-xs text-slate-400">{{ $item->created_at->format('d M H:i') }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.verifikasi.show', $item) }}" class="inline-flex items-center gap-1 text-emerald-700 hover:text-emerald-800 font-medium text-xs transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 rounded" aria-label="Verifikasi laporan {{ $item->kode_laporan }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Verifikasi
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="px-4 py-12 text-center text-slate-400">Tidak ada laporan yang perlu diverifikasi</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($laporan->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 flex justify-center">
                {{ $laporan->withQueryString()->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.getElementById('filter-status')?.addEventListener('change', function() {
    const url = new URL(window.location.href);
    if (this.value) { url.searchParams.set('status', this.value); } else { url.searchParams.delete('status'); }
    window.location.href = url.toString();
});
</script>
@endpush
@endsection