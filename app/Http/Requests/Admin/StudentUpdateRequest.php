<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class StudentUpdateRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $student = $this->route('student');
        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('students')->ignore($student->id)],
            'father_phone' => ['required', 'string', 'max:20'],
        ];
    }

}
