<?php

namespace App\Http\Controllers\Api\Student;

use App\Models\Student;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentProfileResource;
use App\Services\Student\StudentProfileService;
use App\Http\Requests\Student\StudentProfileUpdateRequest;

class ProfileController extends Controller
{
    public function __construct(protected StudentProfileService $studentProfileService)
    {
        $this->middleware('auth:student');
    }

    /**
     * عرض بروفايل الطالب
     */
    public function show()
    {
        try {
            $student = $this->studentProfileService->show(auth()->guard('student')->user());
            return self::success('بيانات البروفايل', new StudentProfileResource($student));
        } catch (\Exception $e) {
            return self::error('حدث خطأ أثناء جلب بيانات البروفايل: ' . $e->getMessage());
        }
    }

    /**
     * تحديث بروفايل الطالب
     */
    public function update(StudentProfileUpdateRequest $request)
    {
        
            $student = $this->studentProfileService->update(auth()->guard('student')->user(), $request->validated());
            return $student ? self::success('تم تحديث البروفايل بنجاح', new StudentProfileResource($student)) :
                self::error('كلمة المرور الحالية غير صحيحة');
     
    }

    /**
     * حذف حساب الطالب
     */
    public function destroy()
    {
        try {
            $this->studentProfileService->delete(auth()->guard('student')->user());
            return self::success('تم حذف الحساب بنجاح');
        } catch (\Exception $e) {
            return self::error('حدث خطأ أثناء حذف الحساب: ' . $e->getMessage());
        }
    }
}
