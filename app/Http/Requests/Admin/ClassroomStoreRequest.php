<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class ClassroomStoreRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:classrooms,name',
        ];
    }
}
