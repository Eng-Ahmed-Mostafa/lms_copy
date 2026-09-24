<?php

namespace App\Http\Requests\People;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class GuardianStudentRequest extends FormRequest
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
            'student_id' => 'required|exists:students,id',
            'relationship' => 'required|string|max:255',
            'is_primary' => 'nullable|boolean',
            'can_view_grades' => 'nullable|boolean',
            'can_view_attendance' => 'nullable|boolean',
            'can_view_payments' => 'nullable|boolean',
            'can_receive_notifications' => 'nullable|boolean',
        ];
    }
}
