<?php

namespace App\Http\Requests\Api\Assessments;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateExamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'course_id' => ['sometimes' , 'required', 'integer', 'exists:courses,id'],
            'title' => ['sometimes' , 'required', 'string', 'max:255'],
            'description' => ['sometimes' , 'nullable', 'string'],
            'duration' => ['sometimes','required', 'integer', 'min:1'],
            'attempts_allowed' => ['sometimes', 'required', 'integer', 'min:1'],
            'passing_score' => ['sometimes', 'required', 'numeric', 'between:0,100'],
            'randomize_questions' => ['sometimes', 'required', 'boolean'],
            'show_correct_answers' => ['sometimes', 'required', 'boolean'],
            'start_time' => ['sometimes', 'nullable', 'date'],
            'end_time' => ['sometimes', 'nullable', 'date', 'after:start_time'],
            'status' => ['sometimes', 'required', Rule::in(['draft', 'published', 'closed', 'archived'])],
        ];
    }
}
