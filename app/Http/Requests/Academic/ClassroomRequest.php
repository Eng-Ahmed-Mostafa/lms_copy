<?php

namespace App\Http\Requests\Academic;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ClassroomRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:classrooms,code,' . $this->route('id'),
            'grade_id' => 'required|exists:grades,id',
            'status' => 'nullable|in:active,inactive,archived',
            'academic_year_id' => 'required|exists:academic_years,id',
            'capacity' => 'nullable|integer|min:1',
        ];
    }
}
