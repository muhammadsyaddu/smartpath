<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKategoriHambatanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'nama' => ['required', 'string', 'max:100'],
            'slug' => ['required', 'string', 'max:100', 'unique:kategori_hambatan,slug'],
            'keterangan' => ['nullable', 'string'],
            'bobot_keparahan' => ['required', 'integer', 'between:0,100'],
            'ikon' => ['nullable', 'string', 'max:100'],
            'warna_penanda' => ['nullable', 'string', 'max:7'],
            'urutan_tampil' => ['nullable', 'integer', 'min:0'],
            'aktif' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama kategori harus diisi.',
            'slug.required' => 'Slug harus diisi.',
            'slug.unique' => 'Slug sudah digunakan.',
            'bobot_keparahan.required' => 'Bobot keparahan harus diisi.',
            'bobot_keparahan.between' => 'Bobot keparahan antara 0-100.',
        ];
    }
}