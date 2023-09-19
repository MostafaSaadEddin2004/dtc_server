<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreAcademicRegisterationRequest extends FormRequest
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
            'full_name' => ['required'],
            'father_name' => ['required'],
            'mother_name' => ['required'],
            'date_of_birth' => ['required', 'date'],
            'place_of_birth' => ['required'],
            'military' => ['required'],
            'full_name_en' => ['required'],
            'current_address' => ['required'],
            'address' => ['required'],
            'name_of_parent' => ['required'],
            'job_of_parent' => ['required'],
            'phone_of_parent' => ['required'],
            'phone_of_mother' => ['required'],
            'telephone_fix' => ['required'],
            'avg_mark' => ['required', 'integer'],
            'certificate_year' => ['required'],
            'id_image' => ['required', 'image'],
            'certificate_image' => ['required', 'image'],
            'personal_image' => ['required', 'image'],
            'un_image' => ['required', 'image'],
            'department_ids' => ['required', 'array'],
        ];
    }
}
