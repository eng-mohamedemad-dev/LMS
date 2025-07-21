<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Father\ProfileController;
use App\Http\Controllers\Api\Father\FatherAuthController;
use App\Http\Controllers\Api\Father\FatherStudentResultController;

Route::prefix('father')->name('father.')->group(function () {
    Route::controller(FatherAuthController::class)->group(function () {
        Route::middleware(["email_check:father",'account.approved:father'])->post('login', 'login');
        Route::post('register', 'register');
        Route::post('verify', 'verify');
        Route::post('resend', 'resendVerify');
        Route::post('forget', 'forgetPassword');
        Route::post('check', 'checkRestCode');
        Route::post('reset', 'resetPassword');
        Route::middleware('auth:sanctum')->post('logout', 'logout');
    });
    Route::middleware(['auth:sanctum', 'role:father'])->group(function () {
        Route::get('results', [FatherStudentResultController::class, 'index']);

        // Profile routes
        Route::controller(ProfileController::class)->group(function() {
            Route::get('profile', 'show');
            Route::put('profile', 'update');
            Route::delete('profile', 'destroy');
        });
    });
});


