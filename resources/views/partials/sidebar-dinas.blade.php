{{-- ==========================================================
     SIDEBAR DINAS
========================================================== --}}
@if(auth()->check() && auth()->user()->isDinas())
<aside
    class="hidden lg:flex lg:w-64 lg:flex-col bg-white border-r border-slate-200 min-h-screen justify-between"
    role="complementary"
    aria-label="Menu dinas"
>
    <div>
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
            class="px-4 py-6 space-y-1"
            aria-label="Menu dinas"
        >
            {{-- Dashboard --}}
            <a
                href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-xl
                {{ request()->routeIs('admin.dashboard')
                    ? 'bg-emerald-50 text-emerald-700'
                    : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
            >
                <svg
                    class="w-5 h-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"
                    />
                </svg>
                Dashboard
            </a>

            {{-- Laporan --}}
            <div class="pt-5 pb-2">
                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">
                    Laporan
                </span>
            </div>

            {{-- Verifikasi --}}
            <a
                href="{{ route('admin.verifikasi.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-xl
                {{ request()->routeIs('admin.verifikasi.*')
                    ? 'bg-emerald-50 text-emerald-700'
                    : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
            >
                <svg
                class="w-5 h-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <!-- Papan Klip -->
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                />
                <!-- Tanda Centang -->
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 14l2 2 4-4"
                />
            </svg>
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                </svg>
                Verifikasi Laporan
            </a>

            {{-- Peta --}}
            <a
                href="{{ route('peta.fasilitas') }}"
                class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900"
            >
                <svg
                    class="w-5 h-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 20l-5-2.5V5l5 2.5L15 5l5 2.5v12.5L15 17l-6 3z"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 7.5V20M15 5v12"
                    />
                </svg>
                Peta Infrastruktur
            </a>

            {{-- Rencana Perbaikan --}}
<a
    href="#"
    class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-xl text-slate-600 hover:bg-slate-50 hover:text-slate-900"
>
    <svg
        class="w-5 h-5 text-slate-600"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24"
    >
        <!-- 1. Kunci Pas (Wrench) - Diagonal Kanan Atas ke Kiri Bawah -->
        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"
        />
        <!-- 2. Gagang & Mata Obeng (Screwdriver) - Diagonal Kiri Atas ke Kanan Bawah -->
        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M4 4l2.5-2.5 3 3L7 7 4 4zm4 4l8.5 8.5M16.5 16.5l3 3-1.5 1.5-3-3"
        />
    </svg>

    Rencana Perbaikan
</a>

 {{-- Kembali --}}
<form action="{{ route('logout') }}" method="POST" class="w-full">
    @csrf
    <button
        type="submit"
        class="flex w-full items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-xl text-slate-600 hover:bg-red-50 hover:text-red-600 transition-colors group"
    >
        {{-- Ikon Logout (Keluar / Pintu) --}}
        <svg
            class="w-5 h-5 text-slate-600 group-hover:text-red-600 transition-colors"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
            />
        </svg>

        Logout
    </button>
</form>



            {{-- Kembali --}}
            <div class="pt-4 mt-4 border-t border-slate-200">
                <a
                    href="{{ route('beranda') }}"
                    class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-slate-500 hover:bg-slate-50 hover:text-slate-900 rounded-xl"
                >
                    <svg
                        class="w-5 h-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
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
    </div>

    {{-- Profil Akun Pengguna (Bottom Sidebar) --}}
    <div class="p-4 border-t border-slate-200">
        <div class="flex items-center gap-3 p-2 rounded-2xl border border-slate-200 bg-slate-50">
            {{-- Inisial Avatar --}}
            <div class="flex items-center justify-center w-10 h-10 rounded-full bg-slate-200 text-slate-700 font-bold text-xs shrink-0 border border-slate-300">
                {{ strtoupper(substr(auth()->user()->name ?? 'DP', 0, 2)) }}
            </div>

            {{-- Detail Nama & Email --}}
            <div class="min-w-0 flex-1">
                <p class="text-xs font-bold text-slate-800 truncate">
                    {{ auth()->user()->name ?? 'Dinas PUPR' }}
                </p>
                <p class="text-[11px] text-slate-500 truncate">
                    {{ auth()->user()->email ?? 'pupr@depok.go.id' }}
                </p>
            </div>
        </div>
    </div>
</aside>
@endif