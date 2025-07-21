<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;
use App\Http\Requests\BaseRequest;

class FatherUpdateRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
           'email' => [
            'required',
            'email',
            Rule::unique('fathers', 'email')->ignore($this->route('father')->id),
        ],

        'phone' => [
            'required',
            'string',
            'max:20',
            Rule::unique('fathers', 'phone')->ignore($this->route('father')->id),
        ],

        ];
    }
}
