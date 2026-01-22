<?php

use App\Http\Controllers\ray_employee\InvoiceController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Ray Employee Routes
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

        // Dashboard Ray Employee
        Route::middleware(['auth:ray_employee'])->group(function () {
            Route::get('/dashboard/ray_employee', function () {
                return view('dashboard.dashboard_ray_employee.dashboard');
            })->name('dashboard.ray_employee');

            Route::resource('invoices_ray_employee', InvoiceController::class);
            Route::get('ray_employee_completed_invoices', [InvoiceController::class, 'completed_invoices'])->name('completed_invoices_ray_employee');
            Route::get('view_rays/{id}', [InvoiceController::class, 'viewRays'])->name('view_rays');
        });
        // End Dashboard Ray Employee

        require __DIR__ . '/auth.php';
    }
);
