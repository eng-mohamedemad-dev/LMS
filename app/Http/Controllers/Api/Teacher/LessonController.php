<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use App\Services\LessonService;
use App\Http\Requests\Teacher\LessonStoreRequest;
use App\Http\Requests\Teacher\LessonUpdateRequest;
use App\Http\Resources\LessonResource;
use App\Models\Lesson;

class LessonController extends Controller
{
    public function __construct(protected LessonService $lessonService)
    {
    }

    public function index()
    {
        $lessons = $this->lessonService->all();
        return self::success('قائمة الدروس', LessonResource::collection($lessons));
    }

    public function show(Lesson $lesson)
    {
        return self::success('تفاصيل الدرس', new LessonResource($lesson));
    }

    public function store(LessonStoreRequest $request)
    {
        $data = $request->validated();
        $data['subject_id'] = auth()->user('teacher')->subject()->where('classroom_id',$data['classroom_id'])->first()->id ?? null;
        if ($data['subject_id'] === null) {
            return self::error('عذرًا، لا توجد مادة تعليمية مرتبطة بك كمعلم لهذا الصف الدراسي. يُرجى التأكد من أنك مُعين لتدريس مادة في هذا الصف', 404);
        }
        $lesson = $this->lessonService->create(fluent($data));
        return self::success('تم إضافة الدرس بنجاح', new LessonResource($lesson), 201);
    }

    public function update(LessonUpdateRequest $request, Lesson $lesson)
    {
        $lesson = $this->lessonService->update($lesson,fluent($request->validated()));
        return self::success('تم تحديث الدرس بنجاح', new LessonResource($lesson));
    }

    public function destroy(Lesson $lesson)
    {
        $this->lessonService->delete($lesson);
        return self::success('تم حذف الدرس بنجاح', null);
    }
}
