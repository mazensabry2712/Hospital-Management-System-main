<?php

use App\Http\Controllers\patient\PatientController;
use App\Http\Livewire\Chat\CreateChat;
use App\Http\Livewire\Chat\Main;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
/*
|--------------------------------------------------------------------------
| Patient Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        // Dashboard Patient
        Route::middleware(['auth:patient'])->group(function () {
            Route::get('/dashboard/patient', function () {
                return view('dashboard.dashboard_patient.dashboard');
            })->name('dashboard.patient');
            // Patients route
            Route::get('invoices_patient', [PatientController::class, 'invoices'])->name('invoices.patient');
            Route::get('laboratories_patient', [PatientController::class, 'laboratories'])->name('laboratories.patient');
            Route::get('view_laboratories_patient/{id}', [PatientController::class, 'viewLaboratories'])->name('laboratories.view');
            Route::get('rays_patient', [PatientController::class, 'rays'])->name('rays.patient');
            Route::get('view_rays_patient/{id}', [PatientController::class, 'viewRays'])->name('rays_patient.view');
            Route::get('payments_patient', [PatientController::class, 'payments'])->name('payments.patient');
            // Chat Route
            Route::get('list/doctors',CreateChat::class)->name('list.doctors');
            Route::get('chat/doctors',Main::class)->name('chat.doctors');

        });


        require __DIR__ . '/auth.php';
    }
);
