@extends('layouts.guest')

@section('title', 'Masuk')

@section('content')

<div class="min-h-screen w-full flex items-center justify-center p-0">

    <div class="w-full max-w-none">

        <div class="grid min-h-screen w-full overflow-hidden bg-white lg:grid-cols-2">

            {{-- ==========================================================
                 PANEL INFORMASI SMARTPATH
            =========================================================== --}}
            <section
                class="relative hidden min-h-screen overflow-hidden bg-emerald-700 lg:flex lg:flex-col lg:justify-between"
                aria-label="Informasi SmartPath"
            >

                {{-- Background decoration --}}
                <div
                    class="absolute -right-24 -top-24 h-72 w-72 rounded-full bg-emerald-500/30 blur-3xl"
                    aria-hidden="true"
                ></div>

                <div
                    class="absolute -bottom-32 -left-24 h-80 w-80 rounded-full bg-teal-400/20 blur-3xl"
                    aria-hidden="true"
                ></div>

                <div class="relative z-10 p-10 xl:p-12">

                    {{-- Brand --}}
                    <a
                        href="{{ route('beranda') }}"
                        class="inline-flex items-center gap-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-emerald-700"
                        aria-label="SmartPath - kembali ke beranda"
                    >

                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/10 ring-1 ring-white/20 backdrop-blur-sm">

                            <svg
                                class="h-6 w-6 text-white"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                aria-hidden="true"
                            >
                                <path d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                            </svg>

                        </span>

                        <span class="text-xl font-bold tracking-tight text-white">
                            SmartPath
                        </span>

                    </a>


                    {{-- Headline --}}
                    <div class="mt-20 max-w-md">

                        <p class="mb-4 text-sm font-semibold uppercase tracking-[0.18em] text-emerald-100">
                            Platform Aksesibilitas
                        </p>

                        <h1 class="text-4xl font-extrabold leading-tight tracking-tight text-white xl:text-5xl">
                            Bersama membangun ruang publik yang lebih aksesibel.
                        </h1>

                        <p class="mt-6 text-sm leading-7 text-emerald-50/90 xl:text-base">
                            SmartPath membantu masyarakat dan pemerintah
                            mengidentifikasi, memetakan, memverifikasi, dan
                            memprioritaskan hambatan aksesibilitas pada
                            infrastruktur publik.
                        </p>

                    </div>


                    {{-- Feature --}}
                    <div class="mt-12 space-y-4">

                        <div class="flex items-start gap-4">

                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white/10 ring-1 ring-white/10">
                                <svg
                                    class="h-4 w-4 text-white"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    aria-hidden="true"
                                >
                                    <path d="M12 2v20"/>
                                    <path d="M2 12h20"/>
                                    <circle cx="12" cy="12" r="9"/>
                                </svg>
                            </span>

                            <div>
                                <h2 class="text-sm font-semibold text-white">
                                    Pemetaan berbasis lokasi
                                </h2>

                                <p class="mt-1 text-xs leading-5 text-emerald-100/80">
                                    Data hambatan divisualisasikan pada peta
                                    untuk membantu menentukan kebutuhan
                                    perbaikan.
                                </p>
                            </div>

                        </div>


                        <div class="flex items-start gap-4">

                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white/10 ring-1 ring-white/10">

                                <svg
                                    class="h-4 w-4 text-white"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    aria-hidden="true"
                                >
                                    <path d="M20 6L9 17l-5-5"/>
                                </svg>

                            </span>

                            <div>

                                <h2 class="text-sm font-semibold text-white">
                                    Proses terverifikasi
                                </h2>

                                <p class="mt-1 text-xs leading-5 text-emerald-100/80">
                                    Laporan diproses melalui tahapan verifikasi
                                    sebelum digunakan sebagai data prioritas.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Footer panel --}}
                <div class="relative z-10 border-t border-white/10 px-10 py-5 xl:px-12">

                    <p class="text-xs text-emerald-100/70">
                        SmartPath · Pemetaan Aksesibilitas Infrastruktur
                    </p>

                </div>

            </section>


            {{-- ==========================================================
                 PANEL LOGIN
            =========================================================== --}}
            <section class="flex min-h-screen items-center bg-white px-6 py-10 sm:px-10 lg:px-16 xl:px-24">

                <div class="mx-auto w-full max-w-lg">

                    {{-- Mobile Brand --}}
                    <div class="mb-8 lg:hidden">

                        <a
                            href="{{ route('beranda') }}"
                            class="inline-flex items-center gap-2.5 text-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 rounded-lg"
                            aria-label="SmartPath - kembali ke beranda"
                        >

                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50">

                                <svg
                                    class="h-5 w-5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    aria-hidden="true"
                                >
                                    <path d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                </svg>

                            </span>

                            <span class="text-xl font-bold">
                                SmartPath
                            </span>

                        </a>

                    </div>


                    {{-- Header --}}
                    <div class="mb-8">

                        <div class="mb-5 inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">

                            <svg
                                class="h-6 w-6"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                aria-hidden="true"
                            >
                                <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/>
                                <polyline points="10 17 15 12 10 7"/>
                                <line x1="15" y1="12" x2="3" y2="12"/>
                            </svg>

                        </div>

                        <h2 class="text-3xl font-extrabold tracking-tight text-slate-900">
                            Selamat datang kembali
                        </h2>

                        <p class="mt-2 text-sm leading-6 text-slate-500">
                            Masuk ke akun SmartPath untuk melanjutkan.
                        </p>

                    </div>


                    {{-- General Error --}}
                    @if($errors->has('email') && !$errors->has('kata_sandi'))
                        <div
                            class="mb-5 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3.5 text-sm text-red-800"
                            role="alert"
                            aria-live="assertive"
                        >

                            <svg
                                class="mt-0.5 h-5 w-5 shrink-0 text-red-600"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                aria-hidden="true"
                            >
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="12" y1="8" x2="12" y2="12"/>
                                <line x1="12" y1="16" x2="12.01" y2="16"/>
                            </svg>

                            <div>
                                <p class="font-semibold">
                                    Gagal masuk
                                </p>

                                <p class="mt-0.5 text-xs text-red-700">
                                    {{ $errors->first('email') }}
                                </p>
                            </div>

                        </div>
                    @endif


                    {{-- Login Form --}}
                    <form
                        method="POST"
                        action="{{ route('login.post') }}"
                        id="login-form"
                        novalidate
                        class="space-y-5"
                    >

                        @csrf


                        {{-- Email --}}
                        <div>

                            <label
                                for="email"
                                class="mb-2 block text-sm font-semibold text-slate-700"
                            >
                                Email
                            </label>

                            <div class="relative">

                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">

                                    <svg
                                        class="h-5 w-5 text-slate-400"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        aria-hidden="true"
                                    >
                                        <rect x="3" y="5" width="18" height="14" rx="2"/>
                                        <polyline points="3 7 12 13 21 7"/>
                                    </svg>

                                </div>

                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="nama@email.com"
                                    autocomplete="email"
                                    inputmode="email"
                                    autocapitalize="none"
                                    spellcheck="false"
                                    required
                                    autofocus
                                    aria-required="true"
                                    aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                                    aria-describedby="{{ $errors->has('email') ? 'email-error' : 'email-help' }}"
                                    class="auth-input w-full rounded-xl border border-slate-300 bg-white py-3.5 pl-11 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                                >

                            </div>

                            @if($errors->has('email'))
                                <p
                                    id="email-error"
                                    class="mt-2 text-xs font-medium text-red-600"
                                    role="alert"
                                >
                                    {{ $errors->first('email') }}
                                </p>
                            @else
                                <p
                                    id="email-help"
                                    class="mt-2 text-xs text-slate-400"
                                >
                                    Gunakan alamat email yang terdaftar.
                                </p>
                            @endif

                        </div>


                        {{-- Password --}}
                        <div>

                            <div class="mb-2 flex items-center justify-between">

                                <label
                                    for="kata_sandi"
                                    class="block text-sm font-semibold text-slate-700"
                                >
                                    Kata Sandi
                                </label>

                            </div>


                            <div class="relative">

                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">

                                    <svg
                                        class="h-5 w-5 text-slate-400"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        aria-hidden="true"
                                    >
                                        <rect x="3" y="11" width="18" height="10" rx="2"/>
                                        <path d="M7 11V7a5 5 0 0110 0v4"/>
                                    </svg>

                                </div>


                                <input
                                    type="password"
                                    id="kata_sandi"
                                    name="kata_sandi"
                                    placeholder="Masukkan kata sandi"
                                    autocomplete="current-password"
                                    required
                                    aria-required="true"
                                    aria-invalid="{{ $errors->has('kata_sandi') ? 'true' : 'false' }}"
                                    aria-describedby="{{ $errors->has('kata_sandi') ? 'password-error' : 'password-help' }}"
                                    class="auth-input w-full rounded-xl border border-slate-300 bg-white py-3.5 pl-11 pr-12 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-400 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                                >


                                <button
                                    type="button"
                                    id="toggle-password"
                                    class="absolute inset-y-0 right-0 flex w-12 items-center justify-center rounded-r-xl text-slate-400 transition hover:text-slate-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-emerald-500"
                                    aria-label="Tampilkan kata sandi"
                                    aria-pressed="false"
                                >

                                    <svg
                                        id="password-eye"
                                        class="h-5 w-5"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        aria-hidden="true"
                                    >
                                        <path d="M2.062 12.348a1 1 0 010-.696 10.75 10.75 0 0119.876 0 1 1 0 010 .696 10.75 10.75 0 01-19.876 0z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>

                                </button>

                            </div>


                            @if($errors->has('kata_sandi'))
                                <p
                                    id="password-error"
                                    class="mt-2 text-xs font-medium text-red-600"
                                    role="alert"
                                >
                                    {{ $errors->first('kata_sandi') }}
                                </p>
                            @else
                                <p
                                    id="password-help"
                                    class="mt-2 text-xs text-slate-400"
                                >
                                    Masukkan kata sandi akun Anda.
                                </p>
                            @endif

                        </div>


                        {{-- Remember --}}
                        <div class="flex items-center justify-between pt-1">

                            <label
                                for="remember"
                                class="inline-flex cursor-pointer items-center gap-3"
                            >

                                <input
                                    type="checkbox"
                                    id="remember"
                                    name="remember"
                                    value="1"
                                    class="auth-checkbox h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500"
                                >

                                <span class="text-sm font-medium text-slate-600">
                                    Ingat saya
                                </span>

                            </label>

                        </div>


                        {{-- Submit --}}
                        <button
                            type="submit"
                            id="login-submit"
                            class="group flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-600 px-5 py-3.5 text-sm font-bold text-white shadow-sm transition duration-200 hover:bg-emerald-700 hover:shadow-md focus:outline-none focus:ring-4 focus:ring-emerald-500/20 disabled:cursor-not-allowed disabled:opacity-70"
                        >

                            <span id="login-submit-text">
                                Masuk ke SmartPath
                                <a href="{{ route('admin.dashboard') }}" class="ml-1 text-sm font-normal text-emerald-100 transition hover:text-white">

                                </a>
                            </span>

                            <svg
                                id="login-spinner"
                                class="hidden h-4 w-4 animate-spin"
                                viewBox="0 0 24 24"
                                fill="none"
                                aria-hidden="true"
                            >
                                <circle
                                    cx="12"
                                    cy="12"
                                    r="9"
                                    class="opacity-30"
                                    stroke="currentColor"
                                    stroke-width="3"
                                />

                                <path
                                    d="M21 12a9 9 0 00-9-9"
                                    stroke="currentColor"
                                    stroke-width="3"
                                    stroke-linecap="round"
                                />
                            </svg>

                        </button>

                    </form>


                    {{-- Back to Home --}}
                    <div class="mt-8 border-t border-slate-100 pt-6 text-center">

                        <a
                            href="{{ route('beranda') }}"
                            class="inline-flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-slate-500 transition hover:text-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2"
                        >

                            <svg
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                aria-hidden="true"
                            >
                                <path d="M19 12H5"/>
                                <polyline points="12 19 5 12 12 5"/>
                            </svg>

                            Kembali ke Beranda

                        </a>

                    </div>


                   {{-- Copyright --}}
                    <p class="mt-6 text-center text-[11px] leading-5 text-slate-400">
                        &copy; {{ date('Y') }} SmartPath. Semua hak dilindungi.
                    </p>

                </div>

            </section>

        </div>


       
    </div>

</div>

@endsection