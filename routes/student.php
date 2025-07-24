<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Api\Student\ProfileController;
use App\Http\Controllers\Api\Student\SubjectController;
use App\Http\Controllers\Api\Student\StudentAuthController;
use App\Http\Controllers\Api\Student\FavouriteLessonsController;
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
        // students subject details 
        Route::controller(SubjectController::class)->group(function() {
            Route::get('subject','all');
            Route::get('subject/unit/{subject}','show');
            Route::get('subject/quizzes/{lesson}','getQuizzes');
            Route::get('subject/quiz/{quiz}','getQuiz');
            Route::post('quiz/submit','submit');
            Route::get('lessons/latest','latestLessons');
        });
        // resukts 
        Route::apiResource('results', StudentQuizResultController::class);
        // favourite  
        Route::delete('favorites', [FavouriteLessonsController::class, 'deleteAll']);
        Route::apiResource('favorites',FavouriteLessonsController::class)
        ->except(['show', 'update']); 
        
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
