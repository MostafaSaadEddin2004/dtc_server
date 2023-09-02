<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'content'=>['required', 'string'],
            'attachment'=>['required', 'string'],
            'attachment_type'=>['required', 'string'],
            'user_id'=>['required', 'numeric','exists:users,id'],
            'department_id'=>['required', 'numeric','exists:departments,id'],
            'course_id'=>['required', 'numeric','exists:courses,id'],
            'post_type_id'=>['required', 'numeric','exists:post_types,id'],
        ];
    }
}
