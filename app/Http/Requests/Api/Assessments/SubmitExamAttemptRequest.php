<?php

namespace App\Http\Requests\Api\Assessments;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SubmitExamAttemptRequest extends FormRequest
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
            'answers' => ['sometimes', 'array'],
            'answers.*.question_id' => ['required_with:answers', 'integer', 'exists:questions,id', 'distinct'],
            'answers.*.option_id' => ['nullable', 'integer', 'exists:options,id'],
            'answers.*.answer_text' => ['nullable', 'string'],
        ];
    }
}
