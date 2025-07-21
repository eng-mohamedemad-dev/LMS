<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class SendResetCodeRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "email" => "required|email|exists:admins,email"
        ];
    }
}
