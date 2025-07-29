<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class AdminLoginRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:admins,email',
            'password' => 'required|string',
            'device_token' => 'required|string|min:142|max:142'
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
