<?php

namespace App\Http\Requests;

use App\Models\KonfigurasiSistem;
use Illuminate\Foundation\Http\FormRequest;


class StoreLaporanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (!auth()->check()) {
            return false;
        }

        $user = auth()->user();

        return $user->isWarga() || $user->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $maxFoto = (int) KonfigurasiSistem::getValue('max_foto_per_laporan', 5);

        return [
            'kategori_hambatan_id' => ['required', 'exists:kategori_hambatan,id'],
            'wilayah_id' => ['nullable', 'exists:wilayah,id'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'alamat_lengkap' => ['nullable', 'string', 'max:255'],
            'judul' => ['required', 'string', 'max:200'],
            'deskripsi' => ['nullable', 'string'],
            'sumber_koordinat' => ['nullable', 'in:gps_otomatis,manual'],
            'foto' => ['required', 'array', 'min:1', "max:{$maxFoto}"],
            'foto.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'kategori_hambatan_id.required' => 'Kategori hambatan harus dipilih.',
            'kategori_hambatan_id.exists' => 'Kategori hambatan tidak valid.',
            'latitude.required' => 'Lokasi (latitude) harus ditentukan.',
            'longitude.required' => 'Lokasi (longitude) harus ditentukan.',
            'judul.required' => 'Judul laporan harus diisi.',
            'judul.max' => 'Judul laporan maksimal 200 karakter.',
            'foto.required' => 'Minimal satu foto harus diunggah.',
            'foto.min' => 'Minimal satu foto harus diunggah.',
            'foto.max' => 'Maksimal ' . KonfigurasiSistem::getValue('max_foto_per_laporan', 5) . ' foto dapat diunggah.',
            'foto.*.image' => 'File harus berupa gambar.',
            'foto.*.mimes' => 'Format gambar harus JPEG, PNG, JPG, atau WebP.',
            'foto.*.max' => 'Ukuran setiap foto maksimal 5MB.',
        ];
    }
}