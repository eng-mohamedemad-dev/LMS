<?php

namespace App\Services;

use App\Models\Father;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Str;
use App\Jobs\SendEmailVerifyJob;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class VerificationCodeService
{
    public function generateCode()
    {
        return str_pad(random_int(1000, 999999), 6, '0', STR_PAD_LEFT);
    }

    public function sendVerificationCode($email, $userType)
    {
        DB::table('email_verification_codes')->where([
            ['email', $email],
            ['user_type', $userType],
        ])->delete();
        $code = $this->generateCode();
        $expiresAt = now()->addMinutes(10);
        DB::table('email_verification_codes')->insert([
            'email' => $email,
            'user_type' => $userType,
            'code' => $code,
            'expires_at' => $expiresAt,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        dispatch(new SendEmailVerifyJob($email,$code))->withoutDelay();
        return $code;
    }

    public function sendResetCode($email, $userType)
    {
        DB::table('password_reset_codes')->where([
            ['email', $email],
            ['user_type', $userType],
        ])->delete();
        $code = $this->generateCode();
        $expiresAt = now()->addMinutes(10);
        DB::table('password_reset_codes')->insert([
            'email' => $email,
            'user_type' => $userType,
            'code' => $code,
            'expires_at' => $expiresAt,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        dispatch(new SendEmailVerifyJob($email,$code))->withoutDelay();
        return $code;
    }

    public function checkResetCode($email, $userType, $code)
    {
        $row = DB::table('password_reset_codes')
            ->where([
                ['email', $email],
                ['user_type', $userType],
                ['code', $code],
                ['expires_at','>',now()]
            ])->first();
        if (!$row) {
            return false;
        }
        $token = Str::random(70);
         DB::table('password_reset_codes')
        ->where('id', $row->id)
        ->update([
            'code' => null,
            'expires_at' => null,
            'token' =>  $token,
        ]);
        return $token;
    }

    public function resetPassword($token, $password)
    {
        $row = DB::table('password_reset_codes')
            ->where('token', $token)
            ->first();
        if (!$row) {
            return false;
        }
        $email = $row->email;
        $userType = $row->user_type;
        $model = [
            'student' => Student::class,
            'father' => Father::class,
            'teacher' => Teacher::class,
            'admin' => Admin::class
        ][$userType];

        $model = $model::where('email', $email)->first();
        if (!$model) {
            return false;
        }
        $model->password = Hash::make($password);
        $model->save();
        DB::table('password_reset_codes')->where('id', $row->id)->delete();
        return true;
    }
    public function verifyCode($email, $userType, $code)
    {
        $row = DB::table('email_verification_codes')
            ->where([
                ['email', $email],
                ['user_type', $userType],
                ['code', $code],
                ['expires_at','>',now()]
            ])->first();
        if (!$row) {
            return false;
        }
         DB::table('email_verification_codes')
        ->where('id', $row->id)
        ->update([
            'code' => null,
            'expires_at' => null,
            'email_verify_at' => now()
        ]);
        return true;
    }

    public function isEmailVerified($email, $userType)
    {
        $row = DB::table('email_verification_codes')
            ->where([
                ['email', $email],
                ['user_type', $userType],
                ['email_verify_at', '!=', null]
            ])->first();
        return $row ? true : false;
    }
}
