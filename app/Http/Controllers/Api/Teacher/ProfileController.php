<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Models\Teacher;
use App\Http\Controllers\Controller;
use App\Http\Resources\TeacherProfileResource;
use App\Services\Teacher\TeacherProfileService;
use App\Http\Requests\Teacher\TeacherProfileUpdateRequest;

class ProfileController extends Controller
{
    public function __construct(protected TeacherProfileService $teacherProfileService)
    {
        $this->middleware('auth:teacher');
    }

    public function show()
    {
        try {
            $teacher = $this->teacherProfileService->show(auth()->guard('teacher')->user());
            return self::success('بيانات البروفايل', new TeacherProfileResource($teacher));
        } catch (\Exception $e) {
            return self::error('حدث خطأ أثناء جلب بيانات البروفايل: ');
        }
    }

    public function update(TeacherProfileUpdateRequest $request)
    {
            $teacher = $this->teacherProfileService->update(auth()->guard('teacher')->user(), $request->validated());
            return $teacher ? self::success('تم تحديث البروفايل بنجاح', new TeacherProfileResource($teacher)) :
                self::error('كلمة المرور الحالية غير صحيحة'); 
    }

    public function destroy()
    {
        try {
            $this->teacherProfileService->delete(auth()->guard('teacher')->user());
            return self::success('تم حذف الحساب بنجاح');
        } catch (\Exception $e) {
            return self::error('حدث خطأ أثناء حذف الحساب: ' . $e->getMessage());
        }
    }
}
