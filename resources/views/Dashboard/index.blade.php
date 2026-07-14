@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
<div class="space-y-6">
    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4" role="region" aria-label="Statistik ringkasan">
        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <span class="text-xs font-medium text-slate-400">Total</span>
            </div>
            <p class="text-2xl font-bold text-slate-900">{{ $statistik['total'] ?? 0 }}</p>
            <p class="text-xs text-slate-500 mt-1">Laporan Masuk</p>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-xs font-medium text-amber-600">Menunggu</span>
            </div>
            <p class="text-2xl font-bold text-slate-900">{{ $statistik['menunggu'] ?? 0 }}</p>
            <p class="text-xs text-slate-500 mt-1">Perlu Verifikasi</p>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-teal-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <span class="text-xs font-medium text-teal-600">Proses</span>
            </div>
            <p class="text-2xl font-bold text-slate-900">{{ $statistik['dalam_perbaikan'] ?? 0 }}</p>
            <p class="text-xs text-slate-500 mt-1">Dalam Perbaikan</p>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-xs font-medium text-green-600">Selesai</span>
            </div>
            <p class="text-2xl font-bold text-slate-900">{{ $statistik['selesai'] ?? 0 }}</p>
            <p class="text-xs text-slate-500 mt-1">Terkonfirmasi Selesai</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Chart: Status Distribution --}}
        <div class="bg-white rounded-xl border border-slate-200 p-6">
            <h2 class="font-semibold text-slate-900 mb-4">Distribusi Status</h2>
            <div id="chart-status" class="h-48 flex items-end gap-3 px-2" role="img" aria-label="Grafik distribusi status laporan">
                {{-- Will be populated by JS --}}
            </div>
        </div>

        {{-- Chart: Kategori Distribution --}}
        <div class="bg-white rounded-xl border border-slate-200 p-6">
            <h2 class="font-semibold text-slate-900 mb-4">Per Kategori</h2>
            <div id="chart-kategori" class="space-y-3" role="img" aria-label="Grafik laporan per kategori">
                {{-- Will be populated by JS --}}
            </div>
        </div>

        {{-- Recent high priority --}}
        <div class="bg-white rounded-xl border border-slate-200 p-6">
            <h2 class="font-semibold text-slate-900 mb-4">Prioritas Tinggi</h2>
            <div class="space-y-3" id="priority-list" role="list" aria-label="Laporan prioritas tinggi">
                @if(isset($laporanPrioritasTinggi))
                    @foreach($laporanPrioritasTinggi->take(5) as $laporan)
                        <a href="{{ route('admin.verifikasi.show', $laporan) }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-50 transition-colors" role="listitem">
                            <span class="w-2 h-2 rounded-full bg-red-500 shrink-0" aria-hidden="true"></span>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-slate-800 truncate">{{ $laporan->judul }}</p>
                                <p class="text-xs text-slate-400">{{ $laporan->kode_laporan }} • Skor {{ number_format($laporan->skor_prioritas, 1) }}</p>
                            </div>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold {{ $laporan->warna }}">{{ $laporan->status_label }}</span>
                        </a>
                    @endforeach
                @endif
            </div>
        </div>
    </div>

    {{-- Recent reports table --}}
    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <h2 class="font-semibold text-slate-900">Laporan Terbaru</h2>
            <a href="{{ route('admin.verifikasi.index') }}" class="text-sm font-medium text-emerald-700 hover:text-emerald-800 transition-colors">Lihat semua →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm" role="table">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/50">
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider" scope="col">Kode</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider" scope="col">Judul</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider" scope="col">Kategori</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider" scope="col">Status</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider" scope="col">Prioritas</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider" scope="col">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @if(isset($laporanTerbaru))
                        @foreach($laporanTerbaru as $item)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-3 font-mono text-xs text-slate-500">{{ $item->kode_laporan }}</td>
                                <td class="px-6 py-3">
                                    <a href="{{ route('admin.verifikasi.show', $item) }}" class="font-medium text-slate-800 hover:text-emerald-700 transition-colors">{{ Str::limit($item->judul, 40) }}</a>
                                </td>
                                <td class="px-6 py-3 text-slate-600">
                                    @if($item->kategoriHambatan)
                                        <span class="inline-flex items-center gap-1">
                                            <span class="w-2 h-2 rounded-full" style="background-color: {{ $item->kategoriHambatan->warna_penanda }}" aria-hidden="true"></span>
                                            {{ $item->kategoriHambatan->nama }}
                                        </span>
                                    @else
                                        <span class="text-slate-400">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3"><span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-semibold {{ $item->warna }}">{{ $item->status_label }}</span></td>
                                <td class="px-6 py-3">
                                    @if($item->skor_prioritas)
                                        <span class="font-medium {{ $item->tingkat_prioritas === 'tinggi' ? 'text-red-600' : ($item->tingkat_prioritas === 'sedang' ? 'text-amber-600' : 'text-blue-600') }}">
                                            {{ number_format($item->skor_prioritas, 1) }}
                                        </span>
                                    @else
                                        <span class="text-slate-400">—</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 text-xs text-slate-400">{{ $item->created_at->format('d M Y H:i') }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="6" class="px-6 py-8 text-center text-slate-400">Belum ada laporan</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Load chart data
    fetch('{{ route("admin.dashboard.chart") }}')
        .then(res => res.json())
        .then(data => {
            // Status distribution bar chart
            if (data.status) {
                const statusContainer = document.getElementById('chart-status');
                const colors = {
                    menunggu_verifikasi: { bg: 'bg-amber-400', text: 'text-amber-700' },
                    diverifikasi: { bg: 'bg-emerald-400', text: 'text-emerald-700' },
                    dalam_perbaikan: { bg: 'bg-teal-400', text: 'text-teal-700' },
                    selesai: { bg: 'bg-green-500', text: 'text-green-700' },
                    ditolak: { bg: 'bg-red-400', text: 'text-red-700' },
                    diarsipkan: { bg: 'bg-slate-400', text: 'text-slate-700' }
                };
                const labels = {
                    menunggu_verifikasi: 'Menunggu', diverifikasi: 'Terverifikasi',
                    dalam_perbaikan: 'Perbaikan', selesai: 'Selesai',
                    ditolak: 'Ditolak', diarsipkan: 'Diarsipkan'
                };
                const maxVal = Math.max(...Object.values(data.status));
                statusContainer.innerHTML = '';
                Object.entries(data.status).forEach(([key, val]) => {
                    const pct = maxVal > 0 ? (val / maxVal * 100) : 0;
                    const c = colors[key] || { bg: 'bg-slate-300', text: 'text-slate-600' };
                    statusContainer.innerHTML += `
                        <div class="flex-1 flex flex-col items-center gap-1">
                            <span class="text-xs font-semibold ${c.text}">${val}</span>
                            <div class="w-full rounded-t-lg ${c.bg}" style="height:${Math.max(pct, 4)}%;min-height:8px;" role="presentation"></div>
                            <span class="text-[10px] text-slate-500 text-center leading-tight">${labels[key] || key}</span>
                        </div>
                    `;
                });
            }

            // Kategori distribution
            if (data.kategori) {
                const katContainer = document.getElementById('chart-kategori');
                katContainer.innerHTML = '';
                const maxKat = Math.max(...data.kategori.map(k => k.total));
                data.kategori.forEach(k => {
                    const pct = maxKat > 0 ? (k.total / maxKat * 100) : 0;
                    katContainer.innerHTML += `
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-xs font-medium text-slate-700 flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full" style="background:${k.warna}" aria-hidden="true"></span>
                                    ${k.nama}
                                </span>
                                <span class="text-xs text-slate-500">${k.total}</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-2">
                                <div class="h-2 rounded-full" style="width:${pct}%;background:${k.warna};" role="progressbar" aria-valuenow="${pct}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    `;
                });
            }
        })
        .catch(err => console.error('Chart load error:', err));
});
</script>
@endpush