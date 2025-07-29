<?php

namespace App\Http\Controllers\Api\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Student\StudentService;
use App\Services\VerificationCodeService;
use App\Http\Requests\Student\LoginRequest;
use App\Http\Requests\Student\VerifyEmailRequest;
use App\Http\Requests\Student\ResTPasswordRequest;
use App\Http\Requests\Student\CheckRestCodeRequest;
use App\Http\Requests\Student\StudentRegisterRequest;
use App\Http\Requests\Student\ResendVerifyEmailRequest;


class StudentAuthController extends Controller
{
    const type = "student";
    protected $studentService;
    protected $verificationService;
    public function __construct(StudentService $studentService, VerificationCodeService $verificationService)
    {
        $this->studentService = $studentService;
        $this->verificationService = $verificationService;
    }

    public function login(LoginRequest $request)
    {
        $result = $this->studentService->login($request->validated());
        if (!$result['success']) {
            return self::error($result['message'], null, $result['status']);
        }
        return self::success('تم تسجيل الدخول بنجاح', $result['data']);
    }

    public function register(StudentRegisterRequest $request)
    {
        $student = $this->studentService->register($request->validated());
        if (!$student) {
            return self::error('فشل في تسجيل الطالب', null, 500);
        }
        $this->verificationService->sendVerificationCode($student->email, self::type);
        return self::success('تم إرسال كود التفعيل على البريد الإلكتروني');
    }

    public function verify(VerifyEmailRequest $request) {
        $data = $request->validated();
        $verified = $this->verificationService->verifyCode($data['email'], self::type, $data['code']);
        if ($verified) {
            return self::success('تم تفعيل البريد الإلكتروني بنجاح');
        }
        return self::error('الكود غير صحيح أو منتهي الصلاحية');
    }

    public function resendVerify(ResendVerifyEmailRequest $request) {
        $data = $request->validated();
        if ($this->verificationService->isEmailVerified($data['email'], self::type)) {
            return self::error('البريد الإلكتروني مفعل بالفعل');
        }
        $this->verificationService->sendVerificationCode($data['email'], self::type);
        return self::success('تم إعادة إرسال كود التفعيل على البريد الإلكتروني');
    }

    public function forgetPassword(ResendVerifyEmailRequest $request) {
        $data = $request->validated();
        $this->verificationService->sendResetCode($data['email'], self::type);
        return self::success('تم إرسال كود إعادة تعيين كلمة المرور على البريد الإلكتروني');
    }

    public function checkRestCode(CheckRestCodeRequest $request) {
        $data = $request->validated();
        $token = $this->verificationService->checkResetCode($data['email'], self::type, $data['code']);
        if ($token) {
            return self::success('تم التحقق من الكود بنجاح', [
                'token' => $token
            ]);
        }
        return self::error('الكود غير صحيح أو منتهي الصلاحية');
    }

    public function resetPassword(ResTPasswordRequest $request) {
        $data = $request->validated();
        $reset = $this->verificationService->resetPassword($data['token'], $data['password']);
        if ($reset) {
            return self::success('تم تغيير كلمة المرور بنجاح');
        }
        return self::error('التوكن غير صحيح أو منتهي الصلاحية');
    }

    public function logout(Request $request)
    {
        $request->user('student')->currentAccessToken()->delete();
        return self::success('تم تسجيل الخروج بنجاح', null);
    }
}
