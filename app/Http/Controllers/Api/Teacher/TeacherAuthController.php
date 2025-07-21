<?php

namespace App\Http\Controllers\Api\Teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\VerificationCodeService;
use App\Http\Requests\Teacher\VerifyEmailRequest;
use App\Http\Requests\Teacher\ResTPasswordRequest;
use App\Http\Requests\Teacher\TeacherLoginRequest;
use App\Http\Requests\Teacher\CheckRestCodeRequest;
use App\Http\Requests\Teacher\TeacherRegisterRequest;
use App\Http\Requests\Teacher\ResendVerifyEmailRequest;
use App\Services\Teacher\TeacherService;


class TeacherAuthController extends Controller
{

    const type = "teacher";
    protected $teacherService;
    protected $verificationService;

    public function __construct(TeacherService $teacherService, VerificationCodeService $verificationService)
    {
        $this->teacherService = $teacherService;
        $this->verificationService = $verificationService;
    }

    public function login(TeacherLoginRequest $request)
    {
        $result = $this->teacherService->login($request->validated());
        if (!$result['success']) {
            return self::error($result['message'], null, $result['status']);
        }
        return self::success('تم تسجيل الدخول بنجاح', $result['data']);
    }

    public function register(TeacherRegisterRequest $request)
    {
        $teacher = $this->teacherService->register($request->validated());
        $this->verificationService->sendVerificationCode($teacher->email, self::type);
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
        $request->user(self::type)->currentAccessToken()->delete();
        return self::success('تم تسجيل الخروج بنجاح', null);
    }
}
