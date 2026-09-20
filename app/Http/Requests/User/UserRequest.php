<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            "first_name" => [$isUpdate ? "sometimes" : "required", "string", "max:255"],
            "last_name" => [$isUpdate ? "sometimes" : "required", "string", "max:255"],
            "email" => [$isUpdate ? "sometimes" : "required", "email", "max:255", Rule::unique('users')->ignore($this->route('id'))],
            "phone" => [$isUpdate ? "sometimes" : "required", "string", "max:20", "unique:users,phone," . $this->route('id')],
            "password" => [$isUpdate ? "sometimes" : "required", "string", "min:8"],
            "avatar" => [$isUpdate ? "sometimes" : "required", "string", "max:255"],
            "gender" => [$isUpdate ? "sometimes" : "required", "string", "in:male,female,other"],
            "date_of_birth" => [$isUpdate ? "sometimes" : "required", "date"],
            "status" => [$isUpdate ? "sometimes" : "required", "string", "in:active,inactive"],
        ];
    }
}
