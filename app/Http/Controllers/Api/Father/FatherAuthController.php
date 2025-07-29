<?php

namespace App\Http\Controllers\Api\Father;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Father\FatherService;
use App\Services\VerificationCodeService;
use App\Http\Requests\Father\FatherLoginRequest;
use App\Http\Requests\Father\VerifyEmailRequest;
use App\Http\Requests\Father\ResTPasswordRequest;
use App\Http\Requests\Father\CheckRestCodeRequest;
use App\Http\Requests\Father\FatherRegisterRequest;
use App\Http\Requests\Father\ResendVerifyEmailRequest;

class FatherAuthController extends Controller
{
    const type = "father";
    protected $fatherService;
    protected $verificationService;

    public function __construct(FatherService $fatherService, VerificationCodeService $verificationService)
    {
        $this->fatherService = $fatherService;
        $this->verificationService = $verificationService;
    }

    public function login(FatherLoginRequest $request)
    {
        $result = $this->fatherService->login($request->validated());
        if (!$result['success']) {
            return self::error($result['message'], null, $result['status']);
        }
        return self::success('تم تسجيل الدخول بنجاح', $result['data']);
    }

    public function register(FatherRegisterRequest $request)
    {
        $result = $this->fatherService->register($request->validated());
        if (!$result['success']) {
            return self::error($result['message'], null, $result['status']);
        }
        $father = $result['data'];
        $this->verificationService->sendVerificationCode($father->email, self::type);
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
