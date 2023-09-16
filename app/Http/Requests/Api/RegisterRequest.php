<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'first_name_en' => ['required', 'string'],
            'last_name_en' => ['required', 'string'],
            'first_name_ar' => ['required', 'string'],
            'last_name_ar' => ['required', 'string'],
            'phone' => ['required', 'string', 'unique:users,phone'],
            'email' => ['required', 'string', 'unique:users,email', 'email'],
            'password' => ['required', 'string'],
            'role' => ['required', 'string', 'in:student,teacher,student_browser,teacher_browser'],
            'image'=>['nullable','image'],
            'fcm_token' => ['required'],
        ];
    }
}
