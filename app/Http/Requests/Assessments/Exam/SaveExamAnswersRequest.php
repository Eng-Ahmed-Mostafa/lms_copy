<?php

namespace App\Http\Requests\Assessments\Exam;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SaveExamAnswersRequest extends FormRequest
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
            "answers" => "required|array|min:1",
            "answers.*.question_id" => "required|integer|min:1|distinct|exists:questions,id",
            "answers.*.question_option_id" => "required|integer|min:1|exists:question_options,id",
        ];
    }
}
