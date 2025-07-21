<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Hash;

class TeacherProfileUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'email' => [
                'sometimes',
                'required',
                'email',
                Rule::unique('teachers', 'email')->ignore(auth()->guard('teacher')->id()),
            ],
            'phone' => 'sometimes|nullable|string|max:20',
            'address' => 'sometimes|nullable|string|max:500',
            'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'current_password' => 'required_with:password|string',
            'password' => 'sometimes|nullable|string|min:8|confirmed',
            'password_confirmation' => 'required_with:password|string|min:8',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->has('password') && $this->has('current_password')) {
                $teacher = auth()->guard('teacher')->user();
                if (!Hash::check($this->current_password, $teacher->password)) {
                    $validator->errors()->add('current_password', 'كلمة المرور الحالية غير صحيحة');
                }
            }
        });
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم المدرس مطلوب',
            'name.string' => 'اسم المدرس يجب أن يكون نص',
            'name.max' => 'اسم المدرس يجب أن لا يتجاوز 255 حرف',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'البريد الإلكتروني غير صحيح',
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل',
            'phone.string' => 'رقم الهاتف يجب أن يكون نص',
            'phone.max' => 'رقم الهاتف يجب أن لا يتجاوز 20 حرف',
            'address.string' => 'العنوان يجب أن يكون نص',
            'address.max' => 'العنوان يجب أن لا يتجاوز 500 حرف',
            'image.image' => 'الملف يجب أن يكون صورة',
            'image.mimes' => 'نوع الصورة يجب أن يكون: jpeg, png, jpg, gif',
            'image.max' => 'حجم الصورة يجب أن لا يتجاوز 2 ميجابايت',
            'current_password.required_with' => 'كلمة المرور الحالية مطلوبة لتغيير كلمة المرور',
            'current_password.string' => 'كلمة المرور الحالية يجب أن تكون نص',
            'password.min' => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق',
            'password_confirmation.required_with' => 'تأكيد كلمة المرور مطلوب',
            'password_confirmation.string' => 'تأكيد كلمة المرور يجب أن يكون نص',
            'password_confirmation.min' => 'تأكيد كلمة المرور يجب أن يكون 8 أحرف على الأقل',
        ];
    }
}
