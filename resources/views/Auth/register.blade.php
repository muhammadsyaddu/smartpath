@extends('layouts.guest')

@section('title', 'Daftar Akun')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-white px-4 py-8">
    <div class="w-full max-w-md">

        {{-- Brand --}}
        <div class="flex items-center gap-3 mb-8">
            <div class="w-12 h-12 bg-emerald-600 rounded-2xl flex items-center justify-center shadow-sm">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M12 2.5 20 6v5.5c0 5.1-3.4 8.6-8 10-4.6-1.4-8-4.9-8-10V6l8-3.5Z"/>
                    <path d="m8.2 12 2.3 2.3 5.3-5.3"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Smart<span class="text-emerald-600">Path</span></h1>
                <p class="text-sm text-slate-500 -mt-0.5">Platform Pelaporan Aksesibilitas</p>
            </div>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/60 p-6 sm:p-8">

            {{-- Header --}}
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-slate-800">Buat Akun</h2>
                <p class="text-slate-500 text-sm mt-1">Daftarkan akun Anda untuk mulai melaporkan hambatan aksesibilitas di sekitar Anda.</p>
            </div>

            {{-- General Error Alert --}}
            @if ($errors->any())
                <div class="mb-6 flex items-start gap-3 bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-md" role="alert">
                    <svg class="w-5 h-5 flex-shrink-0 text-red-500" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M12 9v4m0 4h.01M10.3 3.8 2.7 17a2 2 0 0 0 1.7 3h15.2a2 2 0 0 0 1.7-3L13.7 3.8a2 2 0 0 0-3.4 0Z"/>
                    </svg>
                    <div>
                        <strong class="text-sm">Periksa kembali data Anda.</strong>
                        <ul class="text-sm list-disc list-inside mt-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('register.post') }}" class="space-y-5" id="registerForm">
                @csrf

                {{-- 1. Nama Lengkap --}}
                <div>
                    <label for="nama_lengkap" class="block text-sm font-semibold text-slate-700">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <div class="relative mt-1.5">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
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
                            class="w-full pl-10 pr-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 bg-slate-50/50 transition duration-200 @error('nama_lengkap') border-red-500 ring-1 ring-red-500 @enderror"
                            @error('nama_lengkap') aria-invalid="true" @enderror
                        />
                    </div>
                    @error('nama_lengkap')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 2. Email --}}
                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <div class="relative mt-1.5">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
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
                            maxlength="150"
                            required
                            class="w-full pl-10 pr-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 bg-slate-50/50 transition duration-200 @error('email') border-red-500 ring-1 ring-red-500 @enderror"
                            @error('email') aria-invalid="true" @enderror
                        />
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 3. Kata Sandi --}}
                <div>
                    <label for="kata_sandi" class="block text-sm font-semibold text-slate-700">
                        Kata Sandi <span class="text-red-500">*</span>
                    </label>
                    <div class="relative mt-1.5">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
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
                            class="w-full pl-10 pr-12 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 bg-slate-50/50 transition duration-200 @error('kata_sandi') border-red-500 ring-1 ring-red-500 @enderror"
                            @error('kata_sandi') aria-invalid="true" @enderror
                        />
                        <button
                            type="button"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition"
                            data-password-toggle="kata_sandi"
                            aria-label="Tampilkan kata sandi"
                        >
                            <svg class="w-5 h-5 eye-open" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"/>
                                <circle cx="12" cy="12" r="2.5"/>
                            </svg>
                            <svg class="w-5 h-5 eye-closed hidden" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="m3 3 18 18"/>
                                <path d="M10.6 6.2A10.8 10.8 0 0 1 12 6c6 0 9.5 6 9.5 6a16 16 0 0 1-3.2 3.9"/>
                                <path d="M6.3 6.4C3.9 8.2 2.5 12 2.5 12s3.5 6 9.5 6c1.3 0 2.5-.3 3.6-.8"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Indikator kekuatan --}}
                    <div class="mt-2" aria-live="polite">
                        <div class="flex gap-1 h-1.5" id="strengthBars">
                            <span class="flex-1 bg-slate-200 rounded-full transition-all"></span>
                            <span class="flex-1 bg-slate-200 rounded-full transition-all"></span>
                            <span class="flex-1 bg-slate-200 rounded-full transition-all"></span>
                            <span class="flex-1 bg-slate-200 rounded-full transition-all"></span>
                        </div>
                        <p class="text-xs text-slate-500 mt-1.5 strength-text">
                            Min. 8 karakter, kombinasi huruf & angka.
                        </p>
                    </div>

                    @error('kata_sandi')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                    {{-- Pesan error validasi kombinasi huruf & angka --}}
                    <p class="text-xs mt-1 text-red-500 hidden" id="passwordRequirementError">
                        ✗ Kata sandi harus mengandung kombinasi huruf dan angka.
                    </p>
                </div>

                {{-- 4. Konfirmasi Kata Sandi --}}
                <div>
                    <label for="kata_sandi_confirmation" class="block text-sm font-semibold text-slate-700">
                        Konfirmasi Kata Sandi <span class="text-red-500">*</span>
                    </label>
                    <div class="relative mt-1.5">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <rect x="4" y="10" width="16" height="11" rx="2"/>
                                <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
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
                            class="w-full pl-10 pr-12 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 bg-slate-50/50 transition duration-200"
                        />
                        <button
                            type="button"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 transition"
                            data-password-toggle="kata_sandi_confirmation"
                            aria-label="Tampilkan konfirmasi kata sandi"
                        >
                            <svg class="w-5 h-5 eye-open" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"/>
                                <circle cx="12" cy="12" r="2.5"/>
                            </svg>
                            <svg class="w-5 h-5 eye-closed hidden" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="m3 3 18 18"/>
                                <path d="M10.6 6.2A10.8 10.8 0 0 1 12 6c6 0 9.5 6 9.5 6a16 16 0 0 1-3.2 3.9"/>
                                <path d="M6.3 6.4C3.9 8.2 2.5 12 2.5 12s3.5 6 9.5 6c1.3 0 2.5-.3 3.6-.8"/>
                            </svg>
                        </button>
                    </div>
                    <p class="text-xs mt-1.5 password-match" id="passwordMatch" aria-live="polite"></p>
                </div>

                {{-- 5. Nomor HP (Opsional) --}}
                <div>
                    <label for="nomor_hp" class="block text-sm font-semibold text-slate-700">
                        Nomor HP
                        <span class="text-slate-400 font-normal text-xs">Opsional</span>
                    </label>
                    <div class="relative mt-1.5">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
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
                            class="w-full pl-10 pr-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 bg-slate-50/50 transition duration-200 @error('nomor_hp') border-red-500 ring-1 ring-red-500 @enderror"
                            @error('nomor_hp') aria-invalid="true" @enderror
                        />
                    </div>
                    @error('nomor_hp')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 6. Agreement --}}
                <div class="pt-1">
                    <label class="flex items-start gap-2.5 cursor-pointer text-sm text-slate-700">
                        <input type="checkbox" name="agreement" value="1" required class="mt-0.5 w-4 h-4 text-emerald-600 border-slate-300 rounded focus:ring-emerald-500/20 focus:ring-2 focus:ring-offset-0">
                        <span>Saya menyetujui penggunaan data saya untuk keperluan pelaporan dan pengelolaan layanan SmartPath.</span>
                    </label>
                </div>

                {{-- 7. Submit --}}
                <button
                    type="submit"
                    class="w-full bg-emerald-600 hover:bg-emerald-700 active:scale-[0.98] text-white font-semibold py-3 px-6 rounded-xl shadow-sm shadow-emerald-200/50 transition-all duration-200 flex items-center justify-center gap-2 group"
                    id="registerSubmit"
                >
                    <span class="submit-text">Buat Akun</span>
                    <span class="submit-loading hidden items-center gap-2" aria-hidden="true">
                        <span class="inline-block w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                        Membuat akun...
                    </span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M5 12h14"/>
                        <path d="m13 6 6 6-6 6"/>
                    </svg>
                </button>
            </form>

            {{-- Footer --}}
            <div class="mt-6 text-center text-sm text-slate-600">
                <span>Sudah memiliki akun?</span>
                <a href="{{ route('login') }}" class="font-semibold text-emerald-600 hover:text-emerald-800 transition underline-offset-2 hover:underline">Masuk di sini</a>
            </div>
        </div>

        {{-- Security & Copyright --}}
        <div class="mt-8 flex flex-col items-center gap-1 text-sm text-slate-400">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M12 2.5 20 6v5.5c0 5.1-3.4 8.6-8 10-4.6-1.4-8-4.9-8-10V6l8-3.5Z"/>
                    <path d="m8.5 12 2.2 2.2 4.8-4.8"/>
                </svg>
                <span>Data Anda dilindungi dan diproses secara aman.</span>
            </div>
            <p class="text-xs text-slate-400/70">© {{ date('Y') }} SmartPath. All rights reserved.</p>
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

        // Strength label calculation
        function getStrength(score) {
            if (score <= 1) return { level: 1, label: 'Lemah', color: 'red' };
            if (score === 2) return { level: 2, label: 'Sedang', color: 'amber' };
            if (score === 3) return { level: 3, label: 'Kuat', color: 'emerald' };
            if (score >= 4) return { level: 4, label: 'Sangat kuat', color: 'emerald' };
            return { level: 0, label: '', color: 'slate' };
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
                bar.className = 'flex-1 rounded-full transition-all';
                if (idx < strength.level) {
                    bar.classList.add('bg-' + strength.color + '-500');
                } else {
                    bar.classList.add('bg-slate-200');
                }
            });

            if (pwd.length === 0) {
                strengthText.textContent = 'Min. 8 karakter, kombinasi huruf & angka.';
            } else {
                strengthText.textContent = `Kekuatan: ${strength.label}`;
            }

            // Hide requirement error when user types
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
                matchMsg.className = 'text-xs mt-1.5 password-match';
                return;
            }

            if (pwd === confirm) {
                matchMsg.textContent = '✓ Kata sandi cocok.';
                matchMsg.className = 'text-xs mt-1.5 text-emerald-600 password-match';
            } else {
                matchMsg.textContent = '✗ Kata sandi tidak cocok.';
                matchMsg.className = 'text-xs mt-1.5 text-red-500 password-match';
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
            submitBtn.classList.add('loading');
            submitBtn.querySelector('.submit-text').classList.add('hidden');
            submitBtn.querySelector('.submit-loading').classList.remove('hidden');
            submitBtn.querySelector('svg').classList.add('hidden');
            submitBtn.disabled = true;
        });
    })();
</script>
@endpush