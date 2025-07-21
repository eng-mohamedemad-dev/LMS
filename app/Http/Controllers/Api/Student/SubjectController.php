<?php

namespace App\Http\Controllers\Api\Student;

use App\Models\Quiz;
use App\Models\Lesson;
use App\Models\Subject;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\StudentQuizResult;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuizzesResource;
use App\Http\Resources\SubjectResource;
use App\Http\Resources\QuestionsResource;
use App\Http\Resources\SubjectUnitResource;

class SubjectController extends Controller
{
    public function all(Request $request)
    {
        $user = auth('student')->user();

        $generalSubjects = Subject::with(['classroom','lessons','teacher','lessons.unit'])->whereNull('classroom_id')->get();
        $classroomSubjects = Subject::with(['classroom','lessons','teacher','lessons.unit'])->where([
            ['classroom_id', $user->classroom_id],
            ['classification',$user->classification]
            ])->get();

        $allSubjects = $generalSubjects->merge($classroomSubjects);
        return self::success("تم عرض المواد بنجاح", SubjectResource::collection($allSubjects));
    }

    public function show(Subject $subject)
    {
        if ($subject->classroom_id == auth('student')->user()->classroom_id || $subject->classroom_id == null) {
            $subject->load(['classroom', 'lessons', 'teacher', 'lessons.unit']);
            return self::success("تفاصيل الماده", new SubjectUnitResource($subject));
        }
        return self::error("لا يمكنك عرض تفاصيل هذه المادة", 403);
    } 

    public function getQuizzes(Lesson $lesson)
    {
        if ($lesson->subject->classroom_id == auth('student')->user()->classroom_id || $lesson->subject->classroom_id == null) {
            $quizzes = $lesson->quizzes()->with('questions')->get();
            return self::success("قائمة الاختبارات", QuizzesResource::collection($quizzes));
        }
        return self::error("لا يمكنك عرض اختبارات هذه الوحدة", 403);
    }

    public function getQuiz(Quiz $quiz)
    {
        if ($quiz->lesson->subject->classroom_id == auth('student')->user()->classroom_id || $quiz->lesson->subject->classroom_id == null) {
            return self::success("تفاصيل الاختبار", QuestionsResource::collection($quiz->questions));
        }
        return self::error("لا يمكنك عرض تفاصيل هذا الاختبار", 403);
    }

// لو بتسجل النتيجة

public function submit(Request $request)
{
    $data = $request->validate([
        'quiz_id' => 'required|exists:quizzes,id',
        'answers' => 'required|array',
        'answers.*.question_id' => 'required|exists:questions,id',
        'answers.*.answer' => 'required|string'
    ]);

    $quiz = Quiz::with('questions')->findOrFail($data['quiz_id']);
    $questions = $quiz->questions;

    if (count($data['answers']) < $questions->count()) {
        return response()->json([
            'message' => 'يرجى الإجابة على جميع الأسئلة قبل إرسال الكويز',
            'total_questions' => $questions->count(),
            'answered_questions' => count($data['answers'])
        ], 422);
    }

    $submittedAnswers = collect($data['answers']);
    $score = 0;
    $correctCount = 0;
    $results = [];

    foreach ($questions as $question) {
        $submitted = $submittedAnswers->firstWhere('question_id', $question->id);
        if (!$submitted) continue;

        if (!is_array($question->answers) || !in_array($submitted['answer'], $question->answers)) {
            continue;
        }

        $isCorrect = trim(strtolower($submitted['answer'])) === trim(strtolower($question->correct_answer));
        if ($isCorrect) {
            $score++;
            $correctCount++;
        }

        $results[] = [
            'question_id' => $question->id,
            'your_answer' => $submitted['answer'],
            'correct_answer' => $question->correct_answer,
            'is_correct' => $isCorrect
        ];
    }

        dd($results);
    StudentQuizResult::create([
        'quiz_id' => $quiz->id,
        'student_id' => auth('student')->id(),
        'score' => $score,
        'taken_at' => now(),
    ]);

    return response()->json([
        'message' => 'تم تصحيح الكويز',
        'score' => $score,
        'correct' => $correctCount,
        'total' => $questions->count(),
        'details' => $results
    ]);
}



}
