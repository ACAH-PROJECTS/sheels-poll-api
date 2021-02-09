<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\SurveyTemplateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:api', 'json.response'])->group(function () {

    // ----------------------------- API RESOURCES -----------------------------
    // users -> [ADMIN, MANAGER]
    Route::apiResource('users', UserController::class);
    // survey-templates -> [ADMIN, MANAGER]
    Route::apiResource('survey-templates', SurveyTemplateController::class);

    // -------------------------------------------------------------------------
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});


Route::middleware(['json.response'])->group(function () {
    // Auth routes
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

    // Password Reset
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('email.reset');
    Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.reset');

    // Email Verification
    Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::get('/email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
});
