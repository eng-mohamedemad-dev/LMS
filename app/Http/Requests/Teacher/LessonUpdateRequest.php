<?php

namespace App\Http\Requests\Teacher;

use App\Http\Requests\BaseRequest;

class LessonUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string|max:1000',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video' => 'sometimes|file|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime|max:3145728',
            'pdf' => 'sometimes|file|mimes:pdf|max:1048576',
            'unit_id' => 'sometimes|required|exists:units,id',
            'classroom_id' => 'sometimes|required|exists:classrooms,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'عنوان الدرس مطلوب.',
            'description.required' => 'وصف الدرس مطلوب.',
            'image.required' => 'صورة الدرس مطلوبة.',
            'video.required' => 'فيديو الدرس مطلوب.',
            'pdf.required' => 'الملف المرفق مطلوب.',
            'pdf.mimes' => 'يجب أن يكون الملف بصيغة PDF.',
            'pdf.max' => 'يجب أن يكون حجم الملف أقل من 1 جيجابايت.',
            'unit_id.required' => 'معرف الوحدة مطلوب.',
            'classroom_id.required' => 'معرف الصف الدراسي مطلوب.',
        ];
    }
}
