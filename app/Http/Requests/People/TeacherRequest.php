<?php

namespace App\Http\Requests\People;

use Illuminate\Contracts\Validation\ValidationRule;
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $isUpdate = $this->isMethod("put") || $this->isMethod("patch");
        return [
            "user_id" => [$isUpdate ? "sometimes" : "required", "integer"],
            "employee_number" => [$isUpdate ? "sometimes" : "required", "string","max:255"],
            "bio" => ["nullable","string"],
            "qualification" => ["nullable","string"],
            "specialization" => ["nullable","string"],
            "experience_years" => ["nullable","integer"],
            "hire_date" => ["nullable","date"],
            "status" => [$isUpdate ? "sometimes" : "required", "in:active,inactive"],
        ];
    }
}
