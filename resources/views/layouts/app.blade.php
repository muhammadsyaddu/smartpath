<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SmartPath - Sistem Otomatis Pemetaan Aksesibilitas dan Prioritas Infrastruktur Disabilitas Berbasis Smart City">
    <title>@yield('title', 'SmartPath') - SmartPath</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="h-full bg-slate-50 text-slate-900 antialiased">
    @include('partials.nav-public')

    <main id="main-content" role="main">
        @if(session('sukses'))
            <div class="fixed top-4 right-4 z-50 bg-emerald-50 border border-emerald-200 text-emerald-800 px-6 py-3 rounded-xl shadow-sm flex items-center gap-2" role="alert" aria-live="polite">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                {{ session('sukses') }}
            </div>
        @endif
        @if(session('galat'))
            <div class="fixed top-4 right-4 z-50 bg-red-50 border border-red-200 text-red-800 px-6 py-3 rounded-xl shadow-sm flex items-center gap-2" role="alert" aria-live="polite">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                {{ session('galat') }}
            </div>
        @endif

        @yield('content')
    </main>

    @include('partials.footer')

    @stack('scripts')
</body>
</html>
