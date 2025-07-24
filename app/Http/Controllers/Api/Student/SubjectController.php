<?php

namespace App\Http\Controllers\Api\Student;

use App\Models\Quiz;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\StudentQuizResult;
use App\Http\Controllers\Controller;
use App\Http\Resources\LessonResource;
use App\Http\Resources\QuizzesResource;
use App\Http\Resources\SubjectResource;
use App\Http\Resources\QuestionsResource;
use App\Http\Resources\SubjectUnitResource;
use App\Http\Resources\StudentResultResource;
use App\Http\Requests\Student\QuizSubmitRequest;

class SubjectController extends Controller
{
    public function all(Request $request)
    {
        $user = auth('student')->user();
        $classroomSubjects = Subject::with(['classroom','lessons','teacher','lessons.unit'])->where([
            ['classroom_id', $user->classroom_id],
            ['classification',$user->classification]
            ])->get();
        return self::success("تم عرض المواد بنجاح", SubjectResource::collection($classroomSubjects));
    }

    public function show(Subject $subject)
    {
        if ($subject->classroom_id == auth('student')->user()->classroom_id || $subject->classroom_id == null) {
            $subject->load(['classroom', 'lessons', 'teacher', 'lessons.unit','lessons.files']);
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

    public function submit(QuizSubmitRequest $request)
    {
    $data = $request->validated();
    $student = auth('student')->user();
    $result =$student->results()->where('quiz_id', $data['quiz_id'])->first();
    $is_solved = $result ? $result->exists() : false;
    if ($is_solved) {
        return self::error('لقد قمت بحل هذا الاختبار مسبقاً',new StudentResultResource($result));
        }
    // check if question submitted equal to questions in quiz
        $quiz = Quiz::with('questions')->findOrFail($data['quiz_id']);
        $questions = $quiz->questions;
        if (!(count($data['answers']) == $questions->count())) {
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
            // Check if the question was answered
            if (!$submitted) {
                continue; // Skip if no answer submitted for this question
            }
            // Check if the submitted answer is valid
            if (!is_array($question->options) || !in_array($submitted['answer'], $question->options)) {
            return self::error("الإجابة المقدمة غير صالحة للسؤال: {$question->question_text}", 422);
            }
            // Compare the submitted answer with the correct answer
            $isCorrect = trim(strtolower($submitted['answer'])) === trim(strtolower($question->correct_answer));
        
        // Increment score and correct count if the answer is correct
            if ($isCorrect) {
                $score++;
                $correctCount++;
            }

            $results[] = [
                'your_answer' => $submitted['answer'],
                'correct_answer' => $question->correct_answer,
                'is_correct' => $isCorrect
            ];
        }
        // Determine if the quiz is passed based on the score
        $isPassed = $score >= $quiz->questions->sum('mark') * 0.5; 
        StudentQuizResult::create([
            'quiz_id' => $quiz->id,
            'student_id' => auth('student')->id(),
            'score' => $score,
            'taken_at' => now(),
            'is_passed' => $isPassed
        ]);

        return self::success('تم تصحيح الكويز',
        [
            'score' => $score,
            'correct' => $correctCount,
            'total_questions' => $questions->count(),
            'is_passed' => $isPassed,
            'details' => $results
        ]);
    }

    public function latestLessons()
    {
        $student = Student::with('classroom.subjects.lessons.subject','classroom.subjects.lessons.unit')
        ->where('id', auth('student')->id())
        ->first();
        $lessons = $student->classroom->subjects
            ->flatMap(function ($subject) {
                return $subject->lessons;
            })
            ->sortByDesc('created_at')
            ->values();
        return self::success("أحدث الدروس", LessonResource::collection($lessons));
    }

}
