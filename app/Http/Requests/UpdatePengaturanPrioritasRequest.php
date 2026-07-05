<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePengaturanPrioritasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'label' => ['sometimes', 'string', 'max:100'],
            'bobot_keparahan' => ['sometimes', 'numeric', 'between:0,1'],
            'bobot_pelapor' => ['sometimes', 'numeric', 'between:0,1'],
            'bobot_fasilitas' => ['sometimes', 'numeric', 'between:0,1'],
            'radius_deduplikasi_m' => ['nullable', 'integer', 'min:10', 'max:500'],
            'radius_fasilitas_m' => ['nullable', 'integer', 'min:100', 'max:5000'],
            'adalah_aktif' => ['nullable', 'boolean'],
            'catatan' => ['nullable', 'string'],
            'berlaku_sejak' => ['nullable', 'date'],
            'berlaku_hingga' => ['nullable', 'date', 'after:berlaku_sejak'],
        ];
    }

    public function messages(): array
    {
        return [
            'label.required' => 'Label konfigurasi harus diisi.',
            'berlaku_hingga.after' => 'Tanggal berlaku hingga harus setelah berlaku sejak.',
        ];
    }
}