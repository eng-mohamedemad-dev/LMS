<?php

namespace App\Http\Requests\Student;

use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\Validator;

class StudentRegisterRequest extends BaseRequest
{
    protected function prepareForValidation(): void
    {
        $classroom = $this->input('classroom');

        if ($classroom === 'الصف الأول الثانوي' && !$this->has('classification')) {
            $this->merge([
                'classification' => 'عام',
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'password' => 'required|string|min:6|confirmed',
            'father_phone' => 'required|string|max:20',
            'classroom' => 'required|exists:classrooms,name',
            'classification' => 'sometimes|string|in:عام,علمي,رياضيات,أدبي,علوم',
            'device_token' => 'required|string|min:142|max:142'
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                $classroom = $this->input('classroom');
                $classification = $this->input('classification');

                $allowed = match ($classroom) {
                    'الصف الأول الثانوي' => ['عام'],
                    'الصف الثاني الثانوي' => ['علمي', 'أدبي'],
                    'الصف الثالث الثانوي' => ['علوم', 'رياضيات', 'أدبي'],
                    default => [],
                };

                if (!in_array($classification, $allowed)) {
                    $validator->errors()->add(
                        'classification',
                        'التصنيف المختار غير متاح لهذا الصف.'
                    );
                }
            }
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'الاسم مطلوب.',
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'البريد الإلكتروني غير صالح.',
            'email.unique' => 'هذا البريد الإلكتروني مسجل بالفعل.',
            'password.required' => 'كلمة المرور مطلوبة.',
            'password.min' => 'يجب أن تكون كلمة المرور على الأقل 6 أحرف.',
            'father_phone.required' => 'رقم هاتف الأب مطلوب.',
            'classroom.required' => 'الصف الدراسي مطلوب.',
            'classroom.exists' => 'الصف الدراسي المختار غير موجود.',
            'classification.in' => 'التصنيف المختار غير متاح لهذا الصف.',
            'device_token.required' => 'رمز التحقق مطلوب',
            'device_token.string' => 'رمز التحقق يجب أن يكون عبارة عن نص',
            'device_token.min' => 'رمز التحقق يجب أن يكون على الأقل 142 حرف',
            'device_token.max' => 'رمز التحقق يجب أن يكون على الأقل 142 حرف',
        ];
    }
}
