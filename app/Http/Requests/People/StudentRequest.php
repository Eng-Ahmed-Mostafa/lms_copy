<?php

namespace App\Http\Requests\People;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
            "student_number" => [$isUpdate ? "sometimes" : "required", "string","max:255", "unique:students,student_number," . ($isUpdate ? $this->route('student')?->id : '')],
            "grade_id" => [$isUpdate ? "sometimes" : "required", "integer"],
            "classroom_id" => [$isUpdate ? "sometimes" : "required", "integer"],
            "academic_year_id" => [$isUpdate ? "sometimes" : "required", "integer"],
            "enrollment_date" => ["nullable","date"],
            "status" => [$isUpdate? 'sometimes' : 'required', "in:pending,active,inactive,suspended,graduated"],
        ];
    }
}
