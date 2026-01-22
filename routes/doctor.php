<?php


use App\Http\Controllers\doctor\PatientDetailsController;
use App\Http\Controllers\doctor\DiagnosticController;
use App\Http\Controllers\doctor\InvoiceController;
use App\Http\Controllers\doctor\LaboratorieController;
use App\Http\Controllers\doctor\RayController;
use App\Http\Livewire\Chat\CreateChat;
use App\Http\Livewire\Chat\Main;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Doctor Routes
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

        // Dashboard Doctor
        Route::middleware(['auth:doctor'])->group(function () {
            Route::get('/dashboard/doctor', function () {
                return view('dashboard.doctor.dashboard');
            })->name('dashboard.doctor');


            // Completed Invoicese
            Route::get('doctor_completed_invoices', [InvoiceController::class, 'completedInvoices'])->name('completed_invoices_doctor');
            // Review Invoices
            Route::get('review_invoices', [InvoiceController::class, 'reviewInvoices'])->name('reviewInvoices');
            // Invoices Route
            Route::resource('invoices', InvoiceController::class);
            Route::get('view_Laboratorie/{id}', [InvoiceController::class, 'showLaboratorie'])->name('show.Laboratorie');
            // Diagnostic Route
            Route::resource('diagnostics', DiagnosticController::class);
            // Add Review
            Route::post('add_review', [DiagnosticController::class, 'addReview'])->name('add_review');
            // Ray Route
            Route::resource('ray', RayController::class);
            // Patient Details
            Route::get('patient_details/{id}', [PatientDetailsController::class, 'index'])->name('patient_details');
            // Laboratorie Route
            Route::resource('laboratories', LaboratorieController::class);
            // Chat Route
            Route::get('list/patients', CreateChat::class)->name('list.patients');
            Route::get('chat/patients', Main::class)->name('chat.patients');
        });
        // End Dashboard Doctor


        // Route::get('/404', function () {
        //     return view('Dashboard.404');
        // })->name('404');
        require __DIR__ . '/auth.php';
    }
);
