@extends('layouts.guest')

@section('title', 'Masuk')

@section('content')
<div class="text-center mb-8">
    <div class="flex items-center justify-center gap-2 text-emerald-700 font-semibold text-xl mb-2">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
        SmartPath
    </div>
    <p class="text-sm text-slate-500">Masuk ke platform pemetaan aksesibilitas</p>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8">
    <form method="POST" action="{{ route('login.post') }}" aria-label="Form masuk">
        @csrf

        <div class="space-y-5">
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 focus:outline-none transition-colors"
                    placeholder="nama@email.com" autocomplete="email" aria-required="true">
                @error('email')
                    <p class="mt-1.5 text-sm text-red-600" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="kata_sandi" class="block text-sm font-medium text-slate-700 mb-1.5">Kata Sandi</label>
                <input type="password" id="kata_sandi" name="kata_sandi" required
                    class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 focus:outline-none transition-colors"
                    placeholder="Masukkan kata sandi" autocomplete="current-password" aria-required="true">
                @error('kata_sandi')
                    <p class="mt-1.5 text-sm text-red-600" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" id="remember" name="remember"
                    class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                <label for="remember" class="text-sm text-slate-600">Ingat saya</label>
            </div>

            <button type="submit"
                class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2.5 px-4 rounded-xl transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                Masuk
            </button>
        </div>
    </form>
</div>

<div class="mt-6 text-center">
    <a href="{{ route('beranda') }}" class="text-sm text-slate-500 hover:text-emerald-700 transition-colors">&larr; Kembali ke Beranda</a>
</div>
@endsection