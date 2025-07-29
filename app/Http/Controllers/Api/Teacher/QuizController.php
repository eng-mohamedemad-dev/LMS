<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use App\Services\QuizService;
use App\Http\Requests\Teacher\QuizStoreRequest;
use App\Http\Requests\Teacher\QuizUpdateRequest;
use App\Http\Resources\QuizzesResource;
use App\Models\Quiz;

class QuizController extends Controller
{
    public function __construct(protected QuizService $quizService)
    {
    }

    public function index()
    {
        $quizzes = $this->quizService->all();
        return self::success('قائمة الاختبارات', QuizzesResource::collection($quizzes));
    }

    public function show(Quiz $quiz)
    {
        $result = $this->quizService->find($quiz);
        return $result ? self::success('تفاصيل الاختبار', new QuizzesResource($result)) :
            self::error('لا يمكنك الوصول لهذا الاختبار', 403);
    }

    public function store(QuizStoreRequest $request)
    {
        $data = $request->validated();
        $subject = auth('teacher')->user()->subject()->where('classroom_id', $data['classroom_id'])->first();
        if(!$subject) {
            return self::error('هذه الماده ليست متاحه لهذا المعلم', 422);
        }
        $data['subject_id'] = $subject->id;
        $quiz = $this->quizService->create($data);
        return self::success('تم إضافة الاختبار بنجاح',new QuizzesResource($quiz), 201);
    }

    public function update(QuizUpdateRequest $request,Quiz $quiz)
    {
         $data = $request->validated();
        $subject = auth('teacher')->user()->subject()->where('classroom_id', $data['classroom_id'])->first();
        if(!$subject) {
            return self::error('هذه الماده ليست متاحه لهذا المعلم', 422);
        }
        $data['subject_id'] = $subject->id;
        $quiz = $this->quizService->update($quiz, $data);
        return self::success('تم تحديث الاختبار بنجاح', new QuizzesResource($quiz));
    }

    public function destroy(Quiz $quiz)
    {
       $result = $this->quizService->delete($quiz);
        if (!$result) {
            return self::error('لا يمكنك حذف هذا الاختبار', 403);
        }
        return self::success('تم حذف الاختبار بنجاح');
    }
}
