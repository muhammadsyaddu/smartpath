<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // 1. Menambahkan import Rule

class RegisterUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_lengkap' => [
                'required',
                'string',
                'max:150',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:150',
                Rule::unique('users', 'email'),
            ],

            'nomor_hp' => [
                'nullable',
                'string',
                'max:20',
            ],

            'kata_sandi' => [
                'required',
                'string',
                'min:8',
                'max:72',
                'confirmed',
            ],
        ];
    } // 2. Kurung kurawal ekstra yang merusak struktur class sudah dihapus di sini

    public function messages(): array
    {
        return [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nama_lengkap.string'   => 'Nama lengkap harus berupa teks.',
            'nama_lengkap.max'      => 'Nama lengkap tidak boleh lebih dari :max karakter.',

            'email.required'        => 'Email wajib diisi.',
            'email.string'          => 'Email harus berupa teks.',
            'email.email'           => 'Format email tidak valid.',
            'email.max'             => 'Email tidak boleh lebih dari :max karakter.',
            'email.unique'          => 'Email sudah digunakan.',

            'nomor_hp.string'       => 'Nomor HP harus berupa teks.',
            'nomor_hp.max'          => 'Nomor HP tidak boleh lebih dari :max karakter.',

            'kata_sandi.required'  => 'Kata sandi wajib diisi.',
            'kata_sandi.string'    => 'Kata sandi harus berupa teks.',
            'kata_sandi.min'       => 'Kata sandi minimal 8 karakter.',
            'kata_sandi.max'       => 'Kata sandi tidak boleh lebih dari :max karakter.',
            'kata_sandi.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ];
    }
}