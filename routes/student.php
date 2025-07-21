<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Api\Student\ProfileController;
use App\Http\Controllers\Api\Student\SubjectController;
use App\Http\Controllers\Api\Student\StudentAuthController;
use App\Http\Controllers\Api\Student\StudentQuizResultController;

Route::prefix('student')->name('student.')->group(function () {
    Route::controller(StudentAuthController::class)->group(function() {
        Route::middleware(["email_check:student",'account.approved:student'])->post('login', 'login');
        Route::post('register','register');
        Route::middleware('auth:sanctum')->post('logout','logout');
        Route::post('verify','verify');
        Route::post('resend','resendVerify');
        Route::post('forget','forgetPassword');
        Route::post('check','checkRestCode');
        Route::post('reset','resetPassword');
    });
    Route::middleware(['auth:sanctum', 'role:student'])->group(function () {
        Route::apiResource('results', StudentQuizResultController::class);
        Route::get('subject',[SubjectController::class,'all']);
        Route::get('subject/unit/{subject}',[SubjectController::class,'show']);
        Route::get('subject/quizzes/{lesson}',[SubjectController::class,'getQuizzes']);
        Route::get('subject/quiz/{quiz}',[SubjectController::class,'getQuiz']);
        Route::post('quiz/submit',[SubjectController::class,'submit']);

        // Profile routes
        Route::controller(ProfileController::class)->group(function() {
            Route::get('profile', 'show');
            Route::put('profile', 'update');
            Route::delete('profile', 'destroy');
        });
    });
});


Route::get('/stream-video/{filename}', function ($filename) {
    $path = storage_path('app/public/videos/' . $filename);
    if (!file_exists($path)) {
        abort(404);
    }
    return Response::file($path, [
        'Content-Type' => 'video/mp4',
        'Accept-Ranges' => 'bytes',
    ]);
})->name('video.stream');
