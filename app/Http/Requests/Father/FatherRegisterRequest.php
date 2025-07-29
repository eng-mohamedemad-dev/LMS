<?php

namespace App\Http\Requests\Father;

use Illuminate\Foundation\Http\FormRequest;

class FatherRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:fathers,email',
            'password' => 'required|string|min:6|confirmed',
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
