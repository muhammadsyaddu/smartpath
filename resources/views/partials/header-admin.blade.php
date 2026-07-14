<header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-6" role="banner">
    <div class="flex items-center gap-4">
        <button class="lg:hidden text-slate-600 hover:text-slate-900" aria-label="Toggle menu" onclick="document.querySelector('aside').classList.toggle('hidden')">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <h1 class="text-lg font-semibold text-slate-800">@yield('page_title', 'Dashboard')</h1>
    </div>
    <div class="flex items-center gap-4">
        <a href="{{ route('notifikasi.index') }}" class="relative text-slate-500 hover:text-emerald-700 transition-colors" aria-label="Notifikasi">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            @if(auth()->user()->notifikasi_belum_dibaca_count > 0)
                <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center">{{ auth()->user()->notifikasi_belum_dibaca_count }}</span>
            @endif
        </a>
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-700 font-semibold text-xs">{{ strtoupper(substr(auth()->user()->nama_lengkap, 0, 2)) }}</div>
            <div class="hidden sm:block">
                <p class="text-sm font-medium text-slate-700">{{ auth()->user()->nama_lengkap }}</p>
                <p class="text-xs text-slate-400 capitalize">{{ auth()->user()->peran }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-slate-400 hover:text-red-600 transition-colors" aria-label="Keluar">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            </button>
        </form>
    </div>
</header>