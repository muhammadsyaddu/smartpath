<footer class="bg-white border-t border-slate-200 mt-auto" role="contentinfo">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <div class="flex items-center gap-2 text-emerald-700 font-semibold text-lg mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                    SmartPath
                </div>
                <p class="text-sm text-slate-500 leading-relaxed">Sistem Otomatis Pemetaan Aksesibilitas dan Prioritas Infrastruktur Disabilitas Berbasis Smart City.</p>
            </div>
            <div>
                <h3 class="font-semibold text-slate-800 mb-3">Navigasi</h3>
                <ul class="space-y-2 text-sm text-slate-500">
                    <li><a href="{{ route('beranda') }}" class="hover:text-emerald-700 transition-colors">Beranda</a></li>
                    <li><a href="{{ route('peta.index') }}" class="hover:text-emerald-700 transition-colors">Peta Interaktif</a></li>
                    <li><a href="{{ route('laporan.create') }}" class="hover:text-emerald-700 transition-colors">Laporkan Hambatan</a></li>
                </ul>
            </div>
            <div>
                <h3 class="font-semibold text-slate-800 mb-3">Kontak</h3>
                <p class="text-sm text-slate-500">Kota Depok, Jawa Barat<br>Email: admin@smartpath.id</p>
            </div>
        </div>
        <div class="border-t border-slate-200 mt-8 pt-6 text-center">
            <p class="text-xs text-slate-400">&copy; {{ date('Y') }} SmartPath - CTRL+WIN Team. MAGE 12 Competition.</p>
        </div>
    </div>
</footer>