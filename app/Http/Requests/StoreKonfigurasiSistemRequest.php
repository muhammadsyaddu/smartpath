<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKonfigurasiSistemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'kunci' => ['required', 'string', 'max:100', 'unique:konfigurasi_sistem,kunci'],
            'nilai' => ['required', 'string'],
            'tipe_nilai' => ['required', 'in:teks,angka,desimal,boolean,json'],
            'keterangan' => ['nullable', 'string', 'max:255'],
            'dapat_diedit_ui' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'kunci.required' => 'Kunci konfigurasi harus diisi.',
            'kunci.unique' => 'Kunci konfigurasi sudah ada.',
            'nilai.required' => 'Nilai konfigurasi harus diisi.',
            'tipe_nilai.required' => 'Tipe nilai harus dipilih.',
            'tipe_nilai.in' => 'Tipe nilai tidak valid.',
        ];
    }
}