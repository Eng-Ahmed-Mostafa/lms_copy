<?php

namespace App\Http\Requests\Assessments;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ExamRequest extends FormRequest
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
            "course_id" => "required|exists:courses,id",
            "title" => "required|string|max:255",
            "description" => "nullable|string",
            "duration" => "required|integer|min:1",
            "attempts_allowed" => "required|integer|min:1",
            "passing_score" => "required|numeric|min:0|max:100",
            "randomize_questions" => "required|boolean",
            "show_correct_answers" => "required|boolean",
        ];
    }
}
