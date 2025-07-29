<?php

namespace App\Http\Requests\Teacher;

use App\Http\Requests\BaseRequest;
use Illuminate\Contracts\Validation\Validator;

class FileStoreRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file' => 'required|file|mimes:pdf,doc|max:1000480', //
            'lesson_id' => 'required|exists:lessons,id',
        ];
    }

    public function after() {
        return [
            function(Validator $validator ) {
                if ($this->file('file')->getSize() > 100) {
                    $validator->errors()->add('file', 'The file size must not exceed 1MB.');
                }
            }
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'الملف مطلوب',
            'file.file' => 'الملف يجب أن يكون ملفًا',
        ];
    }
}
