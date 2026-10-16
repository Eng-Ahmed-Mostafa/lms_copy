<?php

namespace App\Http\Requests\Assessments;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class OptionRequest extends FormRequest
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
            "option_text" => ['required', 'string'],
            "is_correct" => ['required', 'boolean'],
            "order" => ['nullable', 'integer'],
        ];
    }
}
