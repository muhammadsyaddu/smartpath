<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartPath - Kota yang Lebih Aksesibel</title>
    <meta name="description" content="SmartPath adalah platform partisipatif untuk melaporkan dan memetakan hambatan aksesibilitas di ruang publik.">

    <!-- Font Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    },
                    colors: {
                        emerald: {
                            50:'#ecfdf5',100:'#d1fae5',200:'#a7f3d0',300:'#6ee7b7',
                            400:'#34d399',500:'#10b981',600:'#059669',700:'#047857',
                            800:'#065f46',900:'#064e3b',950:'#022c22'
                        }
                    }
                }
            }
        }
    </script>

    <style>
        /* ===== RESET & BASE ===== */
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            color: #172033;
            background: #f8fafc;
            transition: background 0.3s ease, color 0.3s ease;
        }
        html.dark body {
            background: #0f172a;
            color: #f1f5f9;
        }

        /* ===== SKIP LINK ===== */
        .skip-link {
            position: absolute;
            top: -9999px;
            left: 50%;
            transform: translateX(-50%);
            background: #059669;
            color: #ffffff;
            padding: 12px 24px;
            border-radius: 8px;
            z-index: 9999;
            font-weight: 600;
            transition: top 0.3s;
        }
        .skip-link:focus {
            top: 16px;
        }

        /* ===== SCROLL PROGRESS BAR ===== */
        .scroll-progress {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(90deg, #10b981, #059669, #34d399);
            z-index: 99999;
            width: 0%;
            transition: width 0.1s ease;
        }

        /* ===== FIX ANCHOR SCROLL (AGAR TIDAK TERTUTUP HEADER) ===== */
        .section-anchor {
            scroll-margin-top: 100px;
        }

        /* ===== HERO ===== */
        .hero {
            background: linear-gradient(90deg, rgba(0,45,37,.98) 0%, rgba(0,54,45,.95) 45%, rgba(0,45,37,.78) 100%);
        }
        html.dark .hero {
            background: linear-gradient(90deg, rgba(2,8,23,.98) 0%, rgba(4,20,30,.95) 45%, rgba(2,8,23,.78) 100%);
        }

        .hero-photo {
            background-image: url('{{ asset('foto-tunanetra.png') }}');
            background-size: cover;
            background-position: center;
            opacity: .17;
        }

        .hero-glow {
            background: radial-gradient(circle, rgba(16,185,129,.18), transparent 65%);
        }

        .map-shell {
            background: rgba(9,25,36,.76);
            border: 1px solid rgba(16,185,129,.75);
            box-shadow: 0 25px 80px rgba(0,0,0,.35);
        }

        #smartpath-map .leaflet-tile {
            filter: brightness(.42) saturate(.65) contrast(1.12);
        }

        #smartpath-map .leaflet-control-zoom {
            display: none;
        }

        .map-report {
            position: absolute;
            z-index: 1000;
            left: 50%;
            bottom: 28px;
            transform: translateX(-50%);
            width: 82%;
            max-width: 320px;
            background: #fff;
            border-radius: 12px;
            padding: 9px;
            box-shadow: 0 18px 45px rgba(0,0,0,.32);
            display: flex;
            gap: 10px;
            align-items: center;
        }
        html.dark .map-report {
            background: #1e293b;
        }

        .map-report img {
            width: 76px;
            height: 66px;
            border-radius: 8px;
            object-fit: cover;
        }

        .status {
            display: inline-flex;
            align-items: center;
            padding: 3px 8px;
            border-radius: 999px;
            font-size: 9px;
            font-weight: 700;
            background: #fef3c7;
            color: #d97706;
        }
        .dark .status {
            background: #f59e0b30;
            color: #f59e0b;
        }

        /* ===== FEATURE CARDS ===== */
        .feature-card {
            background: #fff;
            border: 1px solid #eef2f7;
            border-radius: 13px;
            box-shadow: 0 8px 25px rgba(15,23,42,.05);
            transition: all 0.3s cubic-bezier(0.22, 1, 0.36, 1);
        }
        html.dark .feature-card {
            background: #1e293b;
            border-color: #334155;
        }
        .feature-card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 18px 35px rgba(15,23,42,.10);
        }

        .icon-circle {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg,#e6f7ed,#d9f3e7);
            color: #059669;
            font-size: 22px;
        }
        html.dark .icon-circle {
            background: linear-gradient(135deg,#064e3b,#065f46);
            color: #34d399;
        }

        /* ===== STATS ===== */
        .stats-box {
            background: linear-gradient(135deg,#243545,#1c2b39);
            border-radius: 12px;
            box-shadow: 0 14px 35px rgba(15,23,42,.10);
        }
        html.dark .stats-box {
            background: linear-gradient(135deg,#0f172a,#1e293b);
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,.10);
            color: #fff;
            font-size: 21px;
        }

        /* ===== STEPS ===== */
        .step-icon {
            width: 62px;
            height: 62px;
            border-radius: 50%;
            background: linear-gradient(135deg,#e6f8f1,#d8f2ee);
            color: #087f6d;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin: 0 auto 15px;
            position: relative;
            z-index: 2;
        }
        html.dark .step-icon {
            background: linear-gradient(135deg,#064e3b,#065f46);
            color: #34d399;
        }

        .step-number {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translate(-50%,-12px);
            width: 23px;
            height: 23px;
            border-radius: 50%;
            background: #10b981;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 800;
            z-index: 3;
        }

        .steps-line {
            position: absolute;
            top: 31px;
            left: 12%;
            right: 12%;
            height: 1px;
            border-top: 1px dashed #72cdbd;
        }

        /* ===== CTA ===== */
        .cta-mini {
            background: linear-gradient(145deg,#004b40,#003c35);
            border-radius: 12px;
        }
        html.dark .cta-mini {
            background: linear-gradient(145deg,#022c22,#064e3b);
        }

        /* ===== FOOTER ===== */
        .footer {
            background: #0d1f2b;
            color: #cbd5df;
        }
        html.dark .footer {
            background: #020617;
            color: #94a3b8;
        }

        .footer-divider {
            border-color: rgba(255,255,255,.10);
        }
        html.dark .footer-divider {
            border-color: rgba(255,255,255,.05);
        }

        /* ===== SCROLLBAR ===== */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { 
            background: linear-gradient(180deg, #10b981, #059669);
            border-radius: 4px;
        }
        html.dark ::-webkit-scrollbar-track { background: #1e293b; }
        html.dark ::-webkit-scrollbar-thumb { 
            background: linear-gradient(180deg, #34d399, #10b981);
        }

        /* ===== ANIMASI ===== */
        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s cubic-bezier(0.22, 1, 0.36, 1);
        }
        .animate-on-scroll.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1023px) {
            .steps-line { display:none; }
            .mobile-menu { display: none; }
            .mobile-menu.open { display: block; }
        }

        /* ===== SMARTPATH PROFESSIONAL UI REFINEMENT ===== */
        :root {
            --sp-primary: #10b981;
            --sp-primary-dark: #047857;
            --sp-ink: #0f2f2b;
            --sp-muted: #64748b;
            --sp-border: rgba(15, 23, 42, .08);
        }

        html { scroll-behavior: smooth; }

        body {
            letter-spacing: -0.01em;
            -webkit-font-smoothing: antialiased;
        }

        .hero {
            min-height: 610px;
            background:
                radial-gradient(circle at 78% 35%, rgba(16,185,129,.16), transparent 30%),
                linear-gradient(115deg, #032f29 0%, #063d35 52%, #082e2a 100%);
        }

        .hero-photo { opacity: .13; }

        .hero-grid {
            position: relative;
        }

        .hero-copy {
            max-width: 590px;
        }

        .hero-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 12px;
            border-radius: 999px;
            background: rgba(16,185,129,.10);
            border: 1px solid rgba(110,231,183,.22);
            color: #a7f3d0;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .02em;
        }

        .hero-title {
            font-size: clamp(2.7rem, 5vw, 4.2rem);
            line-height: .99;
            letter-spacing: -.045em;
        }

        .hero-subtitle {
            max-width: 560px;
            font-size: 15px;
            line-height: 1.8;
            color: rgba(236,253,245,.78);
        }

        .hero-trust {
            display: flex;
            flex-wrap: wrap;
            gap: 12px 22px;
            margin-top: 28px;
        }

        .hero-trust span {
            color: rgba(236,253,245,.82);
            font-size: 11px;
            font-weight: 600;
        }

        .hero-trust i { color: #34d399; margin-right: 7px; }

        .map-shell {
            padding: 10px;
            border-radius: 22px;
            background: rgba(2, 20, 25, .72);
            border: 1px solid rgba(110,231,183,.28);
            box-shadow: 0 30px 90px rgba(0,0,0,.32), inset 0 1px 0 rgba(255,255,255,.06);
        }

        .map-shell::before {
            content: "LIVE ACCESSIBILITY MAP";
            display: block;
            padding: 3px 4px 9px;
            color: rgba(167,243,208,.7);
            font-size: 8px;
            font-weight: 800;
            letter-spacing: .16em;
        }

        #smartpath-map { height: 350px !important; }

        .map-report {
            width: min(86%, 340px);
            bottom: 20px;
            border: 1px solid rgba(15,23,42,.06);
            border-radius: 14px;
        }

        .section-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .16em;
            color: #059669;
        }

        .section-label::before {
            content: "";
            width: 22px;
            height: 2px;
            border-radius: 999px;
            background: #10b981;
        }

        .section-title {
            font-size: clamp(1.75rem, 3vw, 2.45rem);
            line-height: 1.12;
            letter-spacing: -.035em;
        }

        .section-lead {
            color: #64748b;
            font-size: 13px;
            line-height: 1.8;
        }

        .dark .section-lead { color: #94a3b8; }

        .about-hero {
            position: relative;
            overflow: hidden;
            background:
                radial-gradient(circle at 75% 20%, rgba(16,185,129,.12), transparent 28%),
                linear-gradient(135deg, #062a25 0%, #0a3a33 100%);
        }

        .about-hero::after {
            content: "";
            position: absolute;
            width: 280px;
            height: 280px;
            right: -100px;
            bottom: -140px;
            border: 1px solid rgba(110,231,183,.16);
            border-radius: 50%;
            box-shadow: 0 0 0 35px rgba(110,231,183,.03), 0 0 0 70px rgba(110,231,183,.02);
        }

        .about-image {
            border-radius: 22px;
            border: 1px solid rgba(255,255,255,.12);
            box-shadow: 0 28px 70px rgba(0,0,0,.28);
        }

        .about-stat {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 14px;
            background: rgba(255,255,255,.94);
            box-shadow: 0 18px 45px rgba(0,0,0,.18);
        }

        .dark .about-stat { background: #1e293b; }

        .about-stat-icon {
            width: 38px;
            height: 38px;
            border-radius: 11px;
            display: grid;
            place-items: center;
            background: #ecfdf5;
            color: #059669;
        }

        .feature-card {
            border-radius: 18px;
            padding: 24px;
            box-shadow: 0 10px 35px rgba(15,23,42,.045);
        }

        .feature-card:hover {
            transform: translateY(-6px);
            border-color: rgba(16,185,129,.22);
            box-shadow: 0 22px 45px rgba(15,23,42,.09);
        }

        .icon-circle {
            width: 50px;
            height: 50px;
            border-radius: 14px;
        }

        .problem-card {
            border: 1px solid #eef2f7;
            border-radius: 16px;
            background: #fff;
            padding: 17px;
            transition: .25s ease;
        }

        .problem-card:hover {
            transform: translateX(4px);
            border-color: rgba(16,185,129,.25);
            box-shadow: 0 14px 30px rgba(15,23,42,.06);
        }

        .dark .problem-card {
            background: #111c2d;
            border-color: #263449;
        }

        .vision-panel {
            position: relative;
            overflow: hidden;
            border-radius: 22px;
            background: #fff;
            border: 1px solid #e8edf2;
            box-shadow: 0 16px 45px rgba(15,23,42,.06);
        }

        .dark .vision-panel {
            background: #111c2d;
            border-color: #263449;
        }

        .metric {
            padding: 14px;
            border-radius: 14px;
            background: #f8fafc;
            border: 1px solid #edf2f7;
        }

        .dark .metric {
            background: #172235;
            border-color: #29374a;
        }

        .step-item {
            position: relative;
            padding: 20px 14px;
            border-radius: 18px;
            border: 1px solid #edf2f7;
            background: #fff;
            transition: .25s ease;
        }

        .dark .step-item {
            background: #111c2d;
            border-color: #263449;
        }

        .step-item:hover {
            transform: translateY(-4px);
            box-shadow: 0 18px 38px rgba(15,23,42,.07);
        }

        .cta-professional {
            border-radius: 24px;
            background:
                radial-gradient(circle at 90% 10%, rgba(52,211,153,.24), transparent 26%),
                linear-gradient(120deg, #063b34, #087f6d);
            box-shadow: 0 25px 65px rgba(4,120,87,.18);
        }

        @media (max-width: 767px) {
            .hero { min-height: auto; }
            #smartpath-map { height: 290px !important; }
            .hero-title { font-size: 2.65rem; }
            .hero-subtitle { font-size: 13px; line-height: 1.7; }
        }

    </style>
</head>

<body>

    <!-- ===== SKIP LINK ===== -->
    <a href="#main-content" class="skip-link">Langsung ke konten utama</a>

    <!-- ===== SCROLL PROGRESS ===== -->
    <div class="scroll-progress" id="scrollProgress"></div>

    <!-- ===== NAVBAR ===== -->
    <header class="sticky top-0 z-50 bg-[#062a25]/95 dark:bg-[#020617]/95 backdrop-blur-md border-b border-white/10">
        <div class="max-w-[1180px] mx-auto px-6 h-16 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-3 text-white">
                <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-emerald-400 to-emerald-700 flex items-center justify-center">
                    <i class="fa-solid fa-route"></i>
                </div>
                <span class="text-xl font-extrabold tracking-tight">SmartPath</span>
            </a>

          <nav class="hidden lg:flex items-center gap-8 text-[12px]">
    <!-- Beranda -->
    <a href="{{ url('/') }}" class="nav-link {{ request()->routeIs('landing') ? 'text-white border-b-2 border-emerald-400 pb-5' : 'text-slate-300 hover:text-white transition' }}">Beranda</a>
    
    <!-- Tentang -->
    <a href="{{ route('tentang') }}" class="nav-link {{ request()->routeIs('tentang') ? 'text-white border-b-2 border-emerald-400 pb-5' : 'text-slate-300 hover:text-white transition' }}">Tentang</a>
    
    <!-- Fitur (Kembali ke Beranda bagian #fitur) -->
    <a href="{{ url('/#fitur') }}" class="nav-link text-slate-300 hover:text-white transition">Fitur</a>
    
    <!-- Peta (Halaman terpisah - sesuai kode Anda) -->
    <a href="{{ route('peta.fasilitas') }}" class="nav-link text-slate-300 hover:text-white transition">Peta</a>
    
    <!-- Cara Kerja (Kembali ke Beranda bagian #cara-kerja) -->
    <a href="{{ url('/#cara-kerja') }}" class="nav-link text-slate-300 hover:text-white transition">Cara Kerja</a>
    
    <!-- Kontak (Kembali ke Beranda bagian #kontak) -->
    <a href="{{ url('/#kontak') }}" class="nav-link text-slate-300 hover:text-white transition">Kontak</a>
</nav>

            <div class="flex items-center gap-3">
                <div class="hidden sm:flex items-center gap-2">
                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-xl border border-white/20 bg-white/5 px-5 py-2.5 text-sm font-semibold text-white backdrop-blur-sm transition-all duration-300 hover:bg-white/10 hover:border-emerald-400/50 hover:text-emerald-300">Masuk</a>
                    <a href="{{ route('auth.register') }}" class="inline-flex items-center justify-center rounded-xl bg-emerald-600 hover:bg-emerald-500 px-5 py-2.5 text-sm font-bold text-white transition-all duration-300 hover:scale-105">Daftar</a>
                    <button id="themeToggle" type="button" class="w-11 h-11 rounded-xl border border-white/20 bg-white/5 text-white backdrop-blur-sm transition-all duration-300 hover:bg-white/10 hover:border-emerald-400/50 hover:text-emerald-300">
                        <i id="themeIcon" class="fa-solid fa-moon"></i>
                    </button>
                </div>
                <button id="mobileMenuBtn" type="button" class="lg:hidden text-white text-xl" aria-label="Buka menu">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>

       <div id="mobileMenu" class="lg:hidden mobile-menu bg-[#062a25]/95 dark:bg-[#020617]/95 px-6 py-4 border-t border-white/10">
    <nav class="flex flex-col space-y-3 text-[14px]">
        <a href="{{ url('/') }}" class="{{ request()->routeIs('landing') ? 'text-white font-semibold' : 'text-slate-300 hover:text-white transition' }}">Beranda</a>
        <a href="{{ route('tentang') }}" class="{{ request()->routeIs('tentang') ? 'text-white font-semibold' : 'text-slate-300 hover:text-white transition' }}">Tentang</a>
        <a href="{{ url('/#fitur') }}" class="text-slate-300 hover:text-white transition">Fitur</a>
        <a href="{{ route('peta.fasilitas') }}" class="text-slate-300 hover:text-white transition">Peta</a>
        <a href="{{ url('/#cara-kerja') }}" class="text-slate-300 hover:text-white transition">Cara Kerja</a>
        <a href="{{ url('/#kontak') }}" class="text-slate-300 hover:text-white transition">Kontak</a>
    </nav>
</div>
    </header>

    <!-- ===== MAIN CONTENT ===== -->
    <main id="main-content">

        <!-- ===== TENTANG SMARTPATH (HERO) ===== -->
     <main id="main-content">

    <!-- ===== TENTANG SMARTPATH (HERO) ===== -->
    <section id="tentang" class="about-hero relative py-16 lg:py-24 section-anchor">
        <div class="max-w-[1180px] mx-auto px-6 relative z-10">
            <div class="grid lg:grid-cols-[.9fr_1.1fr] gap-12 lg:gap-16 items-center">
                <div class="text-white">
                    <span class="section-label text-emerald-300">Tentang SmartPath</span>
                    <h2 class="section-title text-white mt-4">
                        Teknologi untuk ruang publik yang
                        <span class="text-emerald-400">lebih inklusif.</span>
                    </h2>

                    <!-- Paragraf lebih pendek & padat -->
                    <p class="mt-5 text-sm leading-7 text-emerald-50/75 max-w-xl">
                        Bayangkan jika Anda harus melewati trotoar rusak dengan kursi roda. <strong class="text-emerald-200">Aksesibilitas bukan hanya untuk penyandang disabilitas</strong>—itu untuk semua orang, termasuk lansia dan ibu hamil.
                    </p>
                    <p class="mt-3 text-sm leading-7 text-emerald-50/75 max-w-xl">
                        SmartPath adalah <strong class="text-emerald-200">jembatan gotong royong</strong> antara warga dan pemerintah untuk memperbaiki infrastruktur tepat sasaran.
                    </p>

                    <div class="grid sm:grid-cols-2 gap-3 mt-8">
                        <!-- Card Partisipatif -->
                        <div class="flex items-start gap-3 p-4 rounded-2xl bg-white/5 border border-white/10">
                            <div class="w-10 h-10 rounded-xl bg-emerald-500/15 text-emerald-300 grid place-items-center shrink-0">
                                <i class="fa-solid fa-users"></i>
                            </div>
                            <div>
                                <p class="font-bold text-sm text-white">Partisipatif</p>
                                <p class="text-[11px] text-emerald-50/60 mt-1 leading-5">Masyarakat ikut menyampaikan kondisi di lapangan.</p>
                            </div>
                        </div>
                        <!-- Card Berbasis Peta -->
                        <div class="flex items-start gap-3 p-4 rounded-2xl bg-white/5 border border-white/10">
                            <div class="w-10 h-10 rounded-xl bg-emerald-500/15 text-emerald-300 grid place-items-center shrink-0">
                                <i class="fa-solid fa-map-location-dot"></i>
                            </div>
                            <div>
                                <p class="font-bold text-sm text-white">Berbasis Peta</p>
                                <p class="text-[11px] text-emerald-50/60 mt-1 leading-5">Laporan divisualisasikan agar mudah dipantau.</p>
                            </div>
                        </div>
                        <!-- Card Berbasis Data (Baru) -->
                        <div class="flex items-start gap-3 p-4 rounded-2xl bg-white/5 border border-white/10 sm:col-span-2">
                            <div class="w-10 h-10 rounded-xl bg-emerald-500/15 text-emerald-300 grid place-items-center shrink-0">
                                <i class="fa-solid fa-database"></i>
                            </div>
                            <div>
                                <p class="font-bold text-sm text-white">Berbasis Data</p>
                                <p class="text-[11px] text-emerald-50/60 mt-1 leading-5">Laporan terverifikasi menjadi data prioritas perbaikan yang akurat.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div class="about-image overflow-hidden bg-slate-900">
                        <img src="{{ asset('foto-tunanetra.png') }}" alt="Ilustrasi aksesibilitas ruang publik" class="w-full h-[360px] object-cover opacity-90">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#062a25]/90 via-transparent to-transparent"></div>

                        <!-- Overlay Data SmartPath pada Gambar -->
                        <div class="absolute top-4 left-4 right-4 flex justify-between gap-3">
                            <div class="bg-emerald-400 text-emerald-950 rounded-xl px-3 py-2 shadow-lg">
                                <p class="text-lg font-extrabold leading-none">1.245</p>
                                <p class="text-[9px] font-bold mt-1">Laporan Masuk</p>
                            </div>
                            <div class="bg-white/90 backdrop-blur rounded-xl px-3 py-2 shadow-lg">
                                <p class="text-lg font-extrabold text-slate-800 leading-none">876</p>
                                <p class="text-[9px] font-bold text-slate-500 mt-1">Terverifikasi</p>
                            </div>
                        </div>

                        <div class="absolute left-5 right-5 bottom-5">
                            <div class="about-stat">
                                <div class="about-stat-icon">
                                    <i class="fa-solid fa-heart-pulse"></i>
                                </div>
                                <div>
                                    <p class="text-slate-900 dark:text-white font-extrabold text-sm">Setiap jalan berhak untuk semua orang</p>
                                    <p class="text-slate-500 dark:text-slate-400 text-[11px] mt-1">Mendorong kota yang aman, mudah diakses, dan inklusif.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="absolute -top-4 -right-4 hidden sm:flex items-center gap-2 rounded-2xl bg-emerald-400 text-emerald-950 px-4 py-3 shadow-xl">
                        <i class="fa-solid fa-universal-access"></i>
                        <span class="text-xs font-extrabold">Akses untuk semua</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== MASALAH ===== -->
    <section id="masalah" class="py-12 bg-white dark:bg-slate-950 section-anchor">
        <div class="max-w-[1180px] mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="text-emerald-600 dark:text-emerald-400 text-[10px] font-bold uppercase tracking-widest">Masalah</span>
                <h2 class="text-2xl font-extrabold text-slate-800 dark:text-white mt-2">Masih banyak hambatan di ruang publik</h2>
                <!-- Paragraf lebih pendek -->
                <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed mt-4">
                    Trotoar rusak, ramp hilang, atau guiding block terputus membatasi mobilitas semua orang. Saat seorang ayah mengangkat kereta bayi atau kakek takut keluar rumah, itulah kegagalan infrastruktur publik.
                </p>
            </div>
            <div class="space-y-4">
                <div class="problem-card flex items-start gap-4">
                    <div class="w-10 h-10 shrink-0 rounded-full bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400"><i class="fa-solid fa-road"></i></div>
                    <div>
                        <h3 class="font-bold text-slate-800 dark:text-white text-sm">Infrastruktur tidak ramah</h3>
                        <p class="text-slate-500 dark:text-slate-400 text-xs mt-1 leading-relaxed">Banyak fasilitas publik belum memenuhi standar aksesibilitas.</p>
                    </div>
                </div>
                <div class="problem-card flex items-start gap-4">
                    <div class="w-10 h-10 shrink-0 rounded-full bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400"><i class="fa-solid fa-eye"></i></div>
                    <div>
                        <h3 class="font-bold text-slate-800 dark:text-white text-sm">Informasi tidak terpusat</h3>
                        <p class="text-slate-500 dark:text-slate-400 text-xs mt-1 leading-relaxed">Data hambatan tidak terdokumentasi dengan baik.</p>
                    </div>
                </div>
                <div class="problem-card flex items-start gap-4">
                    <div class="w-10 h-10 shrink-0 rounded-full bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400"><i class="fa-solid fa-chart-column"></i></div>
                    <div>
                        <h3 class="font-bold text-slate-800 dark:text-white text-sm">Perbaikan tidak tepat sasaran</h3>
                        <p class="text-slate-500 dark:text-slate-400 text-xs mt-1 leading-relaxed">Pemerintah kesulitan menentukan prioritas tanpa data lapangan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== SOLUSI KAMI ===== -->
    <section id="solusi" class="py-12 bg-white dark:bg-slate-950 section-anchor">
        <div class="max-w-[1180px] mx-auto px-6 text-center">
            <span class="section-label">Solusi Kami</span>
            <h2 class="section-title text-slate-800 dark:text-white mt-3">Apa itu SmartPath?</h2>
            <!-- Paragraf lebih pendek -->
            <p class="section-lead mt-4 max-w-2xl mx-auto">
                SmartPath mengubah laporan warga menjadi data terstruktur untuk perbaikan yang tepat sasaran.
            </p>
            <div class="grid sm:grid-cols-3 gap-4 mt-10 text-left">
                <div class="feature-card p-6 animate-on-scroll">
                    <div class="icon-circle mb-4"><i class="fa-solid fa-file-pen"></i></div>
                    <h3 class="text-[12px] font-bold text-slate-800 dark:text-white">Laporkan</h3>
                    <p class="mt-2 text-[10px] leading-5 text-slate-500 dark:text-slate-400">Masyarakat dapat melaporkan hambatan aksesibilitas di sekitar mereka dengan mudah.</p>
                </div>
                <div class="feature-card p-6 animate-on-scroll">
                    <div class="icon-circle mb-4"><i class="fa-solid fa-map-location-dot"></i></div>
                    <h3 class="text-[12px] font-bold text-slate-800 dark:text-white">Petakan</h3>
                    <p class="mt-2 text-[10px] leading-5 text-slate-500 dark:text-slate-400">Laporan divisualisasikan pada peta interaktif agar mudah dipantau.</p>
                </div>
                <div class="feature-card p-6 animate-on-scroll">
                    <div class="icon-circle mb-4"><i class="fa-solid fa-shield-halved"></i></div>
                    <h3 class="text-[12px] font-bold text-slate-800 dark:text-white">Verifikasi & Prioritaskan</h3>
                    <p class="mt-2 text-[10px] leading-5 text-slate-500 dark:text-slate-400">Laporan diverifikasi dan ditindaklanjuti secara tepat sasaran.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== VISI KAMI ===== -->
    <section id="visi" class="py-16 lg:py-20 bg-slate-50 dark:bg-slate-900 section-anchor">
        <div class="max-w-[1180px] mx-auto px-6">
            <div class="vision-panel p-5 sm:p-7 lg:p-8">
                <div class="grid lg:grid-cols-[.95fr_1.05fr] gap-9 lg:gap-12 items-center">
                    <div class="overflow-hidden rounded-2xl">
                        <img src="{{ asset('trotoar-depok.jpg') }}" alt="Contoh aksesibilitas ruang publik" class="w-full h-[320px] object-cover">
                    </div>
                    <div>
                        <span class="section-label">Visi Kami</span>
                        <h2 class="section-title text-slate-800 dark:text-white mt-3">Dampak yang ingin kami wujudkan</h2>
                        <!-- Paragraf lebih pendek, tetap manusiawi -->
                        <p class="section-lead mt-4">
                            Di balik angka <strong class="text-slate-700 dark:text-white">17,8 juta</strong> penyandang disabilitas, ada potensi yang terhalang infrastruktur. Kami membuka jalan agar semua orang bisa bergerak bebas.
                        </p>
                        <div class="grid sm:grid-cols-2 gap-3 mt-7">
                            <div class="metric">
                                <p class="text-lg font-extrabold text-slate-800 dark:text-white">17,8 juta</p>
                                <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-1">Penyandang disabilitas di Indonesia (BPS 2024)</p>
                            </div>
                            <div class="metric">
                                <p class="text-lg font-extrabold text-slate-800 dark:text-white">23,04%</p>
                                <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-1">Partisipasi angkatan kerja penyandang disabilitas</p>
                            </div>
                            <div class="metric">
                                <p class="text-lg font-extrabold text-slate-800 dark:text-white">Lebih inklusif</p>
                                <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-1">Ruang publik untuk semua orang</p>
                            </div>
                            <div class="metric">
                                <p class="text-lg font-extrabold text-slate-800 dark:text-white">Berkelanjutan</p>
                                <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-1">Perbaikan yang tepat guna dan efisien</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CTA ===== -->
    <section id="cta" class="py-10 bg-slate-50 dark:bg-slate-900">
        <div class="max-w-[1180px] mx-auto px-6">
            <div class="cta-professional p-8 lg:p-10 flex flex-col md:flex-row justify-between items-center gap-6 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                <h2 class="text-white text-2xl font-extrabold text-center md:text-left relative z-10">
                    Mari bersama-sama ciptakan kota<br class="hidden md:block"> yang lebih inklusif & aksesibel!
                </h2>
                <a href="{{ route('laporan.create') }}" class="relative z-10 bg-white text-emerald-700 px-6 py-3 rounded-lg font-bold hover:bg-slate-100 transition shadow-lg">
                    Laporkan Sekarang
                </a>
            </div>
        </div>
    </section>

    <!-- ===== CARA KERJA ===== -->
    <section id="cara-kerja" class="py-16 lg:py-20 bg-white dark:bg-slate-950 section-anchor">
        <div class="max-w-[1180px] mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto">
                <span class="section-label">Cara Kerja</span>
                <h2 class="section-title text-slate-800 dark:text-white mt-3">Bersama dalam 4 Langkah Mudah</h2>
                <p class="section-lead mt-4">
                    Laporkan hambatan aksesibilitas dengan mudah hingga mendapatkan tindak lanjut.
                </p>
            </div>
            <div class="relative grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mt-12">
                <div class="hidden lg:block absolute top-[45px] left-[12%] right-[12%] border-t-2 border-dashed border-emerald-200 dark:border-emerald-900 z-0"></div>
                <div class="step-item text-center relative z-10">
                    <div class="step-icon"><span class="step-number">1</span><i class="fa-solid fa-file-circle-plus"></i></div>
                    <h3 class="text-sm font-bold text-slate-800 dark:text-white">Laporkan</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-2 leading-relaxed">Isi formulir dan unggah foto hambatan.</p>
                </div>
                <div class="step-item text-center relative z-10">
                    <div class="step-icon"><span class="step-number">2</span><i class="fa-solid fa-shield-halved"></i></div>
                    <h3 class="text-sm font-bold text-slate-800 dark:text-white">Verifikasi</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-2 leading-relaxed">Tim memeriksa dan memverifikasi laporan.</p>
                </div>
                <div class="step-item text-center relative z-10">
                    <div class="step-icon"><span class="step-number">3</span><i class="fa-solid fa-chart-column"></i></div>
                    <h3 class="text-sm font-bold text-slate-800 dark:text-white">Prioritaskan</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-2 leading-relaxed">Sistem menentukan skala prioritas.</p>
                </div>
                <div class="step-item text-center relative z-10">
                    <div class="step-icon"><span class="step-number">4</span><i class="fa-solid fa-circle-check"></i></div>
                    <h3 class="text-sm font-bold text-slate-800 dark:text-white">Tindak Lanjut</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-2 leading-relaxed">Perbaikan dilakukan sesuai prioritas.</p>
                </div>
            </div>
        </div>
    </section>

</main>
    <!-- ===== FOOTER ===== -->
    <footer id="kontak" class="footer bg-[#0d1f2b] dark:bg-[#020617] text-slate-400 pt-10 pb-5 section-anchor">
        <div class="max-w-[1180px] mx-auto px-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 pb-8 border-b border-white/10">
                <div>
                    <div class="flex items-center gap-3 text-white mb-4">
                        <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-emerald-400 to-emerald-700 flex items-center justify-center"><i class="fa-solid fa-route"></i></div>
                        <span class="text-xl font-extrabold">SmartPath</span>
                    </div>
                    <p class="text-xs leading-5">Bersama membangun ruang publik yang lebih inklusif dan aksesibel.</p>
                    <div class="flex gap-2 mt-4">
                        <a href="#" class="w-7 h-7 rounded-full bg-slate-700 flex items-center justify-center text-xs hover:bg-emerald-600 transition"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="w-7 h-7 rounded-full bg-slate-700 flex items-center justify-center text-xs hover:bg-emerald-600 transition"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="w-7 h-7 rounded-full bg-slate-700 flex items-center justify-center text-xs hover:bg-emerald-600 transition"><i class="fa-brands fa-youtube"></i></a>
                    </div>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-white mb-4">Navigasi</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="#beranda" class="hover:text-emerald-400 transition">Beranda</a></li>
                        <li><a href="{{ route('tentang') }}" class="hover:text-emerald-400 transition">Tentang</a></li>
                        <li><a href="#solusi" class="hover:text-emerald-400 transition">Fitur</a></li>
                        <li><a href="#cara-kerja" class="hover:text-emerald-400 transition">Cara Kerja</a></li>
                        <li><a href="#kontak" class="hover:text-emerald-400 transition">Kontak</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-white mb-4">Kategori Laporan</h4>
                    <ul class="space-y-3 text-xs">
                        <li><i class="fa-solid fa-road w-5 text-emerald-400"></i> Trotoar Rusak</li>
                        <li><i class="fa-solid fa-wheelchair w-5 text-emerald-400"></i> Ramp Tidak Ada</li>
                        <li><i class="fa-solid fa-grip-lines w-5 text-emerald-400"></i> Guiding Block Rusak</li>
                        <li><i class="fa-solid fa-ellipsis w-5 text-emerald-400"></i> Lainnya</li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-white mb-4">Kontak</h4>
                    <ul class="space-y-3 text-xs">
                        <li><i class="fa-solid fa-envelope w-5 text-emerald-400"></i> hello@smartpath.id</li>
                        <li><i class="fa-solid fa-phone w-5 text-emerald-400"></i> (021) 1234 5678</li>
                        <li><i class="fa-solid fa-location-dot w-5 text-emerald-400"></i> Depok, Jawa Barat, Indonesia</li>
                    </ul>
                </div>
            </div>
            <div class="pt-5 flex flex-col sm:flex-row justify-between gap-3 text-xs text-slate-500">
                <span>© 2026 SmartPath. Semua hak dilindungi.</span>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-emerald-400">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-emerald-400">Syarat & Ketentuan →</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts (Digabung agar rapi, tanpa mengubah logika) -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // ================================
        // SCROLL PROGRESS
        // ================================
        window.addEventListener('scroll', () => {
            const scrollTop = window.scrollY;
            const docHeight = document.documentElement.scrollHeight - window.innerHeight;
            const progress = (scrollTop / docHeight) * 100;
            document.getElementById('scrollProgress').style.width = progress + '%';
        });

        // ================================
        // DARK MODE TOGGLE
        // ================================
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');

        function setTheme(theme) {
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
                themeIcon.className = 'fa-solid fa-sun';
                localStorage.setItem('theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                themeIcon.className = 'fa-solid fa-moon';
                localStorage.setItem('theme', 'light');
            }
        }

        const savedTheme = localStorage.getItem('theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
            setTheme('dark');
        } else {
            setTheme('light');
        }

        themeToggle.addEventListener('click', () => {
            const isDark = document.documentElement.classList.contains('dark');
            setTheme(isDark ? 'light' : 'dark');
        });

        // ================================
        // MOBILE MENU
        // ================================
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');

        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('open');
            const icon = mobileMenuBtn.querySelector('i');
            if (mobileMenu.classList.contains('open')) {
                icon.className = 'fa-solid fa-xmark';
            } else {
                icon.className = 'fa-solid fa-bars';
            }
        });

        // ================================
        // NAVBAR ACTIVE LINK
        // ================================
        const navLinks = document.querySelectorAll('.nav-link');

        function removeActiveClass() {
            navLinks.forEach(link => {
                link.classList.remove('text-white', 'border-b-2', 'border-emerald-400', 'pb-5');
                link.classList.add('text-slate-300');
            });
        }

        function setActiveLink(activeLink) {
            removeActiveClass();
            activeLink.classList.remove('text-slate-300');
            activeLink.classList.add('text-white', 'border-b-2', 'border-emerald-400', 'pb-5');
        }

        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                setActiveLink(this);
            });
        });

        // ================================
        // SMARTPATH MAP
        // ================================
        const map = L.map('smartpath-map', { zoomControl: false }).setView([-6.4025, 106.7942], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);

        const reports = [
            {lat:-6.4025,lng:106.7942,title:'Trotoar Rusak',location:'Jl. Margonda Raya, Depok',status:'Pending',color:'#f59e0b',time:'2 jam lalu'},
            {lat:-6.4100,lng:106.8000,title:'Guiding Block Rusak',location:'Jl. Ciliwung, Depok',status:'Pending',color:'#f59e0b',time:'4 jam lalu'},
            {lat:-6.3950,lng:106.7880,title:'Ramp Tidak Tersedia',location:'Jl. Kalimantan, Depok',status:'Pending',color:'#f59e0b',time:'6 jam lalu'},
            {lat:-6.3915,lng:106.8218,title:'Akses Kursi Roda',location:'Jl. Juanda, Depok',status:'Diverifikasi',color:'#2dd4bf',time:'5 jam lalu'},
            {lat:-6.3800,lng:106.8100,title:'Trotoar Rusak',location:'Jl. Sumatra, Depok',status:'Diverifikasi',color:'#2dd4bf',time:'1 hari lalu'},
            {lat:-6.4180,lng:106.8250,title:'Guiding Block Rusak',location:'Jl. Papua, Depok',status:'Diverifikasi',color:'#2dd4bf',time:'2 hari lalu'},
            {lat:-6.4280,lng:106.8050,title:'Ramp Tidak Tersedia',location:'Jl. Kartini, Depok',status:'Dalam Perbaikan',color:'#60a5fa',time:'2 hari lalu'},
            {lat:-6.4120,lng:106.7920,title:'Trotoar Rusak',location:'Jl. Pahlawan, Depok',status:'Dalam Perbaikan',color:'#60a5fa',time:'3 hari lalu'},
            {lat:-6.3855,lng:106.7920,title:'Guiding Block Rusak',location:'Jl. Nusantara, Depok',status:'Selesai',color:'#34d399',time:'3 hari lalu'},
            {lat:-6.4050,lng:106.8150,title:'Akses Kursi Roda',location:'Jl. Diponegoro, Depok',status:'Selesai',color:'#34d399',time:'5 hari lalu'},
            {lat:-6.4170,lng:106.8320,title:'Trotoar Rusak',location:'Jl. Raya Sawangan, Depok',status:'Ditolak',color:'#ef4444',time:'1 hari lalu'},
            {lat:-6.3980,lng:106.8200,title:'Ramp Tidak Tersedia',location:'Jl. Merdeka, Depok',status:'Ditolak',color:'#ef4444',time:'2 hari lalu'}
        ];

        reports.forEach(report => {
            const marker = L.marker([report.lat, report.lng], { icon: L.divIcon({
                className: 'custom-pin-icon',
                html: `<i class="fa-solid fa-location-dot text-2xl" style="color: ${report.color};"></i>`,
                iconSize: [24, 24],
                iconAnchor: [12, 24],
                popupAnchor: [0, -24]
            })}).addTo(map);

            marker.bindPopup(`
                <div style="font-family:Inter,sans-serif;padding:4px">
                    <b style="font-size:13px">${report.title}</b>
                    <div style="font-size:10px;color:#64748b;margin-top:5px">${report.location}</div>
                    <div style="margin-top:7px;font-size:9px;font-weight:700;color:${report.color}">${report.status}</div>
                    <div style="font-size:9px;color:#94a3b8;margin-top:3px">${report.time}</div>
                </div>
            `);
        });

        document.getElementById('mapSearch').addEventListener('keydown', function(e) {
            if (e.key !== 'Enter') return;
            const q = this.value.trim().toLowerCase();
            if (!q) return;

            const found = reports.find(r =>
                r.title.toLowerCase().includes(q) ||
                r.location.toLowerCase().includes(q)
            );

            if (found) {
                map.setView([found.lat, found.lng], 16, {animate:true, duration:1});
                map.eachLayer(layer => {
                    if (layer.getLatLng && 
                        Math.abs(layer.getLatLng().lat - found.lat) < 0.001 && 
                        Math.abs(layer.getLatLng().lng - found.lng) < 0.001) {
                        layer.openPopup();
                    }
                });
            } else {
                this.value = '';
                this.placeholder = '❌ Lokasi tidak ditemukan';
                this.style.borderColor = '#ef4444';
                setTimeout(() => {
                    this.placeholder = 'Cari lokasi di peta...';
                    this.style.borderColor = 'inherit';
                }, 2000);
            }
        });

        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const el = entry.target;
                    const target = parseInt(el.getAttribute('data-target'));
                    const duration = 2000;
                    const increment = target / (duration / 16);
                    let current = 0;

                    const updateCounter = () => {
                        current += increment;
                        if (current < target) {
                            el.textContent = Math.round(current);
                            requestAnimationFrame(updateCounter);
                        } else {
                            el.textContent = target;
                        }
                    };
                    updateCounter();
                    counterObserver.unobserve(el);
                }
            });
        }, { threshold: 0.3 });

        document.querySelectorAll('.animated-counter').forEach(el => {
            counterObserver.observe(el);
        });

        const scrollObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, { threshold: 0.15, rootMargin: '0px 0px -50px 0px' });

        document.querySelectorAll('.animate-on-scroll').forEach(el => {
            scrollObserver.observe(el);
        });
    </script>

</body>
</html>
