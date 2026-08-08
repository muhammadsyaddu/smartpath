'use strict';

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Password visibility
    |--------------------------------------------------------------------------
    */

    const passwordInput = document.getElementById('kata_sandi');
    const togglePassword = document.getElementById('toggle-password');
    const passwordEye = document.getElementById('password-eye');

    if (passwordInput && togglePassword) {

        togglePassword.addEventListener('click', function () {

            const isPassword =
                passwordInput.getAttribute('type') === 'password';

            passwordInput.setAttribute(
                'type',
                isPassword ? 'text' : 'password'
            );

            togglePassword.setAttribute(
                'aria-pressed',
                isPassword ? 'true' : 'false'
            );

            togglePassword.setAttribute(
                'aria-label',
                isPassword
                    ? 'Sembunyikan kata sandi'
                    : 'Tampilkan kata sandi'
            );

            if (passwordEye) {

                if (isPassword) {

                    passwordEye.innerHTML = `
                        <path
                            d="M3 3l18 18"
                        ></path>

                        <path
                            d="M10.58 10.58a2 2 0 002.83 2.83"
                        ></path>

                        <path
                            d="M9.88 5.09A10.94 10.94 0 0112 4.75c5 0 8.27 4.5 9 7.25a10.78 10.78 0 01-2.01 3.61"
                        ></path>

                        <path
                            d="M6.61 6.61C4.17 8.09 2.74 10.54 2 12c.73 2.75 4 7.25 9 7.25 1.61 0 3.04-.36 4.29-.94"
                        ></path>
                    `;

                } else {

                    passwordEye.innerHTML = `
                        <path
                            d="M2.062 12.348a1 1 0 010-.696 10.75 10.75 0 0119.876 0 1 1 0 010 .696 10.75 10.75 0 01-19.876 0z"
                        ></path>

                        <circle
                            cx="12"
                            cy="12"
                            r="3"
                        ></circle>
                    `;
                }
            }

        });
    }


    /*
    |--------------------------------------------------------------------------
    | Login submit state
    |--------------------------------------------------------------------------
    |
    | Hanya mengubah UI.
    | Tidak mengirim data melalui JavaScript.
    | Form tetap menggunakan POST Laravel biasa.
    |
    */

    const loginForm = document.getElementById('login-form');
    const loginSubmit = document.getElementById('login-submit');
    const loginSubmitText = document.getElementById('login-submit-text');
    const loginSpinner = document.getElementById('login-spinner');

    if (
        loginForm &&
        loginSubmit &&
        loginSubmitText &&
        loginSpinner
    ) {

        loginForm.addEventListener('submit', function () {

            loginSubmit.disabled = true;

            loginSubmitText.textContent = 'Memproses...';

            loginSpinner.classList.remove('hidden');

        });
    }


    /*
    |--------------------------------------------------------------------------
    | Prevent accidental double submission
    |--------------------------------------------------------------------------
    */

    if (loginForm) {

        let submitted = false;

        loginForm.addEventListener('submit', function (event) {

            if (submitted) {

                event.preventDefault();

                return false;
            }

            submitted = true;

        });
    }

});