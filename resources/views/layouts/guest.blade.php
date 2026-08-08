<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <meta
        name="theme-color"
        content="#059669"
    >

    <meta
        name="description"
        content="SmartPath - Platform pemetaan aksesibilitas infrastruktur publik"
    >

    <title>@yield('title', 'Masuk') - SmartPath</title>

    {{-- Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    {{-- Tailwind CDN
         Dipakai karena project tidak menggunakan Vite. --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
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
                            300: '#6ee7b7',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                            950: '#022c22',
                        }
                    }
                }
            }
        };
    </script>

    {{-- Custom CSS khusus halaman autentikasi --}}
    <link
        rel="stylesheet"
        href="{{ asset('css/smartpath-auth.css') }}"
    >

    @stack('styles')
</head>

<body class="min-h-screen bg-slate-50 text-slate-900 antialiased">

    <a
        href="#main-content"
        class="skip-link"
    >
    
    </a>

    <main
        id="main-content"
        class="min-h-screen"
        role="main"
    >
        @yield('content')
    </main>

    <script
        src="{{ asset('js/smartpath-auth.js') }}"
        defer
    ></script>

    @stack('scripts')

</body>
</html>