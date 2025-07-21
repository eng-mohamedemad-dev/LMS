<?php

namespace App\Http\Controllers\Api\Admin;

use App\Services\ClassroomService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ClassroomStoreRequest;
use App\Http\Requests\Admin\ClassroomUpdateRequest;
use App\Http\Resources\ClassroomsResource;
use App\Models\Classroom;

class ClassroomController extends Controller
{

    public function __construct(protected ClassroomService $classroomService)
    {
        $this->middleware('role:admin')->only(['create','destroy','update']);
    }

    public function index()
    {
        $classrooms = $this->classroomService->all();
        return self::success('قائمة الفصول', ClassroomsResource::collection($classrooms));
    }

    public function show(Classroom $classroom)
    {
        return self::success('تفاصيل الفصل', new ClassroomsResource($classroom));
    }

    public function store(ClassroomStoreRequest $request)
    {
        $classroom = $this->classroomService->create($request->validated());
        return self::success('تم إضافة الفصل بنجاح', $classroom, 201);
    }

    public function update(ClassroomUpdateRequest $request,Classroom $classroom)
    {
        $classroom = $this->classroomService->update($classroom, $request->validated());
        return self::success('تم تحديث الفصل بنجاح',new ClassroomsResource($classroom));
    }

    public function destroy(Classroom $classroom)
    {
        $classroom->delete();
        return self::success('تم حذف الفصل بنجاح', null);
    }
}
