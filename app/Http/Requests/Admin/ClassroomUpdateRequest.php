<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class ClassroomUpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $classroom =$this->route('classroom');
        return [
            'name' => ['required','string','max:255',Rule::unique('classrooms','name')->ignore($classroom->id)],
        ];
    }
}
