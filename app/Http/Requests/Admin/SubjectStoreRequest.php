<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class SubjectStoreRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:subjects,name',
            'classroom_id' => 'required|exists:classrooms,id',
            "teacher_id" => 'required|exists:teachers,id|unique:subjects,teacher_id',
        ];
    }
}
