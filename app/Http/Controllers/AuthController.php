<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Audit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function showLoginForm()
    {
        if (auth()->check()) {
            $user = auth()->user();
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            if ($user->isDinas()) {
                return redirect()->route('dinas.dashboard');
            }
            return redirect()->route('beranda');
        }

        return view('auth.login');
    }

    /**
     * Proses autentikasi pengguna lokal.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'kata_sandi' => ['required', 'string'],
        ], [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'kata_sandi.required' => 'Kata sandi harus diisi.',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['kata_sandi'], $user->kata_sandi)) {
            return back()->withErrors([
                'email' => 'Email atau kata sandi salah.',
            ])->onlyInput('email');
        }

        if (!$user->aktif) {
            return back()->withErrors([
                'email' => 'Akun Anda telah dinonaktifkan. Hubungi administrator.',
            ])->onlyInput('email');
        }

        Auth::login($user, $request->boolean('remember'));
        $user->update(['terakhir_masuk' => now()]);

        // Log audit
        Audit::log(
            $user->id,
            'login',
            'users',
            $user->id,
            null,
            null,
            'Pengguna berhasil masuk'
        );

        $request->session()->regenerate();

        if ($user->isAdmin() || $user->isDinas()) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->route($user->getDashboardRouteName());
    }

    /**
     * Tampilkan halaman registrasi.
     */
    public function showRegisterForm(): View|RedirectResponse
    {
        if (auth()->check()) {
            $user = auth()->user();

            if ($user->isAdmin() || $user->isDinas()) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route($user->getDashboardRouteName());
        }

        return view('auth.register');
    }

    /**
     * Proses registrasi akun warga baru.
     */
    public function register(RegisterUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $user = DB::transaction(function () use ($validated) {
            $user = User::create([
                'nama_lengkap' => $validated['nama_lengkap'],
                'email' => $validated['email'],
                'kata_sandi' => Hash::make($validated['kata_sandi']),
                'nomor_hp' => $validated['nomor_hp'] ?? null,
                'peran' => 'warga',
                'email_terverifikasi' => false,
                'aktif' => true,
            ]);

            Audit::log(
                $user->id,
                'registrasi',
                'users',
                $user->id,
                null,
                [
                    'nama_lengkap' => $user->nama_lengkap,
                    'email' => $user->email,
                    'peran' => $user->peran,
                ],
                'Akun warga baru berhasil dibuat'
            );

            return $user;
        });

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()
            ->route('beranda')
            ->with('sukses', 'Akun berhasil dibuat. Selamat datang di SmartPath.');
    }

    /**
     * Redirect ke halaman Google OAuth.
     */
    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback dari Google OAuth.
     */
    public function handleGoogleCallback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = DB::transaction(function () use ($googleUser) {
                // Cari atau buat pengguna berdasarkan email Google
                $existingUser = User::where('email', $googleUser->getEmail())->first();

                if ($existingUser) {
                    if (!$existingUser->aktif) {
                        return null;
                    }

                    // Update google_id jika belum terhubung
                    $existingUser->update([
                        'google_id' => $googleUser->getId(),
                        'email_terverifikasi' => true,
                        'terakhir_masuk' => now(),
                    ]);

                    return $existingUser;
                }

                // Jika akun belum ada, buat akun warga baru secara otomatis
                $newUser = User::create([
                    'nama_lengkap' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'kata_sandi' => Hash::make(Str::random(16)), // Password acak aman
                    'peran' => 'warga',
                    'email_terverifikasi' => true,
                    'aktif' => true,
                    'terakhir_masuk' => now(),
                ]);

                Audit::log(
                    $newUser->id,
                    'registrasi_google',
                    'users',
                    $newUser->id,
                    null,
                    [
                        'nama_lengkap' => $newUser->nama_lengkap,
                        'email' => $newUser->email,
                        'peran' => $newUser->peran,
                    ],
                    'Akun baru berhasil dibuat melalui Google OAuth'
                );

                return $newUser;
            });

            if (!$user) {
                return redirect()->route('login')->withErrors([
                    'email' => 'Akun Anda telah dinonaktifkan. Hubungi administrator.',
                ]);
            }

            Auth::login($user, true);

            Audit::log(
                $user->id,
                'login_google',
                'users',
                $user->id,
                null,
                null,
                'Pengguna berhasil masuk menggunakan Google OAuth'
            );

            request()->session()->regenerate();

            if ($user->isAdmin() || $user->isDinas()) {
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->route($user->getDashboardRouteName())->with('sukses', 'Berhasil masuk menggunakan akun Google!');

        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Gagal masuk menggunakan Google. Silakan coba lagi.',
            ]);
        }
    }

    /**
     * Proses logout pengguna.
     */
    public function logout(Request $request)
    {
        if (auth()->check()) {
            Audit::log(
                auth()->id(),
                'logout',
                'users',
                auth()->id(),
                null,
                null,
                'Pengguna keluar'
            );
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('beranda');
    }
}