@props(['laporan'])

<article class="bg-white rounded-xl border border-slate-200 overflow-hidden hover:shadow-md transition-shadow group" aria-label="Laporan {{ $laporan->judul }}">
    @if($laporan->fotoUtama)
        <div class="relative h-40 overflow-hidden bg-slate-100">
            <img src="{{ $laporan->fotoUtama->url }}" alt="Foto laporan: {{ $laporan->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
            <div class="absolute top-2 right-2">
                <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-semibold {{ $laporan->warna }} shadow-sm">
                    {{ $laporan->status_label }}
                </span>
            </div>
        </div>
    @else
        <div class="relative h-40 bg-gradient-to-br from-slate-100 to-slate-50 flex items-center justify-center">
            <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <div class="absolute top-2 right-2">
                <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-semibold {{ $laporan->warna }} shadow-sm">
                    {{ $laporan->status_label }}
                </span>
            </div>
        </div>
    @endif

    <div class="p-4">
        <div class="flex items-center gap-2 mb-2">
            @if($laporan->kategoriHambatan)
                <span class="inline-block w-2.5 h-2.5 rounded-full" style="background-color: {{ $laporan->kategoriHambatan->warna_penanda }}" aria-hidden="true"></span>
                <span class="text-xs font-medium text-slate-500">{{ $laporan->kategoriHambatan->nama }}</span>
            @endif
            @if($laporan->tingkat_prioritas === 'tinggi')
                <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-md text-[10px] font-bold bg-red-100 text-red-700" aria-label="Prioritas tinggi">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M12.395 2.553a1 1 0 00-1.45-.095l-.8.8a1 1 0 00-.095 1.45l.223.223a1 1 0 010 1.414l-2.56 2.56a1 1 0 01-1.414 0l-.223-.223a1 1 0 00-1.45.095l-.8.8a1 1 0 00.095 1.45l7.151 7.151a1 1 0 001.45.095l.8-.8a1 1 0 00.095-1.45l-.223-.223a1 1 0 010-1.414l2.56-2.56a1 1 0 011.414 0l.223.223a1 1 0 001.45-.095l.8-.8a1 1 0 00-.095-1.45l-7.151-7.15z"/></svg>
                    Tinggi
                </span>
            @endif
        </div>

        <h3 class="text-sm font-semibold text-slate-900 mb-1 line-clamp-2 group-hover:text-emerald-700 transition-colors">
            <a href="{{ route('laporan.show', $laporan) }}" class="focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 rounded">
                {{ $laporan->judul }}
            </a>
        </h3>

        <p class="text-xs text-slate-500 mb-3 line-clamp-2">{{ $laporan->deskripsi }}</p>

        <div class="flex items-center justify-between text-xs text-slate-400">
            <div class="flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>{{ Str::limit($laporan->alamat_lengkap, 30) }}</span>
            </div>
            <time datetime="{{ $laporan->created_at->format('Y-m-d') }}">{{ $laporan->created_at->diffForHumans() }}</time>
        </div>
    </div>
</article>