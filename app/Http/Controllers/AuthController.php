<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('beranda');
        }

        return view('auth.login');
    }

    /**
     * Proses autentikasi pengguna.
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
        \App\Models\Audit::log(
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

        return redirect()->intended(route('beranda'));
    }

    /**
     * Proses logout pengguna.
     */
    public function logout(Request $request)
    {
        if (auth()->check()) {
            \App\Models\Audit::log(
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