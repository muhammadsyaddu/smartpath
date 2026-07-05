<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLaporanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'judul' => ['sometimes', 'string', 'max:200'],
            'deskripsi' => ['nullable', 'string'],
            'alamat_lengkap' => ['nullable', 'string', 'max:255'],
            'status' => ['sometimes', 'in:menunggu_verifikasi,diverifikasi,ditolak,dalam_perbaikan,selesai,diarsipkan'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'judul.max' => 'Judul laporan maksimal 200 karakter.',
            'status.in' => 'Status tidak valid.',
        ];
    }
}