<?php

namespace App\Http\Requests\Academic;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubjectRequest extends FormRequest
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
            "name" => ["required","string","max:255"],
            "code" => ["required","string","max:255", Rule::unique('subjects','code')->ignore($this->route('slug'), 'slug')],
            "description" => ["nullable","string"],
            "icon" => ["nullable","string","max:255"],
            "status" => ["required","in:active,inactive"],
        ];
    }
}
