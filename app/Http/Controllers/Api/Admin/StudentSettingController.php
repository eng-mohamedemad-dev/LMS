<?php

namespace App\Http\Controllers\Api\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Student\StudentSettingService;
use App\Http\Requests\Admin\StudentUpdateRequest;
use App\Http\Resources\StudentResource;
use App\Models\Student;

class StudentSettingController extends Controller
{
    public function __construct(protected StudentSettingService $studentSettingService)
    {
        $this->middleware('role:admin');
    }

    public function index() {
        $students = $this->studentSettingService->all();
        return self::success('تم جلب جميع التلاميذ بنجاح', StudentResource::collection($students));
    }

    public function show(Student $student) {
        return self::success('تم جلب بيانات التلميذ بنجاح', new StudentResource($student));
    }

    public function update(StudentUpdateRequest $request, Student $student)
    {
        $student = $this->studentSettingService->update($student, $request->validated());
        return self::success('تم تحديث بيانات التلميذ بنجاح', new StudentResource($student));
    }

    public function destroy(Student $student)
    {
       $student->delete();
        return self::success('تم حذف التلميذ بنجاح');
    }

    public function approve($id)
    {
        $student = $this->studentSettingService->approve($id);
        return $student ? self::success('تم قبول التلميذ بنجاح', new StudentResource($student)) : self::error('التلميذ مقبول بالفعل');
    }
}
