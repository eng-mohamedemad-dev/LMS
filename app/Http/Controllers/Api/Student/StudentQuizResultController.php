<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use App\Services\StudentQuizResultService;
use App\Http\Requests\Student\StudentQuizResultStoreRequest;
use App\Http\Requests\Student\StudentQuizResultUpdateRequest;
use App\Traits\ApiResponse;

class StudentQuizResultController extends Controller
{
    use ApiResponse;

    protected $resultService;

    public function __construct(StudentQuizResultService $resultService)
    {
        $this->resultService = $resultService;
    }

    public function index()
    {
        $results = $this->resultService->all();
        return self::success('قائمة نتائج الاختبارات', $results);
    }

    public function show($id)
    {
        $result = $this->resultService->find($id);
        return self::success('تفاصيل نتيجة الاختبار', $result);
    }

    public function store(StudentQuizResultStoreRequest $request)
    {
        $result = $this->resultService->create($request->validated());
        return self::success('تم حفظ نتيجة الاختبار بنجاح', $result, 201);
    }

    public function update(StudentQuizResultUpdateRequest $request, $id)
    {
        $result = $this->resultService->update($id, $request->validated());
        return self::success('تم تحديث نتيجة الاختبار بنجاح', $result);
    }

    public function destroy($id)
    {
        $this->resultService->delete($id);
        return self::success('تم حذف نتيجة الاختبار بنجاح', null);
    }
}
