<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartPath - Pemetaan Aksesibilitas Infrastruktur Disabilitas</title>
    <meta name="description" content="Platform pemetaan aksesibilitas infrastruktur publik untuk penyandang disabilitas kota Depok secara data-driven.">

    <!-- Font Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (CDN Standar - Bebas dari Vite) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        emerald: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            200: '#a7f3d0',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                            950: '#022c22',
                        },
                    }
                }
            }
        }
    </script>

    <!-- FontAwesome / Lucide Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-white text-slate-800 dark:bg-slate-950 dark:text-slate-100 transition-colors duration-200 antialiased">

    <!-- ALERT NOTIFIKASI SUKSES -->
    @if(session('success'))
        <div class="bg-emerald-600 text-white text-xs sm:text-sm py-2.5 px-4 text-center font-medium shadow-md flex items-center justify-center space-x-2">
            <i class="fa-solid fa-circle-check"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- HEADER / NAVBAR -->
    <header class="sticky top-0 z-50 backdrop-blur-md bg-white/90 dark:bg-slate-900/90 border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 xl:px-10 h-20 flex items-center justify-between">
            
            <!-- Logo & Tagline -->
            <a href="{{ route('beranda') }}" class="flex items-center space-x-3 group">
                <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-xl shadow-md group-hover:bg-emerald-700 transition">
                    <i class="fa-solid fa-gear text-lg"></i>
                </div>
                <div>
                    <div className="text-xl font-extrabold tracking-tight text-slate-900 dark:text-white leading-tight">
                        SmartPath
                    </div>
                    <div class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">
                        Aksesibilitas untuk Semua
                    </div>
                </div>
            </a>

            <!-- Navigation Links -->
            <nav class="hidden md:flex items-center space-x-8">
                <a href="{{ route('beranda') }}" class="relative py-2 text-sm font-bold text-emerald-600 dark:text-emerald-400">
                    Beranda
                    <span class="absolute bottom-0 left-0 right-0 h-0.5 bg-emerald-600 dark:bg-emerald-400 rounded-full"></span>
                </a>
                <a href="{{ route('peta.index') }}" class="py-2 text-sm font-semibold text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition">
                    Peta
                </a>
                <a href="{{ Route::has('laporan.index') ? route('laporan.index') : '#laporan' }}" class="py-2 text-sm font-semibold text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition">
                    Laporan
                </a>
                <a href="#tentang" class="py-2 text-sm font-semibold text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition">
                    Tentang
                </a>
                <a href="#panduan" class="py-2 text-sm font-semibold text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition">
                    Panduan
                </a>
            </nav>

            <!-- Auth / Right Controls -->
            <div class="flex items-center space-x-3">
                <button id="themeToggleBtn" aria-label="Toggle Theme" class="p-2.5 rounded-lg border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                    <i id="themeToggleIcon" class="fa-solid fa-moon"></i>
                </button>

                @auth
                    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg shadow-sm transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-slate-800 dark:text-slate-200 border border-slate-300 dark:border-slate-700 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                        Masuk
                    </a>
                    <a href="{{ route('auth.register') }}" class="hidden sm:inline-block px-4 py-2 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg shadow-sm transition">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- HERO SECTION -->
    <section class="py-14 md:py-20 xl:py-24 border-b border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50">
        <div class="max-w-7xl xl:max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-10">
            <div class="grid grid-cols-1 lg:grid-cols-[1.05fr_0.95fr] gap-10 lg:gap-16 xl:gap-20 items-center">
                
                <!-- Hero Left Column -->
                <div class="space-y-6 xl:pr-8">
                    <div class="inline-flex items-center space-x-2 px-3.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-950/80 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>Platform Aksesibilitas Kota</span>
                    </div>

                    <h1 class="text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight">
                        Pemetaan Aksesibilitas Infrastruktur Disabilitas
                    </h1>

                    <p class="text-base sm:text-lg text-slate-600 dark:text-slate-300 leading-relaxed max-w-2xl">
                        SmartPath membantu menyaring, memetakan, dan memprioritaskan hambatan aksesibilitas infrastruktur publik bagi penyandang disabilitas secara data-driven.
                    </p>

                    <div class="flex flex-wrap gap-4 pt-2">
                        <a href="{{ auth()->check() ? route('laporan.create') : route('login') }}" class="flex items-center space-x-2 px-6 py-3 xl:px-7 xl:py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg shadow-md transition transform active:scale-95">
                            <i class="fa-solid fa-plus"></i>
                            <span>Laporkan Hambatan</span>
                        </a>

                        <a href="{{ route('peta.index') }}" class="flex items-center space-x-2 px-6 py-3 xl:px-7 xl:py-3.5 border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-100 hover:bg-slate-50 dark:hover:bg-slate-700 font-semibold rounded-lg transition">
                            <i class="fa-solid fa-map-location-dot text-emerald-600 dark:text-emerald-400"></i>
                            <span>Lihat Peta</span>
                        </a>
                    </div>
                </div>

                <!-- Hero Right Column: Vector Map Illustration & 4 Stats Cards -->
                <div class="space-y-6 xl:pl-4">
                    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 xl:p-8 shadow-sm relative overflow-hidden">
                        
                        <!-- Map Visual Banner -->
                        <div class="h-44 bg-slate-50 dark:bg-slate-800/60 rounded-xl relative overflow-hidden flex items-center justify-center border border-dashed border-slate-300 dark:border-slate-700">
                            <svg class="w-full h-full p-2" viewBox="0 0 500 180" fill="none">
                                <path d="M 50 140 L 50 70 L 80 70 L 80 140 M 80 140 L 80 50 L 120 50 L 120 140 M 120 140 L 120 90 L 150 90 L 150 140" stroke="#94a3b8" stroke-width="1.5" stroke-dasharray="3 3" />
                                <path d="M 350 140 L 350 60 L 390 60 L 390 140 M 390 140 L 390 80 L 430 80 L 430 140" stroke="#94a3b8" stroke-width="1.5" stroke-dasharray="3 3" />
                                <path d="M 280 140 C 310 110, 340 110, 370 140" stroke="#059669" stroke-width="2" fill="none" />
                                <line x1="20" y1="140" x2="480" y2="140" stroke="#475569" stroke-width="2" />
                                <g transform="translate(210, 85)">
                                    <circle cx="20" cy="15" r="7" stroke="#059669" stroke-width="2.5" fill="#ffffff" />
                                    <path d="M 20 22 L 20 38 L 32 38" stroke="#059669" stroke-width="2.5" fill="none" />
                                    <circle cx="18" cy="42" r="12" stroke="#059669" stroke-width="2.5" fill="none" />
                                    <path d="M 12 30 L 28 30" stroke="#059669" stroke-width="2" />
                                </g>
                                <path d="M 110 90 C 160 30, 240 30, 270 70" stroke="#059669" stroke-width="2" stroke-dasharray="5 5" fill="none" />
                                <circle cx="110" cy="90" r="5" fill="#ef4444" />
                                <circle cx="270" cy="70" r="5" fill="#059669" />
                            </svg>
                        </div>

                        <!-- 4 Stat Cards Grid -->
                        <div class="grid grid-cols-2 gap-4 xl:gap-5 mt-6 xl:mt-8">
                            
                            <!-- Total Laporan -->
                            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl p-4 shadow-sm hover:shadow-md transition">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="p-2 rounded-lg bg-emerald-100 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-300">
                                        <i class="fa-solid fa-file-lines text-base"></i>
                                    </div>
                                    <span class="text-2xl font-extrabold text-slate-900 dark:text-white">
                                        {{ $totalLaporan ?? 124 }}
                                    </span>
                                </div>
                                <div class="text-xs font-semibold text-slate-700 dark:text-slate-300">Total Laporan</div>
                                <div class="text-[11px] font-medium mt-1 text-emerald-600 dark:text-emerald-400">↑ 12% dari minggu lalu</div>
                            </div>

                            <!-- Terverifikasi -->
                            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl p-4 shadow-sm hover:shadow-md transition">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="p-2 rounded-lg bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300">
                                        <i class="fa-solid fa-shield-halved text-base"></i>
                                    </div>
                                    <span class="text-2xl font-extrabold text-slate-900 dark:text-white">
                                        {{ $totalTerverifikasi ?? 81 }}
                                    </span>
                                </div>
                                <div class="text-xs font-semibold text-slate-700 dark:text-slate-300">Terverifikasi</div>
                                <div class="text-[11px] font-medium mt-1 text-blue-600 dark:text-blue-400">● Selesai diverifikasi</div>
                            </div>

                            <!-- Dalam Perbaikan -->
                            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl p-4 shadow-sm hover:shadow-md transition">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="p-2 rounded-lg bg-amber-100 text-amber-700 dark:bg-amber-900/50 dark:text-amber-300">
                                        <i class="fa-solid fa-clock text-base"></i>
                                    </div>
                                    <span class="text-2xl font-extrabold text-slate-900 dark:text-white">
                                        {{ $totalDalamPerbaikan ?? 25 }}
                                    </span>
                                </div>
                                <div class="text-xs font-semibold text-slate-700 dark:text-slate-300">Dalam Perbaikan</div>
                                <div class="text-[11px] font-medium mt-1 text-amber-600 dark:text-amber-400">● Sedang ditindaklanjuti</div>
                            </div>

                            <!-- Selesai -->
                            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl p-4 shadow-sm hover:shadow-md transition">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="p-2 rounded-lg bg-emerald-100 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-300">
                                        <i class="fa-solid fa-circle-check text-base"></i>
                                    </div>
                                    <span class="text-2xl font-extrabold text-slate-900 dark:text-white">
                                        {{ $totalSelesai ?? 18 }}
                                    </span>
                                </div>
                                <div class="text-xs font-semibold text-slate-700 dark:text-slate-300">Selesai</div>
                                <div class="text-[11px] font-medium mt-1 text-emerald-600 dark:text-emerald-400">● Terkonfirmasi selesai</div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- CARA KERJA SMARTPATH SECTION -->
    <section id="panduan" class="py-16 md:py-20 bg-white dark:bg-slate-950 border-b border-slate-200 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-12 space-y-2">
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white">
                    Cara Kerja SmartPath
                </h2>
                <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400">
                    Empat langkah sederhana untuk berkontribusi memperbaiki aksesibilitas kota
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Step 1 -->
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 text-center shadow-sm hover:shadow-md transition flex flex-col items-center">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 flex items-center justify-center text-emerald-600 dark:text-emerald-400 mb-4">
                        <i class="fa-solid fa-camera text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Laporkan</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Unggah foto, pilih kategori hambatan, dan tandai lokasi pada peta
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 text-center shadow-sm hover:shadow-md transition flex flex-col items-center">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 flex items-center justify-center text-emerald-600 dark:text-emerald-400 mb-4">
                        <i class="fa-solid fa-circle-check text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Verifikasi</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Administrator memverifikasi dan mengelompokkan laporan duplikat
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 text-center shadow-sm hover:shadow-md transition flex flex-col items-center">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 flex items-center justify-center text-emerald-600 dark:text-emerald-400 mb-4">
                        <i class="fa-solid fa-chart-simple text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Prioritaskan</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Sistem menghitung skor prioritas secara otomatis berbasis aturan
                    </p>
                </div>

                <!-- Step 4 -->
                <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 text-center shadow-sm hover:shadow-md transition flex flex-col items-center">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 flex items-center justify-center text-emerald-600 dark:text-emerald-400 mb-4">
                        <i class="fa-solid fa-location-dot text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Petakan</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Hambatan divisualisasikan pada peta digital interaktif
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- LAPORAN PRIORITAS TINGGI & KATEGORI HAMBATAN -->
    <section class="py-16 md:py-20 bg-slate-50/70 dark:bg-slate-900/40">
        <div class="max-w-7xl xl:max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 xl:gap-10">
                
                <!-- Left 8 Cols: Laporan Prioritas Tinggi -->
                <div class="lg:col-span-8 space-y-6 xl:pr-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-bold text-slate-900 dark:text-white flex items-center space-x-2">
                                <i class="fa-solid fa-triangle-exclamation text-red-500"></i>
                                <span>Laporan Prioritas Tinggi</span>
                            </h2>
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                Laporan hambatan publik dengan kebutuhan penanganan paling mendesak
                            </p>
                        </div>
                    </div>

                    <!-- 3 Report Cards Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @forelse($laporanPrioritas as $item)
                            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition flex flex-col justify-between">
                                <!-- Card Image -->
                                <div class="relative">
                                    @php
                                        $fotoPath = $item->foto->first()?->foto_path ?? null;
                                        $imgUrl = $fotoPath ? asset('storage/' . $fotoPath) : 'https://images.unsplash.com/photo-1584467735871-8e85353a8413?auto=format&fit=crop&w=600&q=80';
                                        
                                        $prioritasLabel = $item->tingkat_prioritas ?? 'Tinggi';
                                        $badgeClass = match($prioritasLabel) {
                                            'Tinggi' => 'bg-red-100 text-red-800 border-red-300 dark:bg-red-950 dark:text-red-300',
                                            'Sedang' => 'bg-amber-100 text-amber-800 border-amber-300 dark:bg-amber-950 dark:text-amber-300',
                                            default => 'bg-emerald-100 text-emerald-800 border-emerald-300 dark:bg-emerald-950 dark:text-emerald-300',
                                        };
                                    @endphp
                                    <img src="{{ $imgUrl }}" alt="{{ $item->judul }}" class="w-full h-36 object-cover">
                                    <div class="absolute top-3 right-3">
                                        <span class="px-2.5 py-0.5 text-[11px] font-extrabold rounded-full border shadow-sm {{ $badgeClass }}">
                                            {{ $prioritasLabel }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Card Body -->
                                <div class="p-4 space-y-3 flex-1 flex flex-col justify-between">
                                    <div>
                                        <h3 class="font-bold text-slate-900 dark:text-white text-sm line-clamp-1">
                                            {{ $item->judul }}
                                        </h3>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 flex items-start space-x-1">
                                            <i class="fa-solid fa-location-dot text-slate-400 mt-0.5"></i>
                                            <span class="line-clamp-2">{{ $item->alamat_lengkap }}</span>
                                        </p>
                                    </div>

                                    <div class="flex items-center justify-between text-xs text-slate-600 dark:text-slate-300 font-medium pt-2 border-t border-slate-100 dark:border-slate-800">
                                        <span class="flex items-center space-x-1">
                                            <i class="fa-solid fa-users text-emerald-600"></i>
                                            <span>{{ $item->jumlah_pelapor ?? 1 }} pelapor</span>
                                        </span>
                                        <span class="flex items-center space-x-1">
                                            <i class="fa-solid fa-compass text-blue-500"></i>
                                            <span>{{ number_format($item->jarak_fasilitas_meter ?? 400, 0) }}m</span>
                                        </span>
                                    </div>
                                </div>

                                <!-- Card Footer -->
                                <div class="px-4 py-2.5 bg-slate-50 dark:bg-slate-800/60 border-t border-slate-200 dark:border-slate-800 flex items-center justify-between text-[11px] text-slate-500 dark:text-slate-400 font-mono">
                                    <span>{{ $item->kode_laporan }}</span>
                                    <span>{{ $item->created_at ? $item->created_at->translatedFormat('d M Y') : '16 Juli 2026' }}</span>
                                </div>
                            </div>
                        @empty
                            <!-- Static Demo Cards when database is empty -->
                            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm flex flex-col justify-between">
                                <div class="relative">
                                    <img src="https://images.unsplash.com/photo-1584467735871-8e85353a8413?auto=format&fit=crop&w=600&q=80" class="w-full h-36 object-cover">
                                    <div class="absolute top-3 right-3"><span class="px-2.5 py-0.5 text-[11px] font-extrabold rounded-full bg-red-100 text-red-800 border border-red-300">Tinggi</span></div>
                                </div>
                                <div class="p-4 space-y-3">
                                    <h3 class="font-bold text-slate-900 dark:text-white text-sm">Guiding Block Rusak</h3>
                                    <p class="text-xs text-slate-500">Jl. Margonda Raya No. 45, Pancoran Mas, Depok</p>
                                </div>
                                <div class="px-4 py-2.5 bg-slate-50 dark:bg-slate-800/60 border-t border-slate-200 dark:border-slate-800 flex justify-between text-[11px] font-mono text-slate-500">
                                    <span>LP-202607-00001</span><span>16 Juli 2026</span>
                                </div>
                            </div>

                            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm flex flex-col justify-between">
                                <div class="relative">
                                    <img src="https://images.unsplash.com/photo-1590674899484-d5640e854abe?auto=format&fit=crop&w=600&q=80" class="w-full h-36 object-cover">
                                    <div class="absolute top-3 right-3"><span class="px-2.5 py-0.5 text-[11px] font-extrabold rounded-full bg-amber-100 text-amber-800 border border-amber-300">Sedang</span></div>
                                </div>
                                <div class="p-4 space-y-3">
                                    <h3 class="font-bold text-slate-900 dark:text-white text-sm">Trotoar Terhalang Parkir</h3>
                                    <p class="text-xs text-slate-500">Jl. Juanda, Bekasi Timur, Depok</p>
                                </div>
                                <div class="px-4 py-2.5 bg-slate-50 dark:bg-slate-800/60 border-t border-slate-200 dark:border-slate-800 flex justify-between text-[11px] font-mono text-slate-500">
                                    <span>LP-202607-00002</span><span>16 Juli 2026</span>
                                </div>
                            </div>

                            <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden shadow-sm flex flex-col justify-between">
                                <div class="relative">
                                    <img src="https://images.unsplash.com/photo-1517649763962-0c623266ddc0?auto=format&fit=crop&w=600&q=80" class="w-full h-36 object-cover">
                                    <div class="absolute top-3 right-3"><span class="px-2.5 py-0.5 text-[11px] font-extrabold rounded-full bg-amber-100 text-amber-800 border border-amber-300">Sedang</span></div>
                                </div>
                                <div class="p-4 space-y-3">
                                    <h3 class="font-bold text-slate-900 dark:text-white text-sm">Ramp Tidak Layak</h3>
                                    <p class="text-xs text-slate-500">Jl. Raya Sawangan, Depok</p>
                                </div>
                                <div class="px-4 py-2.5 bg-slate-50 dark:bg-slate-800/60 border-t border-slate-200 dark:border-slate-800 flex justify-between text-[11px] font-mono text-slate-500">
                                    <span>LP-202607-00003</span><span>16 Juli 2026</span>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Right 4 Cols: Kategori Hambatan -->
                <div class="lg:col-span-4 space-y-6 xl:pl-2">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-slate-900 dark:text-white">Kategori Hambatan</h2>
                        <a href="{{ route('peta.index') }}" class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 hover:underline flex items-center space-x-1">
                            <span>Lihat semua</span>
                            <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        </a>
                    </div>

                    <div class="grid grid-cols-2 gap-3 xl:gap-4">
                        @forelse($kategoriHambatan as $kat)
                            <div class="min-h-[96px] p-3.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl hover:border-emerald-500 transition cursor-pointer flex flex-col justify-between space-y-2 shadow-sm">
                                <div class="flex items-center space-x-2">
                                    <span class="w-2 h-2 rounded-full bg-slate-800 dark:bg-slate-200"></span>
                                    <span class="font-bold text-xs text-slate-900 dark:text-slate-100 line-clamp-1">
                                        {{ $kat->nama ?? $kat->nama_kategori }}
                                    </span>
                                </div>
                                <div class="flex justify-start">
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300">
                                        {{ $kat->tingkat_keparahan ?? 'Aktif' }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="p-3.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl flex flex-col justify-between space-y-2">
                                <span class="font-bold text-xs text-slate-900 dark:text-slate-100">Guiding Block</span>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-red-100 text-red-700 w-fit">Tinggi</span>
                            </div>
                            <div class="p-3.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl flex flex-col justify-between space-y-2">
                                <span class="font-bold text-xs text-slate-900 dark:text-slate-100">Trotoar</span>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-amber-100 text-amber-700 w-fit">Sedang</span>
                            </div>
                            <div class="p-3.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl flex flex-col justify-between space-y-2">
                                <span class="font-bold text-xs text-slate-900 dark:text-slate-100">Ramp Akses</span>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-amber-100 text-amber-700 w-fit">Sedang</span>
                            </div>
                            <div class="p-3.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl flex flex-col justify-between space-y-2">
                                <span class="font-bold text-xs text-slate-900 dark:text-slate-100">Penyeberangan</span>
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-emerald-100 text-emerald-700 w-fit">Rendah</span>
                            </div>
                        @endforelse
                    </div>

                    <div class="p-5 bg-emerald-900 text-emerald-50 rounded-2xl border border-emerald-800 space-y-3">
                        <div class="flex items-center space-x-2 font-bold text-sm">
                            <i class="fa-solid fa-shield-halved text-emerald-400"></i>
                            <span>Sistem Prioritas Otomatis</span>
                        </div>
                        <p class="text-xs text-emerald-200 leading-relaxed">
                            SmartPath menggunakan algoritma scoring terbobot berbasis jumlah pelapor, tingkat keparahan, dan kedekatan dengan fasilitas publik vital.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- FOOTER SECTION -->
    <footer id="tentang" class="bg-slate-900 text-slate-300 py-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 pb-12 border-b border-slate-800">
                
                <!-- Brand Info -->
                <div class="md:col-span-4 space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-bold text-lg">
                            <i class="fa-solid fa-gear"></i>
                        </div>
                        <div>
                            <div class="text-lg font-bold text-white tracking-tight">SmartPath</div>
                            <div class="text-xs text-slate-400">Aksesibilitas untuk Semua</div>
                        </div>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed max-w-sm">
                        SmartPath adalah platform pemetaan aksesibilitas infrastruktur publik untuk mendukung kota yang inklusif.
                    </p>
                    <div class="flex items-center space-x-3 pt-2">
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:text-white hover:bg-emerald-600 transition"><i class="fa-brands fa-instagram text-xs"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:text-white hover:bg-emerald-600 transition"><i class="fa-brands fa-x-twitter text-xs"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:text-white hover:bg-emerald-600 transition"><i class="fa-brands fa-facebook text-xs"></i></a>
                        <a href="#" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 hover:text-white hover:bg-emerald-600 transition"><i class="fa-brands fa-youtube text-xs"></i></a>
                    </div>
                </div>

                <!-- Footer Links -->
                <div class="md:col-span-2 space-y-3">
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider">Platform</h4>
                    <ul class="space-y-2 text-xs text-slate-400">
                        <li><a href="{{ route('peta.index') }}" class="hover:text-emerald-400 transition">Peta Interaktif</a></li>
                        <li><a href="{{ auth()->check() ? route('laporan.create') : route('login') }}" class="hover:text-emerald-400 transition">Laporkan Hambatan</a></li>
                        <li><a href="{{ Route::has('laporan.index') ? route('laporan.index') : '#laporan' }}" class="hover:text-emerald-400 transition">Laporan Saya</a></li>
                    </ul>
                </div>

                <div class="md:col-span-2 space-y-3">
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider">Informasi</h4>
                    <ul class="space-y-2 text-xs text-slate-400">
                        <li><a href="#tentang" class="hover:text-emerald-400 transition">Tentang Kami</a></li>
                        <li><a href="#panduan" class="hover:text-emerald-400 transition">Panduan Penggunaan</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition">Kebijakan Privasi</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition">Syarat & Ketentuan</a></li>
                    </ul>
                </div>

                <div class="md:col-span-2 space-y-3">
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider">Bantuan</h4>
                    <ul class="space-y-2 text-xs text-slate-400">
                        <li><a href="#" class="hover:text-emerald-400 transition">FAQ</a></li>
                        <li><a href="#" class="hover:text-emerald-400 transition">Hubungi Kami</a></li>
                    </ul>
                </div>

                <!-- Newsletter Subscribe Form -->
                <div class="md:col-span-2 space-y-3">
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider">Dapatkan Informasi Terbaru</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Berlangganan newsletter untuk mendapatkan update terbaru.
                    </p>

                    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-2">
                        @csrf
                        <div class="relative">
                            <input 
                                type="email" 
                                name="email"
                                placeholder="Masukkan email Anda" 
                                required
                                class="w-full pl-3 pr-10 py-2 text-xs bg-slate-800 border border-slate-700 rounded-lg text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500"
                            >
                            <button 
                                type="submit" 
                                class="absolute right-1 top-1 bottom-1 px-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-md flex items-center justify-center transition"
                            >
                                <i class="fa-solid fa-paper-plane text-xs"></i>
                            </button>
                        </div>
                    </form>
                </div>

            </div>

            <!-- Bottom Copyright -->
            <div class="pt-8 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-500">
                <div>© 2026 SmartPath. All rights reserved.</div>
                <div class="mt-2 sm:mt-0">Dikembangkan untuk Lomba Application Development Tahap Final</div>
            </div>
        </div>
    </footer>

    <!-- Dark Mode Toggle Script -->
    <script>
        const themeToggleBtn = document.getElementById('themeToggleBtn');
        const themeToggleIcon = document.getElementById('themeToggleIcon');

        // Check Local Storage / System Preference
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
            themeToggleIcon.classList.remove('fa-moon');
            themeToggleIcon.classList.add('fa-sun');
        } else {
            document.documentElement.classList.remove('dark');
            themeToggleIcon.classList.remove('fa-sun');
            themeToggleIcon.classList.add('fa-moon');
        }

        themeToggleBtn.addEventListener('click', () => {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
                themeToggleIcon.classList.remove('fa-sun');
                themeToggleIcon.classList.add('fa-moon');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
                themeToggleIcon.classList.remove('fa-moon');
                themeToggleIcon.classList.add('fa-sun');
            }
        });
    </script>
</body>
</html>