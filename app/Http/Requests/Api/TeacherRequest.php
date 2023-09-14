<?php

namespace App\Http\Requests\Api;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class TeacherRequest extends FormRequest
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
            'certificate' => ['required', 'string'],
            'specialty' => ['required', 'string'],
            'birth_date' => ['required','date','before:' . Carbon::today()->format('m/d/Y')],
            'current_location' => ['required', 'string'],
            'permanent_location' => ['required', 'string'],
            'nationality' => ['required', 'string'],
            'department_id' => ['required', 'numeric','exists:departments,id'],
        ];
    }
}
