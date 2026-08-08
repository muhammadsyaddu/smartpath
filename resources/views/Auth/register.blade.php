```blade
@extends('layouts.guest')

@section('title', 'Daftar Akun')

@section('content')
<div class="auth-page">
    <div class="auth-container">

        {{-- Brand --}}
        <div class="auth-brand">
            <div class="auth-brand-icon">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 2.5 20 6v5.5c0 5.1-3.4 8.6-8 10-4.6-1.4-8-4.9-8-10V6l8-3.5Z"/>
                    <path d="m8.2 12 2.3 2.3 5.3-5.3"/>
                </svg>
            </div>

            <div>
                <h1>Smart<span>Path</span></h1>
                <p>Platform Pelaporan Aksesibilitas</p>
            </div>
        </div>

        {{-- Register Card --}}
        <div class="auth-card">

            <div class="auth-card-header">
                <h2>Buat Akun</h2>
                <p>
                    Daftarkan akun Anda untuk mulai melaporkan
                    hambatan aksesibilitas di sekitar Anda.
                </p>
            </div>

            {{-- General Error --}}
            @if ($errors->any())
                <div class="auth-alert auth-alert-error" role="alert">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12 9v4m0 4h.01M10.3 3.8 2.7 17a2 2 0 0 0 1.7 3h15.2a2 2 0 0 0 1.7-3L13.7 3.8a2 2 0 0 0-3.4 0Z"/>
                    </svg>

                    <div>
                        <strong>Periksa kembali data Anda.</strong>

                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form
                method="POST"
                action="{{ route('register.post') }}"
                class="auth-form"
                id="registerForm"
            >
                @csrf

                {{-- Nama --}}
                <div class="form-group">
                    <label for="nama_lengkap">
                        Nama Lengkap
                        <span aria-hidden="true">*</span>
                    </label>

                    <div class="input-wrapper">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M20 21a8 8 0 0 0-16 0"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>

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
                            @error('nama_lengkap') aria-invalid="true" @enderror
                        />
                    </div>

                    @error('nama_lengkap')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label for="email">
                        Email
                        <span aria-hidden="true">*</span>
                    </label>

                    <div class="input-wrapper">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <rect x="3" y="5" width="18" height="14" rx="2"/>
                            <path d="m3 7 9 6 9-6"/>
                        </svg>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="nama@email.com"
                            autocomplete="email"
                            maxlength="150"
                            required
                            @error('email') aria-invalid="true" @enderror
                        />
                    </div>

                    @error('email')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nomor HP --}}
                <div class="form-group">
                    <label for="nomor_hp">
                        Nomor HP
                        <span class="optional-label">Opsional</span>
                    </label>

                    <div class="input-wrapper">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <rect x="6" y="2.5" width="12" height="19" rx="2"/>
                            <path d="M10 18.5h4"/>
                        </svg>

                        <input
                            type="tel"
                            id="nomor_hp"
                            name="nomor_hp"
                            value="{{ old('nomor_hp') }}"
                            placeholder="08xxxxxxxxxx"
                            autocomplete="tel"
                            maxlength="20"
                            inputmode="tel"
                            @error('nomor_hp') aria-invalid="true" @enderror
                        />
                    </div>

                    @error('nomor_hp')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label for="kata_sandi">
                        Kata Sandi
                        <span aria-hidden="true">*</span>
                    </label>

                    <div class="input-wrapper input-password">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <rect x="4" y="10" width="16" height="11" rx="2"/>
                            <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
                        </svg>

                        <input
                            type="password"
                            id="kata_sandi"
                            name="kata_sandi"
                            placeholder="Minimal 8 karakter"
                            autocomplete="new-password"
                            minlength="8"
                            maxlength="72"
                            required
                            @error('kata_sandi') aria-invalid="true" @enderror
                        />

                        <button
                            type="button"
                            class="password-toggle"
                            data-password-toggle="kata_sandi"
                            aria-label="Tampilkan kata sandi"
                        >
                            <svg class="eye-open" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"/>
                                <circle cx="12" cy="12" r="2.5"/>
                            </svg>

                            <svg class="eye-closed" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="m3 3 18 18"/>
                                <path d="M10.6 6.2A10.8 10.8 0 0 1 12 6c6 0 9.5 6 9.5 6a16 16 0 0 1-3.2 3.9"/>
                                <path d="M6.3 6.4C3.9 8.2 2.5 12 2.5 12s3.5 6 9.5 6c1.3 0 2.5-.3 3.6-.8"/>
                            </svg>
                        </button>
                    </div>

                    <div class="password-strength" aria-live="polite">
                        <div class="strength-bar">
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>

                        <span class="strength-text">
                            Gunakan minimal 8 karakter.
                        </span>
                    </div>

                    @error('kata_sandi')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="form-group">
                    <label for="kata_sandi_confirmation">
                        Konfirmasi Kata Sandi
                        <span aria-hidden="true">*</span>
                    </label>

                    <div class="input-wrapper input-password">
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <rect x="4" y="10" width="16" height="11" rx="2"/>
                            <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
                        </svg>

                        <input
                            type="password"
                            id="kata_sandi_confirmation"
                            name="kata_sandi_confirmation"
                            placeholder="Masukkan ulang kata sandi"
                            autocomplete="new-password"
                            minlength="8"
                            maxlength="72"
                            required
                        />

                        <button
                            type="button"
                            class="password-toggle"
                            data-password-toggle="kata_sandi_confirmation"
                            aria-label="Tampilkan konfirmasi kata sandi"
                        >
                            <svg class="eye-open" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"/>
                                <circle cx="12" cy="12" r="2.5"/>
                            </svg>

                            <svg class="eye-closed" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="m3 3 18 18"/>
                                <path d="M10.6 6.2A10.8 10.8 0 0 1 12 6c6 0 9.5 6 9.5 6a16 16 0 0 1-3.2 3.9"/>
                                <path d="M6.3 6.4C3.9 8.2 2.5 12 2.5 12s3.5 6 9.5 6c1.3 0 2.5-.3 3.6-.8"/>
                            </svg>
                        </button>
                    </div>

                    <p
                        class="password-match"
                        id="passwordMatch"
                        aria-live="polite"
                    ></p>
                </div>

                {{-- Agreement --}}
                <div class="auth-agreement">
                    <label class="checkbox-label">
                        <input
                            type="checkbox"
                            name="agreement"
                            value="1"
                            required
                        >

                        <span>
                            Saya menyetujui penggunaan data saya untuk
                            keperluan pelaporan dan pengelolaan layanan
                            SmartPath.
                        </span>
                    </label>
                </div>

                {{-- Submit --}}
                <button
                    type="submit"
                    class="auth-submit"
                    id="registerSubmit"
                >
                    <span class="submit-text">
                        Buat Akun
                    </span>

                    <span class="submit-loading" aria-hidden="true">
                        <span class="loading-spinner"></span>
                        Membuat akun...
                    </span>

                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M5 12h14"/>
                        <path d="m13 6 6 6-6 6"/>
                    </svg>
                </button>
            </form>

            {{-- Login --}}
            <div class="auth-footer">
                <span>Sudah memiliki akun?</span>

                <a href="{{ route('login') }}">
                    Masuk di sini
                </a>
            </div>
        </div>

        {{-- Security --}}
        <div class="auth-security">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 2.5 20 6v5.5c0 5.1-3.4 8.6-8 10-4.6-1.4-8-4.9-8-10V6l8-3.5Z"/>
                <path d="m8.5 12 2.2 2.2 4.8-4.8"/>
            </svg>

            <span>
                Data Anda dilindungi dan diproses secara aman.
            </span>
        </div>

        <div class="auth-copyright">
            © {{ date('Y') }} SmartPath. All rights reserved.
        </div>

    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/auth-register.js') }}" defer></script>
@endpush

