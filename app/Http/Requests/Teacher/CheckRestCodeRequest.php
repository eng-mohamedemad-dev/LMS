<?php

namespace App\Http\Requests\Teacher;

use App\Http\Requests\BaseRequest;

class CheckRestCodeRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "email" => "required|string|exists:teachers,email",
            "code" => "required|string|exists:password_reset_codes,code"
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.string' => 'البريد الإلكتروني يجب أن يكون عبارة عن نص',
        ];
    }
}
