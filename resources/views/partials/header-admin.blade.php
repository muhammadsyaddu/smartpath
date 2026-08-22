{{-- ==========================================================
     SIDEBAR ADMIN
========================================================== --}}
@admin
<aside
    class="hidden lg:flex lg:w-64 lg:flex-col bg-white border-r border-slate-200"
    role="complementary"
    aria-label="Menu administrator"
>
    {{-- Logo --}}
    <div class="flex items-center gap-2 px-6 h-16 border-b border-slate-200">
        <svg
            class="w-7 h-7 text-emerald-600"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"
            />
        </svg>

        <span class="font-semibold text-emerald-700">
            SmartPath
        </span>
    </div>


    <nav
        class="flex-1 px-4 py-6 space-y-1 overflow-y-auto"
        aria-label="Menu administrator"
    >

        {{-- Dashboard --}}
        <a
            href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-xl transition-colors
            {{ request()->routeIs('admin.dashboard')
                ? 'bg-emerald-50 text-emerald-700'
                : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"
                />
            </svg>

            Dashboard
        </a>


        {{-- =========================
             KELOLA DATA
        ========================== --}}
        <div class="pt-5 pb-2">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">
                Kelola Data
            </span>
        </div>


        {{-- Kategori Hambatan --}}
        <a
            href="{{ route('admin.kategori-hambatan.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-xl transition-colors
            {{ request()->routeIs('admin.kategori-hambatan.*')
                ? 'bg-emerald-50 text-emerald-700'
                : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A4 4 0 013 12V7a4 4 0 014-4z"
                />
            </svg>

            Kategori Hambatan
        </a>


        {{-- Fasilitas Publik --}}
        <a
            href="{{ route('admin.fasilitas-publik.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-xl transition-colors
            {{ request()->routeIs('admin.fasilitas-publik.*')
                ? 'bg-emerald-50 text-emerald-700'
                : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                />
            </svg>

            Fasilitas Publik
        </a>


        {{-- Wilayah --}}
        <a
            href="{{ route('admin.wilayah.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-xl transition-colors
            {{ request()->routeIs('admin.wilayah.*')
                ? 'bg-emerald-50 text-emerald-700'
                : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                />
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                />
            </svg>

            Wilayah
        </a>


        {{-- Pengguna --}}
        <a
            href="{{ route('admin.user.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-xl transition-colors
            {{ request()->routeIs('admin.user.*')
                ? 'bg-emerald-50 text-emerald-700'
                : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 9a3 3 0 11-6 0 3 3 0 016 0z"
                />
            </svg>

            Pengguna
        </a>


        {{-- =========================
             SISTEM
        ========================== --}}
        <div class="pt-5 pb-2">
            <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">
                Sistem
            </span>
        </div>


        {{-- Pengaturan Prioritas --}}
        <a
            href="{{ route('admin.pengaturan-prioritas.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-xl transition-colors
            {{ request()->routeIs('admin.pengaturan-prioritas.*')
                ? 'bg-emerald-50 text-emerald-700'
                : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"
                />
            </svg>

            Pengaturan Prioritas
        </a>


        {{-- Konfigurasi --}}
        <a
            href="{{ route('admin.konfigurasi-sistem.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-xl transition-colors
            {{ request()->routeIs('admin.konfigurasi-sistem.*')
                ? 'bg-emerald-50 text-emerald-700'
                : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 010 3.35 1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-2.37 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                />
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                />
            </svg>

            Konfigurasi Sistem
        </a>


        {{-- Audit Log --}}
        <a
            href="{{ route('admin.audit.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-xl transition-colors
            {{ request()->routeIs('admin.audit.*')
                ? 'bg-emerald-50 text-emerald-700'
                : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                />
            </svg>

            Audit Log
        </a>


        {{-- Kembali --}}
        <div class="pt-4 mt-4 border-t border-slate-200">
            <a
                href="{{ route('beranda') }}"
                class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-xl transition-colors"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"
                    />
                </svg>

                Kembali ke Publik
            </a>
        </div>

    </nav>
</aside>
@endadmin