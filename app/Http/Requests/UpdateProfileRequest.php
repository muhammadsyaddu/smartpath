<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $userId = auth()->id();

        return [
            'nama_lengkap' => ['sometimes', 'string', 'max:150'],
            'email' => ['sometimes', 'string', 'email', 'max:150', Rule::unique('users', 'email')->ignore($userId)],
            'nomor_hp' => ['nullable', 'string', 'max:20'],
            'foto_profil' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'adalah_disabilitas' => ['nullable', 'boolean'],
            'jenis_disabilitas' => ['nullable', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_lengkap.required' => 'Nama lengkap harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'foto_profil.image' => 'File harus berupa gambar.',
            'foto_profil.max' => 'Ukuran foto profil maksimal 2MB.',
        ];
    }
}
