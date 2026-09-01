@extends('layouts.guest')

@section('title', 'Daftar Akun')

@section('content')
<div class="min-h-screen w-full bg-[#f3faf7] flex items-end sm:items-center justify-center p-0 sm:p-4">

    <div class="relative w-full max-w-lg overflow-hidden bg-white sm:rounded-[2rem] sm:shadow-[0_20px_60px_rgba(15,23,42,0.12)]">

        {{-- ==========================================================
             ACCESSIBILITY ILLUSTRATION
        =========================================================== --}}
        <div class="relative h-[230px] sm:h-[400px] overflow-hidden bg-emerald-50">
            <img
                src="{{ asset('foto-disabilitas.png') }}"
                alt="Ilustrasi kota yang aksesibel"
                class="absolute inset-0 h-full w-full object-cover object-bottom"
            >
            <div class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-white/90 to-transparent"></div>
        </div>

        {{-- ==========================================================
             REGISTER CARD
        =========================================================== --}}
        <div class="relative z-20 -mt-10 rounded-t-[2rem] bg-white px-6 pb-8 pt-6 shadow-[0_-10px_30px_rgba(15,23,42,0.06)] sm:px-8 sm:pt-7">

            {{-- BRAND --}}
            <div class="mb-5 flex items-center gap-3">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-emerald-600 text-white shadow-[0_8px_20px_rgba(5,150,105,0.22)]">
                    <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2.5 20 6v5.5c0 5.1-3.4 8.6-8 10-4.6-1.4-8-4.9-8-10V6l8-3.5Z"/>
                        <path d="m8.2 12 2.3 2.3 5.3-5.3"/>
                    </svg>
                </div>
                <div>
                    <div class="text-xl font-extrabold tracking-tight text-slate-900">
                        Smart<span class="text-emerald-600">Path</span>
                    </div>
                    <p class="text-[11px] font-medium text-slate-400">
                        Platform Pelaporan Aksesibilitas
                    </p>
                </div>
            </div>

            {{-- HEADER --}}
            <div class="mb-5">
                <h2 class="text-[26px] font-extrabold leading-tight tracking-tight text-slate-900">
                    Buat Akun
                </h2>
                <p class="mt-1 max-w-[340px] text-sm leading-6 text-slate-500">
                    Daftarkan akun Anda untuk mulai melaporkan hambatan aksesibilitas di sekitar Anda.
                </p>
            </div>

            {{-- GENERAL ERROR ALERT --}}
            @if ($errors->any())
                <div class="mb-5 flex items-start gap-3 rounded-2xl border border-red-200 bg-red-50/80 p-4 text-red-800" role="alert">
                    <svg class="h-5 w-5 shrink-0 text-red-500 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M12 9v4m0 4h.01M10.3 3.8 2.7 17a2 2 0 0 0 1.7 3h15.2a2 2 0 0 0 1.7-3L13.7 3.8a2 2 0 0 0-3.4 0Z"/>
                    </svg>
                    <div class="text-xs leading-5">
                        <strong class="font-bold">Periksa kembali data Anda:</strong>
                        <ul class="mt-1 list-disc list-inside space-y-0.5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- REGISTER FORM --}}
            <form method="POST" action="{{ route('register.post') }}" id="registerForm" novalidate class="space-y-4">
                @csrf

                {{-- NAMA LENGKAP --}}
                <div>
                    <label for="nama_lengkap" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                            <svg class="h-5 w-5 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21a8 8 0 0 0-16 0"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                        </div>
                        <input
                            type="text"
                            id="nama_lengkap"
                            name="nama_lengkap"
                            value="{{ old('nama_lengkap') }}"
                            placeholder="Masukkan nama lengkap"
                            autocomplete="name"
                            maxlength="150"
                            required
                            autofocus
                            class="h-14 w-full rounded-2xl border border-slate-200 bg-white pl-12 pr-4 text-sm text-slate-900 shadow-[0_2px_8px_rgba(15,23,42,0.03)] outline-none transition-all duration-200 placeholder:text-slate-400 hover:border-slate-300 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 @error('nama_lengkap') border-red-500 focus:border-red-500 focus:ring-red-500/10 @enderror"
                            @error('nama_lengkap') aria-invalid="true" @enderror
                        >
                    </div>
                    @error('nama_lengkap')
                        <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- EMAIL --}}
                <div>
                    <label for="email" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                            <svg class="h-5 w-5 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="5" width="18" height="14" rx="2"/>
                                <path d="m3 7 9 6 9-6"/>
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
                            maxlength="150"
                            required
                            class="h-14 w-full rounded-2xl border border-slate-200 bg-white pl-12 pr-4 text-sm text-slate-900 shadow-[0_2px_8px_rgba(15,23,42,0.03)] outline-none transition-all duration-200 placeholder:text-slate-400 hover:border-slate-300 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 @error('email') border-red-500 focus:border-red-500 focus:ring-red-500/10 @enderror"
                            @error('email') aria-invalid="true" @enderror
                        >
                    </div>
                    @error('email')
                        <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- KATA SANDI --}}
                <div>
                    <label for="kata_sandi" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Kata Sandi <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                            <svg class="h-5 w-5 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="4" y="10" width="16" height="11" rx="2"/>
                                <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
                            </svg>
                        </div>
                        <input
                            type="password"
                            id="kata_sandi"
                            name="kata_sandi"
                            placeholder="Masukkan kata sandi"
                            autocomplete="new-password"
                            minlength="8"
                            maxlength="72"
                            required
                            class="h-14 w-full rounded-2xl border border-slate-200 bg-white pl-12 pr-14 text-sm text-slate-900 shadow-[0_2px_8px_rgba(15,23,42,0.03)] outline-none transition-all duration-200 placeholder:text-slate-400 hover:border-slate-300 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 @error('kata_sandi') border-red-500 focus:border-red-500 focus:ring-red-500/10 @enderror"
                            @error('kata_sandi') aria-invalid="true" @enderror
                        >
                        <button
                            type="button"
                            class="absolute inset-y-0 right-0 flex w-12 items-center justify-center rounded-r-2xl text-slate-400 transition hover:text-emerald-600 focus:outline-none"
                            data-password-toggle="kata_sandi"
                            aria-label="Tampilkan kata sandi"
                        >
                            <svg class="h-5 w-5 eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"/>
                                <circle cx="12" cy="12" r="2.5"/>
                            </svg>
                            <svg class="h-5 w-5 eye-closed hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m3 3 18 18"/>
                                <path d="M10.6 6.2A10.8 10.8 0 0 1 12 6c6 0 9.5 6 9.5 6a16 16 0 0 1-3.2 3.9"/>
                                <path d="M6.3 6.4C3.9 8.2 2.5 12 2.5 12s3.5 6 9.5 6c1.3 0 2.5-.3 3.6-.8"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Indikator kekuatan kata sandi --}}
                    <div class="mt-2" aria-live="polite">
                        <div class="flex h-1.5 gap-1" id="strengthBars">
                            <span class="flex-1 rounded-full bg-slate-200 transition-all"></span>
                            <span class="flex-1 rounded-full bg-slate-200 transition-all"></span>
                            <span class="flex-1 rounded-full bg-slate-200 transition-all"></span>
                            <span class="flex-1 rounded-full bg-slate-200 transition-all"></span>
                        </div>
                        <p class="strength-text mt-1.5 text-xs text-slate-500">
                            Min. 8 karakter, kombinasi huruf & angka.
                        </p>
                    </div>

                    @error('kata_sandi')
                        <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>
                    @enderror

                    {{-- Error validasi kombinasi --}}
                    <p class="mt-1.5 hidden text-xs font-semibold text-red-600" id="passwordRequirementError">
                        ✗ Kata sandi harus mengandung kombinasi huruf dan angka.
                    </p>
                </div>

                {{-- KONFIRMASI KATA SANDI --}}
                <div>
                    <label for="kata_sandi_confirmation" class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-700">
                        Konfirmasi Kata Sandi <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                            <svg class="h-5 w-5 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                            </svg>
                        </div>
                        <input
                            type="password"
                            id="kata_sandi_confirmation"
                            name="kata_sandi_confirmation"
                            placeholder="Masukkan ulang kata sandi"
                            autocomplete="new-password"
                            minlength="8"
                            maxlength="72"
                            required
                            class="h-14 w-full rounded-2xl border border-slate-200 bg-white pl-12 pr-14 text-sm text-slate-900 shadow-[0_2px_8px_rgba(15,23,42,0.03)] outline-none transition-all duration-200 placeholder:text-slate-400 hover:border-slate-300 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10"
                        >
                        <button
                            type="button"
                            class="absolute inset-y-0 right-0 flex w-12 items-center justify-center rounded-r-2xl text-slate-400 transition hover:text-emerald-600 focus:outline-none"
                            data-password-toggle="kata_sandi_confirmation"
                            aria-label="Tampilkan konfirmasi kata sandi"
                        >
                            <svg class="h-5 w-5 eye-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"/>
                                <circle cx="12" cy="12" r="2.5"/>
                            </svg>
                            <svg class="h-5 w-5 eye-closed hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m3 3 18 18"/>
                                <path d="M10.6 6.2A10.8 10.8 0 0 1 12 6c6 0 9.5 6 9.5 6a16 16 0 0 1-3.2 3.9"/>
                                <path d="M6.3 6.4C3.9 8.2 2.5 12 2.5 12s3.5 6 9.5 6c1.3 0 2.5-.3 3.6-.8"/>
                            </svg>
                        </button>
                    </div>
                    <p class="password-match mt-1.5 text-xs font-semibold" id="passwordMatch" aria-live="polite"></p>
                </div>

                {{-- NOMOR HP (OPSIONAL) --}}
                <div>
                    <div class="mb-1.5 flex items-center justify-between">
                        <label for="nomor_hp" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                            Nomor HP
                        </label>
                        <span class="text-[11px] font-medium text-slate-400">Opsional</span>
                    </div>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                            <svg class="h-5 w-5 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="6" y="2.5" width="12" height="19" rx="2"/>
                                <path d="M10 18.5h4"/>
                            </svg>
                        </div>
                        <input
                            type="tel"
                            id="nomor_hp"
                            name="nomor_hp"
                            value="{{ old('nomor_hp') }}"
                            placeholder="08xxxxxxxxxx"
                            autocomplete="tel"
                            maxlength="20"
                            inputmode="tel"
                            class="h-14 w-full rounded-2xl border border-slate-200 bg-white pl-12 pr-4 text-sm text-slate-900 shadow-[0_2px_8px_rgba(15,23,42,0.03)] outline-none transition-all duration-200 placeholder:text-slate-400 hover:border-slate-300 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 @error('nomor_hp') border-red-500 focus:border-red-500 focus:ring-red-500/10 @enderror"
                            @error('nomor_hp') aria-invalid="true" @enderror
                        >
                    </div>
                    @error('nomor_hp')
                        <p class="mt-1.5 text-xs font-semibold text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- AGREEMENT --}}
                <div class="pt-1">
                    <label class="flex cursor-pointer items-start gap-3 text-xs leading-5 text-slate-600">
                        <input
                            type="checkbox"
                            name="agreement"
                            value="1"
                            required
                            class="mt-0.5 h-4 w-4 shrink-0 rounded border-slate-300 text-emerald-600 focus:ring-2 focus:ring-emerald-500/20 focus:ring-offset-0"
                        >
                        <span>Saya menyetujui penggunaan data saya untuk keperluan pelaporan dan pengelolaan layanan SmartPath.</span>
                    </label>
                </div>

                {{-- SUBMIT BUTTON --}}
                <div class="pt-2">
                    <button
                        type="submit"
                        id="registerSubmit"
                        class="group flex h-14 w-full items-center justify-center gap-2 rounded-2xl bg-emerald-600 px-5 text-sm font-bold text-white shadow-[0_8px_20px_rgba(5,150,105,0.20)] transition-all duration-200 hover:bg-emerald-700 hover:shadow-[0_10px_25px_rgba(5,150,105,0.25)] active:scale-[0.985] focus:outline-none focus:ring-4 focus:ring-emerald-500/20"
                    >
                        <span class="submit-text">Buat Akun</span>
                        <span class="submit-loading hidden items-center gap-2" aria-hidden="true">
                            <span class="inline-block h-5 w-5 animate-spin rounded-full border-2 border-white/30 border-t-white"></span>
                            <span>Membuat akun...</span>
                        </span>
                        <svg class="h-5 w-5 transition-transform duration-200 group-hover:translate-x-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14"/>
                            <path d="m13 6 6 6-6 6"/>
                        </svg>
                    </button>
                </div>
            </form>

            {{-- LOGIN LINK --}}
            <div class="mt-6 text-center">
                <p class="text-sm text-slate-500">
                    Sudah memiliki akun?
                    <a href="{{ route('login') }}" class="ml-1 font-bold text-emerald-600 transition hover:text-emerald-700">
                        Masuk di sini
                    </a>
                </p>
            </div>

            {{-- FOOTER / SECURITY INFO --}}
            <div class="mt-6 border-t border-slate-100 pt-5 text-center">
                <div class="flex items-center justify-center gap-1.5 text-xs text-slate-400">
                    <svg class="h-4 w-4 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M12 2.5 20 6v5.5c0 5.1-3.4 8.6-8 10-4.6-1.4-8-4.9-8-10V6l8-3.5Z"/>
                        <path d="m8.5 12 2.2 2.2 4.8-4.8"/>
                    </svg>
                    <span>Data Anda dilindungi dan diproses secara aman.</span>
                </div>
                <p class="mt-1 text-[11px] font-medium text-slate-400">
                    © {{ date('Y') }} SmartPath. All rights reserved.
                </p>
            </div>

        </div>

        {{-- Mobile Indicator --}}
        <div class="flex justify-center bg-white pb-3 sm:hidden">
            <div class="h-1 w-28 rounded-full bg-slate-900"></div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<script>
    (function() {
        // Toggle password visibility
        document.querySelectorAll('[data-password-toggle]').forEach(btn => {
            btn.addEventListener('click', function() {
                const inputId = this.getAttribute('data-password-toggle');
                const input = document.getElementById(inputId);
                if (!input) return;
                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                this.querySelector('.eye-open').classList.toggle('hidden', !isPassword);
                this.querySelector('.eye-closed').classList.toggle('hidden', isPassword);
            });
        });

        // Elements
        const pwdInput = document.getElementById('kata_sandi');
        const confirmInput = document.getElementById('kata_sandi_confirmation');
        const bars = document.querySelectorAll('#strengthBars span');
        const strengthText = document.querySelector('.strength-text');
        const matchMsg = document.getElementById('passwordMatch');
        const requirementError = document.getElementById('passwordRequirementError');
        const form = document.getElementById('registerForm');
        const submitBtn = document.getElementById('registerSubmit');

        // Validation helper: Must contain letter AND number
        function validatePasswordCombination(password) {
            const hasLetter = /[A-Za-z]/.test(password);
            const hasNumber = /\d/.test(password);
            return hasLetter && hasNumber;
        }

        // Strength label calculation & hex colors
        function getStrength(score) {
            if (score <= 1) return { level: 1, label: 'Lemah', color: '#ef4444' }; // red-500
            if (score === 2) return { level: 2, label: 'Sedang', color: '#f59e0b' }; // amber-500
            if (score === 3) return { level: 3, label: 'Kuat', color: '#10b981' };  // emerald-500
            if (score >= 4) return { level: 4, label: 'Sangat kuat', color: '#059669' }; // emerald-600
            return { level: 0, label: '', color: '#e2e8f0' }; // slate-200
        }

        // Password strength meter
        pwdInput.addEventListener('input', function() {
            const pwd = this.value;
            let score = 0;

            if (pwd.length >= 8) score++;
            if (pwd.length >= 12) score++;
            if (/[a-z]/.test(pwd) && /[A-Z]/.test(pwd)) score++;
            if (/\d/.test(pwd) && /[^a-zA-Z0-9]/.test(pwd)) score++;
            score = Math.min(score, 4);

            const strength = getStrength(score);
            bars.forEach((bar, idx) => {
                if (idx < strength.level) {
                    bar.style.backgroundColor = strength.color;
                } else {
                    bar.style.backgroundColor = '#e2e8f0';
                }
            });

            if (pwd.length === 0) {
                strengthText.textContent = 'Min. 8 karakter, kombinasi huruf & angka.';
                strengthText.className = 'strength-text mt-1.5 text-xs text-slate-500';
            } else {
                strengthText.textContent = `Kekuatan: ${strength.label}`;
                strengthText.className = 'strength-text mt-1.5 text-xs font-semibold text-slate-700';
            }

            if (validatePasswordCombination(pwd)) {
                requirementError.classList.add('hidden');
            }
        });

        // Password match checking
        function checkMatch() {
            const pwd = pwdInput.value;
            const confirm = confirmInput.value;

            if (confirm.length === 0) {
                matchMsg.textContent = '';
                matchMsg.className = 'password-match mt-1.5 text-xs font-semibold';
                return;
            }

            if (pwd === confirm) {
                matchMsg.textContent = '✓ Kata sandi cocok.';
                matchMsg.className = 'password-match mt-1.5 text-xs font-semibold text-emerald-600';
            } else {
                matchMsg.textContent = '✗ Kata sandi tidak cocok.';
                matchMsg.className = 'password-match mt-1.5 text-xs font-semibold text-red-600';
            }
        }

        pwdInput.addEventListener('input', checkMatch);
        confirmInput.addEventListener('input', checkMatch);

        // Form Submit Handler & Validation
        form.addEventListener('submit', function(e) {
            const pwd = pwdInput.value;
            const confirm = confirmInput.value;

            // 1. Validasi Kombinasi Huruf & Angka
            if (!validatePasswordCombination(pwd)) {
                e.preventDefault();
                requirementError.classList.remove('hidden');
                pwdInput.focus();
                return;
            } else {
                requirementError.classList.add('hidden');
            }

            // 2. Validasi Kecocokan Password
            if (pwd !== confirm) {
                e.preventDefault();
                confirmInput.focus();
                return;
            }

            // 3. Set Loading State
            submitBtn.classList.add('pointer-events-none', 'opacity-90');
            submitBtn.querySelector('.submit-text').classList.add('hidden');
            submitBtn.querySelector('.submit-loading').classList.remove('hidden');
            submitBtn.querySelector('.submit-loading').classList.add('flex');
            const icon = submitBtn.querySelector('svg');
            if (icon) icon.classList.add('hidden');
            submitBtn.disabled = true;
        });
    })();
</script>
@endpush