<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'nama_lengkap' => ['required', 'string', 'max:150'],
            'email' => ['required', 'string', 'email', 'max:150', 'unique:users,email'],
            'kata_sandi' => ['required', 'string', 'min:8', 'confirmed'],
            'nomor_hp' => ['nullable', 'string', 'max:20'],
            'peran' => ['required', 'in:warga,administrator,dinas'],
            'wilayah_id' => ['nullable', 'exists:wilayah,id'],
            'adalah_disabilitas' => ['nullable', 'boolean'],
            'jenis_disabilitas' => ['nullable', 'string', 'max:100'],
            'aktif' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_lengkap.required' => 'Nama lengkap harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'kata_sandi.required' => 'Kata sandi harus diisi.',
            'kata_sandi.min' => 'Kata sandi minimal 8 karakter.',
            'kata_sandi.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'peran.required' => 'Peran harus dipilih.',
            'peran.in' => 'Peran tidak valid.',
        ];
    }
}