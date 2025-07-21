<?php

namespace App\Http\Controllers\Api\Admin;


use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TeacherResource;
use App\Services\Teacher\TeacherSettingService;
use App\Http\Requests\Admin\TeacherUpdateRequest;

class TeacherSettingController extends Controller
{
    public function __construct(protected TeacherSettingService $teacherSettingService)
    {
        $this->middleware('role:admin');
    }

    public function index()
    {
        $teachers = $this->teacherSettingService->all();
        return self::success('قائمة المدرسين', TeacherResource::collection($teachers));
    }

    public function show(Teacher $teacher)
    {
        $teacher->load('subject');
        return self::success('تفاصيل المدرس', new TeacherResource($teacher));
    }

    public function update(TeacherUpdateRequest $request, Teacher $teacher)
    {
        $teacher = $this->teacherSettingService->update($teacher, $request->validated());
        return self::success('تم تحديث بيانات المدرس بنجاح', new TeacherResource($teacher));
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return self::success('تم حذف المدرس بنجاح');
    }

    public function approve($id)
    {
        $teacher = $this->teacherSettingService->approve($id);
        return $teacher ? self::success('تم قبول المدرس بنجاح', new TeacherResource($teacher)) : self::error('هذا المدرس تم قبوله مسبقاً');
    }

}
