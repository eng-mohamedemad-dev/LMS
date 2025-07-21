<?php

namespace App\Http\Requests\Teacher;

use App\Http\Requests\BaseRequest;

class LessonStoreRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video' => 'required|file|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime|max:3145728',
            'unit_id' => 'required|exists:units,id',
            'classroom_id' => 'required|exists:classrooms,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'عنوان الدرس مطلوب.',
            'description.required' => 'وصف الدرس مطلوب.',
            'image.required' => 'صورة الدرس مطلوبة.',
            'video.required' => 'فيديو الدرس مطلوب.',
            'unit_id.required' => 'معرف الوحدة مطلوب.',
            'classroom_id.required' => 'معرف الصف الدراسي مطلوب.',
        ];
    }
}
