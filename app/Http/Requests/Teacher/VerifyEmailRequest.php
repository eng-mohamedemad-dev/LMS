<?php

namespace App\Http\Requests\Teacher;

use App\Http\Requests\BaseRequest;


class VerifyEmailRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "code" => "required|string|exists:email_verification_codes,code",
            "email" => "required|email|exists:teachers,email"
        ];
    }
    public function messages()
    {
        return [
            "code.required" => "الرجاء إدخال رمز التحقق",
            "code.string" => "رمز التحقق يجب أن يكون نصًا",
            "code.exists" => "رمز التحقق غير موجود في النظام",
            "email.required" => "الرجاء إدخال البريد الإلكتروني",
            "email.email" => "البريد الإلكتروني غير صالح",
            "email.exists" => "البريد الإلكتروني غير موجود في النظام"
        ];
    }
}
