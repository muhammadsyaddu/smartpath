<header
    class="h-[72px] shrink-0 border-b border-slate-200 bg-white px-4 sm:px-5 lg:px-6 flex items-center justify-between gap-4 sticky top-0 z-30"
    role="banner"
>

    <div class="flex min-w-0 items-center gap-3">

        {{-- MOBILE MENU --}}
        <button
            type="button"
            id="admin-mobile-menu"
            class="lg:hidden inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-600 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-emerald-500/30"
            aria-label="Buka menu navigasi"
            aria-controls="admin-sidebar"
            aria-expanded="false"
        >

            <svg
                class="h-5 w-5"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                aria-hidden="true"
            >
                <path
                    stroke-linecap="round"
                    d="M4 6h16M4 12h16M4 18h16"
                />
            </svg>

        </button>


        {{-- GREETING --}}
        <div class="min-w-0">

            <div class="flex items-center gap-2">

                <h1
                    class="truncate text-[18px] font-semibold tracking-[-0.02em] text-slate-950"
                >

                    {{
                        now()->hour < 12
                            ? 'Good Morning'
                            : (
                                now()->hour < 18
                                    ? 'Good Afternoon'
                                    : 'Good Evening'
                            )
                    }},

                    {{
                        auth()->user()->nama_lengkap
                        ?? 'Administrator'
                    }}

                </h1>

                <span
                    class="text-base"
                    aria-hidden="true"
                >
                    👋
                </span>

            </div>


            <p
                class="hidden sm:block truncate text-[11px] leading-4 text-slate-500"
            >
                Pantau, verifikasi, dan analisis laporan aksesibilitas kota Depok secara real-time
            </p>

        </div>

    </div>


    {{-- RIGHT HEADER --}}
    <div
        class="flex shrink-0 items-center gap-2 sm:gap-3"
    >

        {{-- SEARCH --}}
        <form
            method="GET"
            action="{{ route('admin.dashboard') }}"
            class="relative hidden md:block"
        >

            <label
                for="dashboard-search"
                class="sr-only"
            >
                Cari laporan
            </label>


            <svg
                class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                aria-hidden="true"
            >

                <circle
                    cx="11"
                    cy="11"
                    r="7"
                />

                <path
                    stroke-linecap="round"
                    d="m20 20-4-4"
                />

            </svg>


            <input
                id="dashboard-search"
                name="search"
                value="{{ request('search') }}"
                type="search"
                autocomplete="off"
                placeholder="Cari laporan, lokasi, kategori..."
                class="h-9 w-[240px] rounded-lg border border-slate-300 bg-white pl-9 pr-14 text-[11px] text-slate-800 placeholder:text-slate-400 outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
            >


            <span
                class="pointer-events-none absolute right-2 top-1/2 -translate-y-1/2 rounded border border-slate-200 bg-slate-50 px-1.5 py-0.5 text-[9px] font-medium text-slate-400"
            >
                Ctrl / K
            </span>

        </form>


        {{-- NOTIFICATION --}}
        <button
            type="button"
            class="relative inline-flex h-9 w-9 items-center justify-center rounded-lg text-slate-600 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-emerald-500/30"
            aria-label="Notifikasi"
            title="Notifikasi"
        >

            <svg
                class="h-5 w-5"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                aria-hidden="true"
            >

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4"
                />

            </svg>


            @if(
                auth()->user()
                    ->notifikasi_belum_dibaca_count > 0
            )

                <span
                    class="absolute right-1.5 top-1.5 h-2 w-2 rounded-full bg-red-500 ring-2 ring-white"
                    aria-label="Ada notifikasi baru"
                ></span>

            @endif

        </button>


        {{-- PROFILE INFO --}}
        <div
            class="flex items-center gap-2 border-l border-slate-200 pl-3"
        >

            <span
                class="flex h-9 w-9 items-center justify-center rounded-full border border-slate-300 bg-slate-100 text-xs font-semibold text-slate-700"
            >

                {{
                    collect(
                        preg_split(
                            '/\s+/',
                            trim(
                                auth()->user()->nama_lengkap
                                ?? 'Admin'
                            )
                        )
                    )
                    ->filter()
                    ->map(
                        fn ($part) =>
                            mb_substr(
                                $part,
                                0,
                                1
                            )
                    )
                    ->take(2)
                    ->implode('')
                }}

            </span>


            <span
                class="hidden xl:block text-left leading-tight"
            >

                <span
                    class="block max-w-[130px] truncate text-[11px] font-semibold text-slate-900"
                >
                    {{
                        auth()->user()->nama_lengkap
                        ?? 'Administrator'
                    }}
                </span>

                <span
                    class="block text-[10px] text-slate-500"
                >
                    {{
                        auth()->user()->isAdmin()
                            ? 'Admin PUPR'
                            : 'Petugas Dinas'
                    }}
                </span>

            </span>


            <svg
                class="hidden xl:block h-3.5 w-3.5 text-slate-400"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                aria-hidden="true"
            >
                <path
                    stroke-linecap="round"
                    d="m6 9 6 6 6-6"
                />
            </svg>

        </div>

    </div>

</header>


@once

@push('scripts')

<script>

(() => {

    const menuButton =
        document.getElementById(
            'admin-mobile-menu'
        );

    const sidebar =
        document.getElementById(
            'admin-sidebar'
        );

    const overlay =
        document.getElementById(
            'admin-sidebar-overlay'
        );


    if (
        !menuButton ||
        !sidebar ||
        !overlay
    ) {
        return;
    }


    const setOpen =
        (open) => {

            sidebar.classList.toggle(
                '-translate-x-full',
                !open
            );

            overlay.classList.toggle(
                'hidden',
                !open
            );

            menuButton.setAttribute(
                'aria-expanded',
                open
                    ? 'true'
                    : 'false'
            );

            document.body.classList.toggle(
                'overflow-hidden',
                open
            );

        };


    menuButton.addEventListener(
        'click',
        () => {

            setOpen(
                sidebar.classList.contains(
                    '-translate-x-full'
                )
            );

        }
    );


    overlay.addEventListener(
        'click',
        () => setOpen(false)
    );


    sidebar
        .querySelectorAll('a')
        .forEach((link) => {

            link.addEventListener(
                'click',
                () => {

                    if (
                        window.innerWidth < 1024
                    ) {
                        setOpen(false);
                    }

                }
            );

        });


    window.addEventListener(
        'resize',
        () => {

            if (
                window.innerWidth >= 1024
            ) {
                setOpen(false);
            }

        }
    );

})();

</script>

@endpush

@endonce
