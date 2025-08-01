<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\SubjectController;
use App\Http\Controllers\Api\Admin\AdminAuthController;
use App\Http\Controllers\Api\Admin\ClassroomController;
use App\Http\Controllers\Api\Admin\FatherSettingController;
use App\Http\Controllers\Api\Admin\StudentSettingController;
use App\Http\Controllers\Api\Admin\TeacherSettingController;
use App\Http\Controllers\Api\Admin\ProfileController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::controller(AdminAuthController::class)->group(function () {
        Route::post('login', 'login');
        Route::post('forget', 'sendResetCode');
        Route::post('check', 'checkResetCode');
        Route::post('reset', 'resetPassword');
        Route::middleware('auth:sanctum')->post('logout', 'logout');
    });
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::apiResource('classrooms', ClassroomController::class);
        Route::apiResource('subjects', SubjectController::class);
        // Profile routes
        Route::controller(ProfileController::class)->group(function() {
            Route::get('profile', 'show');
            Route::put('profile', 'update');
            Route::delete('profile', 'destroy');
        });
        Route::put('teachers/{id}/approve', [TeacherSettingController::class,'approve']);
        Route::put('students/{id}/approve', [StudentSettingController::class,'approve']);
        Route::put('fathers/{id}/approve', [FatherSettingController::class,'approve']);
        Route::apiResource('teachers', TeacherSettingController::class)->except('store');
        Route::apiResource('students', StudentSettingController::class)->except('store');
        Route::apiResource('fathers', FatherSettingController::class)->except('store');
    });
});
