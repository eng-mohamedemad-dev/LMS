<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class CheckRestCodeRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "email" => "required|string|exists:admins,email",
            "code" => "required|string|exists:password_reset_codes,code"
        ];
    }
}
