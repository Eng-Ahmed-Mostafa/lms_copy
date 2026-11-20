<?php

namespace App\Http\Requests\Assignments;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AssignmentRequest extends FormRequest
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
            "course_id" => ['required', 'integer', 'exists:courses,id'],
            "teacher_id" => ['required', 'integer', 'exists:teachers,id'],
            "title" => ['required', 'string', 'max:255'],
            "description" => ['nullable', 'string'],
            "due_date" => ['nullable', 'date'],
            "max_score" => ['nullable', 'numeric'],
        ];
    }
}
