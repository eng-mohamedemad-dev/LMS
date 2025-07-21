<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class SubjectUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $subject = $this->route('subject');
        return [
            'name' => 'nullable|string|max:255|unique:subjects,name,' . $subject->id,
            'classroom_id' => 'required|exists:classrooms,id',
            'teacher_id' => 'required|exists:teachers,id|unique:subjects,teacher_id,' . $subject->id,
        ];
    }
}
