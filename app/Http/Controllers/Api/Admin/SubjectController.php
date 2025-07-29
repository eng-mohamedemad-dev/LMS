<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Subject;
use App\Services\SubjectService;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubjectResource;
use App\Http\Requests\Admin\SubjectStoreRequest;
use App\Http\Requests\Admin\SubjectUpdateRequest;

class SubjectController extends Controller
{
    public function __construct(protected SubjectService $subjectService)
    {
        $this->middleware('role:admin');
    }

    public function index()
    {
        $subjects = $this->subjectService->all();
        return self::success('قائمة المواد', SubjectResource::collection($subjects));
    }

    public function show(Subject $subject)
    {
        return self::success('تفاصيل المادة', new SubjectResource($subject));
    }

    public function store(SubjectStoreRequest $request)
    {
        $subject = $this->subjectService->create($request->validated());
        return self::success('تم إضافة المادة بنجاح', new SubjectResource($subject), 201);
    }

    public function update(SubjectUpdateRequest $request,Subject $subject)
    {
        $subject = $this->subjectService->update($subject, $request->validated());
        return self::success('تم تحديث المادة بنجاح', new SubjectResource($subject));
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return self::success('تم حذف المادة بنجاح', null);
    }
}
