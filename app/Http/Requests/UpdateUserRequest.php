<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        $userId = $this->route('user');

        return [
            'nama_lengkap' => ['sometimes', 'string', 'max:150'],
            'email' => ['sometimes', 'string', 'email', 'max:150', Rule::unique('users', 'email')->ignore($userId)],
            'kata_sandi' => ['nullable', 'string', 'min:8', 'confirmed'],
            'nomor_hp' => ['nullable', 'string', 'max:20'],
            'peran' => ['sometimes', 'in:warga,administrator,dinas'],
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
            'email.unique' => 'Email sudah digunakan.',
            'kata_sandi.min' => 'Kata sandi minimal 8 karakter.',
            'kata_sandi.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'peran.in' => 'Peran tidak valid.',
        ];
    }
}