<?php

namespace App\Http\Requests\Student;

use App\Models\Lesson;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Validator;

class AddLessonFavouriteRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
           'lesson_id' => 'required|uuid|exists:lessons,id'
        ];
    }

    public function messages()
    {
        return [
        'lesson_id.required' => 'يجب تحديد معرف الدرس.',
        'lesson_id.uuid' => 'معرف الدرس غير صالح.',
        'lesson_id.exists' => 'الدرس المحدد غير موجود.',
        ];
    }

    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $student = auth('student')->user();
            $lesson = Lesson::with('subject')->find($this->lesson_id);
            if ($lesson && !$student->classroom->subjects->contains('id', $lesson->subject_id)) {
                $validator->errors()->add('lesson_id', 'هذا الدرس لا يتبع أي مادة من مواد الطالب.');
            }
        });
    }
}
