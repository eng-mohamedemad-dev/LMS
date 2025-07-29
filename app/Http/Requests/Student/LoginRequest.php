<?php

namespace App\Http\Requests\Student;


use App\Http\Requests\BaseRequest;


class LoginRequest extends BaseRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "email" => "required|email|exists:students,email",
            "password" => "required|string",
            "device_token" => "required|string|min:142|max:142"
        ];
    }
    public function messages(): array
    {
        return [
            "email.required" => "البريد الإلكتروني مطلوب",
            "email.email" => "البريد الإلكتروني غير صالح",
            "email.exists" => "البريد الإلكتروني غير موجود",
        ];
    }
}
