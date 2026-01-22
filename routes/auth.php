<?php

use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\DoctorController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\LaboratorieEmployeeController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\PatientController;
use App\Http\Controllers\Auth\RayEmployeeController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);
    #########################  USER ROUTE  ########################
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store'])
        ->name('login.user');
    #########################  ADMIN ROUTE  #######################
    Route::post('/login/admin', [AdminController::class, 'store'])->name('login.admin');
    #########################  DOCTOR ROUTE  #######################
    Route::post('/login/doctor', [DoctorController::class, 'store'])->name('login.doctor');
    #########################  RayEmployee ROUTE  #######################
    Route::post('/login/ray_employee', [RayEmployeeController::class, 'store'])->name('login.ray_employee');
    #########################  Laboratorie Employee ROUTE  #######################
    Route::post('/login/laboratorie_employee', [LaboratorieEmployeeController::class, 'store'])->name('login.laboratorie_employee');
    ######################### Patient ROUTE  #######################
    Route::post('/login/patient', [PatientController::class, 'store'])->name('login.patient');
    ################################################################
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout.user');
});
#########################  ADMIN ROUTE FOR LOG OUT #######################
Route::post('logout/admin', [AdminController::class, 'destroy'])->middleware('auth:admin')->name('logout.admin');
#########################  DOCTOR ROUTE FOR LOG OUT #######################
Route::post('logout/doctor', [DoctorController::class, 'destroy'])->middleware('auth:doctor')->name('logout.doctor');
#########################  RayEmployee ROUTE FOR LOG OUT #######################
Route::post('logout/ray_employee', [RayEmployeeController::class, 'destroy'])->middleware('auth:ray_employee')->name('logout.ray_employee');
#########################  Laboratorie Employee ROUTE FOR LOG OUT #######################
Route::post('logout/laboratorie_employee', [LaboratorieEmployeeController::class, 'destroy'])->middleware('auth:laboratorie_employee')->name('logout.laboratorie_employee');
#########################  Patient ROUTE FOR LOG OUT #######################
Route::post('logout/patient', [PatientController::class, 'destroy'])->middleware('auth:patient')->name('logout.patient');
