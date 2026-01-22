<?php

use App\Http\Controllers\laboratorie_employee\InvoiceController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Laboratorie Employee Routes
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
        Route::middleware(['auth:laboratorie_employee'])->group(function () {
            Route::get('/dashboard/laboratorie_employee', function () {
                return view('dashboard.dashboard_LaboratorieEmployee.dashboard');
            })->name('dashboard.laboratorie_employee');

            Route::resource('invoices_laboratorie_employee', InvoiceController::class);
            Route::get('laboratorie_employee_completed_invoices', [InvoiceController::class, 'completed_invoices'])->name('completed_invoices_laboratorie_employee');
            Route::get('view_laboratories/{id}', [InvoiceController::class, 'view_laboratories'])->name('view_laboratories');
        });
        // End Dashboard laboratorie_employee


        // Route::get('/404', function () {
        //     return view('Dashboard.404');
        // })->name('404');
        require __DIR__ . '/auth.php';
    }
);
