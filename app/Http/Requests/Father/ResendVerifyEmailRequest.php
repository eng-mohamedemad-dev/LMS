<?php

namespace App\Http\Requests\Father;

use App\Http\Requests\BaseRequest;

class ResendVerifyEmailRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "email" => "required|email|exists:fathers,email"
        ];
    }
}
