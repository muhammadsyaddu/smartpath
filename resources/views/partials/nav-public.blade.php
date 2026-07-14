<nav class="bg-white border-b border-slate-200 sticky top-0 z-40" role="navigation" aria-label="Navigasi utama">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center gap-8">
                <a href="{{ route('beranda') }}" class="flex items-center gap-2 text-emerald-700 font-semibold text-lg" aria-label="SmartPath Beranda">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                    <span>SmartPath</span>
                </a>
                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ route('beranda') }}" class="text-slate-600 hover:text-emerald-700 text-sm font-medium transition-colors">Beranda</a>
                    <a href="{{ route('peta.index') }}" class="text-slate-600 hover:text-emerald-700 text-sm font-medium transition-colors">Peta</a>
                    @auth
                        <a href="{{ route('laporan.create') }}" class="text-slate-600 hover:text-emerald-700 text-sm font-medium transition-colors">Lapor</a>
                        <a href="{{ route('laporan.index') }}" class="text-slate-600 hover:text-emerald-700 text-sm font-medium transition-colors">Laporan Saya</a>
                    @endauth
                </div>
            </div>

            <div class="flex items-center gap-4">
                @auth
                    @if(auth()->user()->isAdmin() || auth()->user()->isDinas())
                        <a href="{{ route('admin.dashboard') }}" class="hidden sm:inline-flex items-center gap-1.5 text-sm font-medium text-emerald-700 hover:text-emerald-800 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                            Dashboard
                        </a>
                    @endif

                    <a href="{{ route('notifikasi.index') }}" class="relative text-slate-600 hover:text-emerald-700 transition-colors" aria-label="Notifikasi">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        @if(auth()->user()->notifikasi_belum_dibaca_count > 0)
                            <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center">{{ auth()->user()->notifikasi_belum_dibaca_count }}</span>
                        @endif
                    </a>

                    <div class="relative group">
                        <button class="flex items-center gap-2 text-sm font-medium text-slate-700 hover:text-emerald-700 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 rounded-xl px-2 py-1" aria-haspopup="true" aria-expanded="false">
                            <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-700 font-semibold text-xs">{{ strtoupper(substr(auth()->user()->nama_lengkap, 0, 2)) }}</div>
                            <span class="hidden sm:inline">{{ auth()->user()->nama_lengkap }}</span>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-200 py-1 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50" role="menu">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50" role="menuitem">Profil</a>
                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50" role="menuitem">Keluar</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium px-4 py-2 rounded-xl transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        Masuk
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>