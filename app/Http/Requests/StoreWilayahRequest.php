<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWilayahRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'induk_id' => ['nullable', 'exists:wilayah,id'],
            'nama' => ['required', 'string', 'max:100'],
            'level' => ['required', 'in:kota_kabupaten,kecamatan,kelurahan'],
            'kode_bps' => ['nullable', 'string', 'max:20', 'unique:wilayah,kode_bps'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'aktif' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama wilayah harus diisi.',
            'level.required' => 'Level wilayah harus dipilih.',
            'level.in' => 'Level wilayah tidak valid.',
            'kode_bps.unique' => 'Kode BPS sudah digunakan.',
        ];
    }
}