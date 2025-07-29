<?php

namespace App\Http\Requests\Teacher;

use App\Http\Requests\BaseRequest;

class TeacherLoginRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:teachers,email',
            'password' => 'required|string',
            'device_token' => 'required|string|min:142|max:142'
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'البريد الإلكتروني غير صالح',
            'email.exists' => 'البريد الإلكتروني غير موجود',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.string' => 'كلمة المرور يجب أن تكون عبارة عن نص',
            'device_token.required' => 'رمز التحقق مطلوب',
            'device_token.string' => 'رمز التحقق يجب أن يكون عبارة عن نص',
            'device_token.min' => 'رمز التحقق يجب أن يكون على الأقل 142 حرف',
            'device_token.max' => 'رمز التحقق يجب أن يكون على الأقل 142 حرف',
        ];
    }
}
