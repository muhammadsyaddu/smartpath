<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daftar Akun - SmartPath</title>
    <style>
        /* Reset & base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: linear-gradient(145deg, #f0f9ff 0%, #e6f7f0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .auth-page {
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .auth-container {
            max-width: 480px;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.75rem;
        }

        /* Brand */
        .auth-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-align: left;
            width: 100%;
        }

        .auth-brand-icon {
            width: 48px;
            height: 48px;
            background: #0d9488;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .auth-brand-icon svg {
            width: 28px;
            height: 28px;
            fill: none;
            stroke: white;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .auth-brand h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.02em;
        }

        .auth-brand h1 span {
            color: #0d9488;
        }

        .auth-brand p {
            font-size: 0.85rem;
            color: #475569;
            margin-top: -2px;
        }

        /* Card */
        .auth-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 20px 60px -12px rgba(0, 0, 0, 0.15);
            padding: 2rem 1.75rem;
            width: 100%;
            transition: box-shadow 0.2s;
        }

        .auth-card-header {
            margin-bottom: 1.75rem;
        }

        .auth-card-header h2 {
            font-size: 1.6rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.35rem;
        }

        .auth-card-header p {
            color: #64748b;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        /* Alert error */
        .auth-alert {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            background: #fef2f2;
            border-left: 4px solid #ef4444;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .auth-alert svg {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
            stroke: #ef4444;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .auth-alert strong {
            color: #991b1b;
            font-size: 0.95rem;
            display: block;
        }

        .auth-alert ul {
            margin-top: 0.25rem;
            padding-left: 1.25rem;
            color: #991b1b;
            font-size: 0.9rem;
        }

        /* Form */
        .auth-form {
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }

        .form-group label {
            font-weight: 600;
            font-size: 0.9rem;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .form-group label span[aria-hidden="true"] {
            color: #ef4444;
        }

        .optional-label {
            font-weight: 400;
            font-size: 0.75rem;
            color: #94a3b8;
            margin-left: 0.25rem;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .input-wrapper:focus-within {
            border-color: #0d9488;
            box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.15);
            background: white;
        }

        .input-wrapper svg {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
            margin: 0 0 0 12px;
            stroke: #94a3b8;
            stroke-width: 2;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .input-wrapper input {
            border: none;
            background: transparent;
            padding: 0.75rem 12px 0.75rem 10px;
            width: 100%;
            font-size: 0.95rem;
            color: #0f172a;
            outline: none;
        }

        .input-wrapper input::placeholder {
            color: #94a3b8;
        }

        .input-password {
            padding-right: 4px;
        }

        .password-toggle {
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 0 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            transition: color 0.2s;
            flex-shrink: 0;
        }

        .password-toggle:hover {
            color: #475569;
        }

        .password-toggle svg {
            width: 20px;
            height: 20px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .password-toggle .eye-closed {
            display: none;
        }

        .password-toggle.show .eye-open {
            display: none;
        }

        .password-toggle.show .eye-closed {
            display: block;
        }

        .field-error {
            font-size: 0.8rem;
            color: #ef4444;
            margin-top: 0.2rem;
        }

        /* Password strength */
        .password-strength {
            margin-top: 0.3rem;
        }

        .strength-bar {
            display: flex;
            gap: 4px;
            height: 4px;
            margin-bottom: 4px;
        }

        .strength-bar span {
            flex: 1;
            background: #e2e8f0;
            border-radius: 4px;
            transition: background 0.3s;
        }

        .strength-bar span.active {
            background: #ef4444;
        }
        .strength-bar span.active.medium {
            background: #f59e0b;
        }
        .strength-bar span.active.strong {
            background: #10b981;
        }

        .strength-text {
            font-size: 0.75rem;
            color: #64748b;
        }

        .password-match {
            font-size: 0.8rem;
            min-height: 1.2rem;
            margin-top: 0.2rem;
        }

        .password-match.match {
            color: #10b981;
        }

        .password-match.not-match {
            color: #ef4444;
        }

        /* Agreement */
        .auth-agreement {
            margin: 0.25rem 0 0.5rem;
        }

        .checkbox-label {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
            cursor: pointer;
            font-size: 0.9rem;
            color: #334155;
            line-height: 1.4;
        }

        .checkbox-label input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-top: 1px;
            accent-color: #0d9488;
            flex-shrink: 0;
            cursor: pointer;
        }

        /* Submit button */
        .auth-submit {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            background: #0d9488;
            color: white;
            border: none;
            border-radius: 12px;
            padding: 0.85rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
            width: 100%;
            position: relative;
        }

        .auth-submit:hover {
            background: #0f766e;
        }

        .auth-submit:active {
            transform: scale(0.98);
        }

        .auth-submit svg {
            width: 22px;
            height: 22px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
            transition: transform 0.2s;
        }

        .auth-submit:hover svg {
            transform: translateX(4px);
        }

        .submit-loading {
            display: none;
            align-items: center;
            gap: 0.5rem;
        }

        .auth-submit.loading .submit-text {
            display: none;
        }

        .auth-submit.loading .submit-loading {
            display: flex;
        }

        .auth-submit.loading svg {
            display: none;
        }

        .loading-spinner {
            width: 20px;
            height: 20px;
            border: 2.5px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Footer */
        .auth-footer {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 0.95rem;
            color: #475569;
        }

        .auth-footer a {
            color: #0d9488;
            font-weight: 600;
            text-decoration: none;
            margin-left: 0.25rem;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        /* Security & copyright */
        .auth-security {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8rem;
            color: #64748b;
        }

        .auth-security svg {
            width: 18px;
            height: 18px;
            stroke: #0d9488;
            stroke-width: 2;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
            flex-shrink: 0;
        }

        .auth-copyright {
            font-size: 0.7rem;
            color: #94a3b8;
            margin-top: 0.25rem;
        }

        /* Responsive */
        @media (max-width: 500px) {
            .auth-card {
                padding: 1.5rem 1rem;
            }
            .auth-brand h1 {
                font-size: 1.5rem;
            }
            .auth-card-header h2 {
                font-size: 1.4rem;
            }
        }
    </style>
</head>
<body>
    <div class="auth-page">
        <div class="auth-container">

            <!-- Brand -->
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

            <!-- Register Card -->
            <div class="auth-card">
                <div class="auth-card-header">
                    <h2>Buat Akun</h2>
                    <p>Daftarkan akun Anda untuk mulai melaporkan hambatan aksesibilitas di sekitar Anda.</p>
                </div>

                <!-- General Error (contoh, bisa dihapus jika tidak ingin) -->
                <div class="auth-alert" role="alert" style="display:none;">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12 9v4m0 4h.01M10.3 3.8 2.7 17a2 2 0 0 0 1.7 3h15.2a2 2 0 0 0 1.7-3L13.7 3.8a2 2 0 0 0-3.4 0Z"/>
                    </svg>
                    <div>
                        <strong>Periksa kembali data Anda.</strong>
                        <ul>
                            <li>Nama lengkap harus diisi.</li>
                            <li>Email tidak valid.</li>
                        </ul>
                    </div>
                </div>

                <form class="auth-form" id="registerForm" onsubmit="event.preventDefault(); alert('Form dikirim (demo)');">
                    <!-- Nama -->
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
                                value=""
                                placeholder="Masukkan nama lengkap"
                                autocomplete="name"
                                maxlength="150"
                                required
                                autofocus
                            />
                        </div>
                        <!-- error field contoh (sembunyi) -->
                        <p class="field-error" style="display:none;">Nama lengkap wajib diisi.</p>
                    </div>

                    <!-- Email -->
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
                                value=""
                                placeholder="nama@email.com"
                                autocomplete="email"
                                maxlength="150"
                                required
                            />
                        </div>
                    </div>

                    <!-- Nomor HP -->
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
                                value=""
                                placeholder="08xxxxxxxxxx"
                                autocomplete="tel"
                                maxlength="20"
                                inputmode="tel"
                            />
                        </div>
                    </div>

                    <!-- Password -->
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
                            <span class="strength-text">Gunakan minimal 8 karakter.</span>
                        </div>
                        <!-- error field password (sembunyi) -->
                        <p class="field-error" style="display:none;">Kata sandi harus minimal 8 karakter.</p>
                    </div>

                    <!-- Konfirmasi Password -->
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
                        <p class="password-match" id="passwordMatch" aria-live="polite"></p>
                    </div>

                    <!-- Agreement -->
                    <div class="auth-agreement">
                        <label class="checkbox-label">
                            <input type="checkbox" name="agreement" value="1" required />
                            <span>
                                Saya menyetujui penggunaan data saya untuk
                                keperluan pelaporan dan pengelolaan layanan
                                SmartPath.
                            </span>
                        </label>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="auth-submit" id="registerSubmit">
                        <span class="submit-text">Buat Akun</span>
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

                <div class="auth-footer">
                    <span>Sudah memiliki akun?</span>
                    <a href="{{ route('login') }}">Masuk di sini</a>
                </div>
            </div>

            <!-- Security & Copyright -->
            <div class="auth-security">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 2.5 20 6v5.5c0 5.1-3.4 8.6-8 10-4.6-1.4-8-4.9-8-10V6l8-3.5Z"/>
                    <path d="m8.5 12 2.2 2.2 4.8-4.8"/>
                </svg>
                <span>Data Anda dilindungi dan diproses secara aman.</span>
            </div>
            <div class="auth-copyright">
                © 2026 SmartPath. All rights reserved.
            </div>

        </div>
    </div>

    <script>
        (function() {
            // --- Toggle password visibility ---
            document.querySelectorAll('.password-toggle').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const inputId = this.getAttribute('data-password-toggle');
                    const input = document.getElementById(inputId);
                    if (!input) return;
                    // Toggle type
                    if (input.type === 'password') {
                        input.type = 'text';
                        this.classList.add('show');
                    } else {
                        input.type = 'password';
                        this.classList.remove('show');
                    }
                });
            });

            // --- Password strength indicator ---
            const passwordInput = document.getElementById('kata_sandi');
            const strengthBars = document.querySelectorAll('.strength-bar span');
            const strengthText = document.querySelector('.strength-text');

            function checkStrength(password) {
                let score = 0;
                if (password.length >= 8) score++;
                if (password.length >= 12) score++;
                if (/[a-z]/.test(password) && /[A-Z]/.test(password)) score++;
                if (/\d/.test(password) && /[^a-zA-Z0-9]/.test(password)) score++;
                // Normalize to 0-4
                score = Math.min(score, 4);
                return score;
            }

            passwordInput.addEventListener('input', function() {
                const pwd = this.value;
                const score = checkStrength(pwd);
                // Update bars
                strengthBars.forEach(function(bar, index) {
                    bar.className = '';
                    if (index < score) {
                        bar.classList.add('active');
                        if (score === 1) bar.classList.add('medium'); // or weak
                        else if (score === 2) bar.classList.add('medium');
                        else if (score >= 3) bar.classList.add('strong');
                    }
                });
                // Update text
                let msg = '';
                if (pwd.length === 0) {
                    msg = 'Gunakan minimal 8 karakter.';
                } else if (score === 0) {
                    msg = 'Terlalu pendek.';
                } else if (score === 1) {
                    msg = 'Lemah – tambahkan huruf besar, angka, atau simbol.';
                } else if (score === 2) {
                    msg = 'Sedang – tambahkan variasi karakter.';
                } else if (score === 3) {
                    msg = 'Kuat!';
                } else {
                    msg = 'Sangat kuat!';
                }
                strengthText.textContent = msg;
            });

            // --- Password match confirmation ---
            const confirmInput = document.getElementById('kata_sandi_confirmation');
            const matchMsg = document.getElementById('passwordMatch');

            function checkMatch() {
                const pwd = passwordInput.value;
                const confirm = confirmInput.value;
                if (confirm.length === 0) {
                    matchMsg.textContent = '';
                    matchMsg.className = 'password-match';
                    return;
                }
                if (pwd === confirm) {
                    matchMsg.textContent = '✓ Kata sandi cocok.';
                    matchMsg.className = 'password-match match';
                } else {
                    matchMsg.textContent = '✗ Kata sandi tidak cocok.';
                    matchMsg.className = 'password-match not-match';
                }
            }

            passwordInput.addEventListener('input', checkMatch);
            confirmInput.addEventListener('input', checkMatch);

            // --- Submit loading state ---
            const form = document.getElementById('registerForm');
            const submitBtn = document.getElementById('registerSubmit');

            form.addEventListener('submit', function(e) {
                // Prevent real submit for demo
                e.preventDefault();
                // Show loading
                submitBtn.classList.add('loading');
                submitBtn.disabled = true;

                // Simulate async process
                setTimeout(function() {
                    alert('Pendaftaran berhasil (demo).');
                    submitBtn.classList.remove('loading');
                    submitBtn.disabled = false;
                }, 1500);
            });

            // Optional: show general error alert for demo (hide by default)
            // You can uncomment if you want to see error style
            // document.querySelector('.auth-alert').style.display = 'flex';
        })();
    </script>

</body>
</html>