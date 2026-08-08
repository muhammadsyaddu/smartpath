<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
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
    'max:150'
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
    'max:20'
],

'kata_sandi' => [
    'required',
    'string',
    'min:8',
    'max:72',
    'confirmed'
],
        ];
    }
}
