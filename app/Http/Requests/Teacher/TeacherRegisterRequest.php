<?php

namespace App\Http\Requests\Teacher;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Validator;
use App\Models\Subject;

class TeacherRegisterRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email',
            'phone' => 'required|string|max:20|unique:teachers,phone',
            'password' => 'required|string|min:6|confirmed',
            'subject_name' => 'required|exists:subjects,name',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'الاسم مطلوب',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'البريد الإلكتروني غير صالح',
            'email.unique' => 'هذا البريد الإلكتروني مسجل بالفعل',
            'phone.required' => 'رقم الهاتف مطلوب',
            'phone.unique' => 'هذا رقم الهاتف مسجل بالفعل',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.min' => 'يجب أن تكون كلمة المرور على الأقل 6 أحرف',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق',
            'subject_name.required' => 'المادة الدراسية مطلوبة',
            'subject_name.exists' => 'المادة الدراسية المختارة غير موجودة',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $subjectName = $this->input('subject_name');
            $matchedSubjects = Subject::where('name', $subjectName)->get();
            if ($matchedSubjects->isEmpty()) {
                return;
            }
            $alreadyTaken = $matchedSubjects->contains(function ($subject) {
                return !is_null($subject->teacher_id);
            });

            if ($alreadyTaken) {
                $validator->errors()->add('subject_name', 'المادة المختارة محجوزة بالفعل من مدرس آخر.');
            }
        });
    }
}
