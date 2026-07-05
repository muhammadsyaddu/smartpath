<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVerifikasiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isDinas());
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'keputusan' => ['required', 'in:disetujui,ditolak,dikembalikan'],
            'catatan_admin' => ['nullable', 'string', 'max:1000'],
            'kategori_koreksi' => ['nullable', 'exists:kategori_hambatan,id'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'keputusan.required' => 'Keputusan verifikasi harus dipilih.',
            'keputusan.in' => 'Keputusan tidak valid.',
            'catatan_admin.max' => 'Catatan maksimal 1000 karakter.',
        ];
    }
}