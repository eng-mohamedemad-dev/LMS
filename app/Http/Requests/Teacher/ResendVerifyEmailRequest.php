<?php

namespace App\Http\Requests\Teacher;

use App\Http\Requests\BaseRequest;


class ResendVerifyEmailRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "email" => "required|email|exists:teachers,email"
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'البريد الإلكتروني غير صالح',
            'email.exists' => 'البريد الإلكتروني غير موجود',
        ];
    }
}
