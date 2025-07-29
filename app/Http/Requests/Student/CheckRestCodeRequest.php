<?php

namespace App\Http\Requests\Student;

use App\Http\Requests\BaseRequest;

class CheckRestCodeRequest extends BaseRequest
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
            "email" => "required|string|exists:students,email",
            "code" => "required|string|exists:password_reset_codes,code"
        ];
    }

    public function messages(): array
    {
        return [
            "email.required" => "البريد الإلكتروني مطلوب.",
            "email.string" => "البريد الإلكتروني يجب أن يكون نصًا.",
            "email.exists" => "البريد الإلكتروني المقدم غير موجود في سجلاتنا.",
            "code.required" => "رمز إعادة التعيين مطلوب.",
            "code.string" => "رمز إعادة التعيين يجب أن يكون نصًا.",
            "code.exists" => "رمز إعادة التعيين المقدم غير موجود."

        ];
    }
}
