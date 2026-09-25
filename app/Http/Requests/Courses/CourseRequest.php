<?php

namespace App\Http\Requests\Courses;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
            "teacher_id" => [ $isUpdate ? 'nullable' : 'required', 'exists:teachers,id' ],
            "course_category_id" => [ $isUpdate ? 'nullable' : 'required', 'exists:course_categories,id' ],
            "subject_id" => [ $isUpdate ? 'nullable' : 'required', 'exists:subjects,id' ],
            "title" => [ $isUpdate ? 'nullable' : 'required', 'string', 'max:255' ],
            "short_description" => [ $isUpdate ? 'nullable' : 'required', 'string', 'max:500' ],
            "description" => [ $isUpdate ? 'nullable' : 'required', 'string' ],
            "thumbnail" => [ 'nullable', 'string', 'max:255' ],
            "preview_video" => [ 'nullable', 'string', 'max:255' ],
            "price" => [ $isUpdate ? 'nullable' : 'required', 'numeric', 'min:0' ],
            "discount_price" => [ 'nullable', 'numeric', 'min:0' ],
            "duration" => [ $isUpdate ? 'nullable' : 'required', 'integer', 'min:0' ],
            "level" => [ $isUpdate ? 'nullable' : 'required', 'string', 'max:255' ],
            "language" => [ $isUpdate ? 'nullable' : 'required', 'string', 'max:255' ],
            "status" => [ $isUpdate ? 'nullable' : 'required', 'string', 'in:active,inactive' ],
            "approval_status" => [ $isUpdate ? 'nullable' : 'required', 'string', 'in:pending,approved,rejected' ],
            "published_at" => [ 'nullable', 'date' ],
        ];
    }
}
