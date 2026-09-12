            @extends('layouts.app') 
            @section('content')
            <div class="min-h-screen flex items-center justify-center bg-slate-50 px-4">
                <div class="max-w-md w-full bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
                    <h2 class="text-xl font-bold text-slate-900 mb-2">Lupa Kata Sandi?</h2>
                    <p class="text-sm text-slate-500 mb-6">Masukkan email kamu dan kami akan mengirimkan link untuk mereset kata sandi.</p>

                    @if (session('status'))
                        <div class="mb-4 text-sm text-emerald-600 bg-emerald-50 p-3 rounded-lg border border-emerald-200">
                            {{ session('status') }}
                        </div>
                    @endif

                        <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Alamat Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                                class="w-full rounded-xl border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                            @error('email')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2.5 rounded-xl transition-colors text-sm">
                            Kirim Link Reset
                        </button>
                    </form>
                </div>
            </div>
            @endsection