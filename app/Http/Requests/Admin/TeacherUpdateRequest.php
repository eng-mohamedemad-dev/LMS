<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class TeacherUpdateRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email,' . $this->route('teacher')->id,
            'phone' => 'required|string|max:20|unique:teachers,phone,' . $this->route('teacher')->id,
        ];
    }
}
