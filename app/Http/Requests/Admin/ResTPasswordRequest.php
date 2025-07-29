<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;

class ResTPasswordRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "password" => "required|string|min:6|confirmed",
            "token" => "required|string|exists:password_reset_codes,token"
        ];
    }
}
