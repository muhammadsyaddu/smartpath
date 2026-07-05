<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFasilitasPublikRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'nama' => ['sometimes', 'string', 'max:150'],
            'jenis' => ['sometimes', 'in:rumah_sakit,puskesmas,sekolah,perguruan_tinggi,halte,stasiun,terminal,kantor_pemerintah,pasar,tempat_ibadah,lainnya'],
            'wilayah_id' => ['nullable', 'exists:wilayah,id'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'latitude' => ['sometimes', 'numeric', 'between:-90,90'],
            'longitude' => ['sometimes', 'numeric', 'between:-180,180'],
            'bobot_vital' => ['nullable', 'integer', 'between:0,100'],
            'sumber_data' => ['nullable', 'in:osm,pemerintah,manual'],
            'osm_id' => ['nullable', 'string', 'max:50'],
            'aktif' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama fasilitas harus diisi.',
            'jenis.in' => 'Jenis fasilitas tidak valid.',
        ];
    }
}