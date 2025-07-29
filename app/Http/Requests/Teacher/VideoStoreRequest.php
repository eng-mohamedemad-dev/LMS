<?php

namespace App\Http\Requests\Teacher;

use App\Http\Requests\BaseRequest;

class VideoStoreRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'video' => 'required|file|mimes:mp4,mov,avi,wmv,flv|max:51200', // 50MB
            'lesson_id' => 'required|exists:lessons,id',
        ];
    }

    public function messages(): array
    {
        return [
            'video.required' => 'الفيديو مطلوب',
            'video.file' => 'الفيديو يجب أن يكون ملفًا',
        ];
    }
}
