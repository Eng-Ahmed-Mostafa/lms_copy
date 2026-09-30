<?php

namespace App\Http\Requests\Courses;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class LessonContentRequest extends FormRequest
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
            "lesson_version_id" => ['required', 'exists:lesson_versions,id'],
            "type" => ['required', 'in:text,video,file'],
            "content" => ['nullable', 'string'],
            "video_url" => ['nullable', 'string', 'max:1000', 'required_if:type,video'],
            "duration" => ['nullable', 'integer', 'min:0'],
            "order" => ['nullable', 'integer'],
            "metadata" => ['nullable', 'array'],
            "metadata.*" => ['nullable'],
            "file" => ['nullable', 'file', 'max:10240', 'required_if:type,file'],
        ];
    }
}
