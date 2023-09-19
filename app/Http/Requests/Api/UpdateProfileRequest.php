<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['nullable', 'email', 'unique:users,email'],
            'phone' => ['nullable', 'unique:users,phone'],
            'address' => ['nullable'],
            'current_password' => ['nullable'],
            'new_password' => ['nullable', 'confirmed'],
        ];
    }
}
