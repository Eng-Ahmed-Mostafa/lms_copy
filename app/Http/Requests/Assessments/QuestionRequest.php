<?php

namespace App\Http\Requests\Assessments;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
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
            'type' => 'required|string|in:multiple_choice,true_false,short_answer,essay',
            'question_text' => 'required|string',
            'explanation' => 'nullable|string',
            'points' => 'required|numeric|min:0',
            'difficulty' => 'nullable|in:easy,medium,hard',
            'status' => 'required|in:active,inactive',
        ];
    }
}
