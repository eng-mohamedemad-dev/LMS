<?php

namespace App\Http\Requests\Father;

use App\Http\Requests\BaseRequest;

class VerifyEmailRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "code" => "required|string|exists:email_verification_codes,code",
            "email" => "required|email|exists:fathers,email"
        ];
    }
}
