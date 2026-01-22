<?php

use App\Events\MyEvent;
use App\Http\Controllers\dashboard\AmbulanceController;
use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\dashboard\DoctorController;
use App\Http\Controllers\dashboard\InsuranceController;
use App\Http\Controllers\dashboard\LaboratorieEmployeeController;
use App\Http\Controllers\dashboard\PatientController;
use App\Http\Controllers\dashboard\PaymentAccountController;
use App\Http\Controllers\dashboard\RayEmployeeController;
use App\Http\Controllers\Dashboard\ReceiptAccountController;
use App\Http\Controllers\dashboard\SectionController;
use App\Http\Controllers\dashboard\ServiceController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/Dashboard_Admin', [DashboardController::class, 'index']);




Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ],
    function () {
        // Dashboard User
        Route::get('/dashboard/user', function () {
            return view('dashboard.user.dashboard');
        })->middleware(['auth'])->name('dashboard.user');

        // Dashboard Admin
        Route::middleware(['auth:admin'])->group(function () {
            Route::get('/dashboard/admin', function () {
                return view('dashboard.admin.dashboard');
            })->middleware(['auth:admin'])->name('dashboard.admin');

            // Route Section
            Route::resource('sections', SectionController::class);
            // Route Doctor
            Route::resource('doctors', DoctorController::class);
            Route::post('update_status', [DoctorController::class, 'update_status'])->name('update_status');
            Route::post('update_password_doctor', [DoctorController::class, 'update_password'])->name('update_password_doctor');
            // Route Service
            Route::resource('services', ServiceController::class);
            Route::view('Add_GroupServices', 'livewire.GroupServices.include_create')->name('Add_GroupServices');
            // Route Insurance
            Route::resource('insurances', InsuranceController::class);
            // Route Ambulance
            Route::resource('ambulances', AmbulanceController::class);
            // Route Patient
            Route::resource('patients', PatientController::class);
            // Route Single Invoices
            Route::view('single_invoices', 'livewire.SingleInvoices.index')->name('single_invoices');
            Route::view('print_single_invoices', 'livewire.SingleInvoices.print')->name('print_single_invoices');
            // Route Group Invoices
            Route::view('group_invoices', 'livewire.GroupInvoices.index')->name('group_invoices');
            Route::view('print_group_invoices', 'livewire.GroupInvoices.print')->name('print_group_invoices');
            // Route Receipt
            Route::resource('receipt', ReceiptAccountController::class);
            // Route Payment
            Route::resource('payment', PaymentAccountController::class);
            // RayEmployee route
            Route::resource('ray_employee', RayEmployeeController::class);
            Route::post('update_password_ray_employee', [RayEmployeeController::class, 'update_password'])->name('update_password_ray_employee');
            // Route Laboratorie
            Route::resource('laboratorie_employee', LaboratorieEmployeeController::class);
            Route::post('update_password_laboratorie_employee', [LaboratorieEmployeeController::class, 'update_password'])->name('update_password_laboratorie_employee');
        });
        // End Dashboard Admin

        require __DIR__ . '/auth.php';
    }
);
