<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateKategoriHambatanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        $kategoriHambatanId = $this->route('kategori_hambatan') ?? $this->route('kategoriHambatan');

        return [
            'nama' => ['sometimes', 'string', 'max:100'],
            'slug' => ['sometimes', 'string', 'max:100', Rule::unique('kategori_hambatan', 'slug')->ignore($kategoriHambatanId)],
            'keterangan' => ['nullable', 'string'],
            'bobot_keparahan' => ['sometimes', 'integer', 'between:0,100'],
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
            'slug.unique' => 'Slug sudah digunakan.',
            'bobot_keparahan.between' => 'Bobot keparahan antara 0-100.',
        ];
    }
}