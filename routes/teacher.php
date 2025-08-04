<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Teacher\FileController;
use App\Http\Controllers\Api\Teacher\QuizController;
use App\Http\Controllers\Api\Teacher\VideoController;
use App\Http\Controllers\Api\Teacher\LessonController;
use App\Http\Controllers\Api\Teacher\MessageController;
use App\Http\Controllers\Api\Teacher\ProfileController;
use App\Http\Controllers\Api\Teacher\TeacherController;
use App\Http\Controllers\Api\Teacher\TeacherAuthController;
use App\Http\Controllers\Api\Teacher\TeacherStudentResultController;

Route::prefix('teacher')->name('teacher.')->group(function () {
    Route::get('available/subjects',[TeacherController::class,'subjects']);
    Route::controller(TeacherAuthController::class)->group(function () {
        Route::middleware(["email_check:teacher","account.approved:teacher"])->post('login', 'login');
        Route::post('register', 'register');
        Route::post('verify', 'verify');
        Route::post('resend', 'resendVerify');
        Route::post('forget', 'forgetPassword');
        Route::post('check', 'checkRestCode');
        Route::post('reset', 'resetPassword');
        Route::middleware('auth:sanctum')->post('logout', 'logout');
    });
    Route::middleware(['auth:sanctum','role:teacher'])->group(function () {
        Route::apiResource('lessons', LessonController::class);
        Route::apiResource('quizzes', QuizController::class);
        Route::apiResource('files', FileController::class)->only(['index', 'show', 'store', 'destroy']);
        Route::apiResource('videos', VideoController::class)->only(['index', 'show', 'store', 'destroy']);
        Route::get('results', [TeacherStudentResultController::class, 'index']);
        
        // Profile routes
        Route::controller(ProfileController::class)->group(function() {
            Route::get('profile', 'show');
            Route::put('profile', 'update');
            Route::delete('profile', 'destroy');
        });
        
        Route::controller(TeacherController::class)->group(function() {
            Route::get('classrooms','classrooms');
            Route::get('students','students');
            Route::get('lesson','lesson');
        });
        
        Route::post('message',MessageController::class);
    });
        Route::get('units',[TeacherController::class,'units']);
});






