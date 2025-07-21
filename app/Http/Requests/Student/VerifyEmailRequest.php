<?php

namespace App\Http\Requests\Student;

use App\Http\Requests\BaseRequest;


class VerifyEmailRequest extends BaseRequest
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
            "code" => "required|string|exists:email_verification_codes,code",
            "email" => "required|email|exists:students,email"
        ];
    }

    public function messages(): array
    {
        return [
            "code.required" => "التحقق من الرمز مطلوب.",
            "code.string" => "التحقق من الرمز يجب أن يكون نصًا.",
            "code.exists" => "التحقق من الرمز المقدم غير موجود.",
            "email.required" => "البريد الإلكتروني مطلوب.",
            "email.email" => "البريد الإلكتروني يجب أن يكون بتنسيق بريد إلكتروني صالح.",
            "email.exists" => "البريد الإلكتروني المقدم غير موجود في سجلاتنا."
        ];
    }
}
