<?php

use App\Http\Controllers\employee\expenditure\ExpenditureController;
use App\Http\Controllers\employee\patient\PatientController;
use App\Http\Controllers\EmployeeBookingTypeController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/get-print/{slug}',[HomeController::class, 'getPrint'])->name("get-print");


Auth::routes();

Route::group(['middleware' => 'receptionist'], function () {
    Route::get('/booking-list', [App\Http\Controllers\HomeController::class, 'index'])->name('employee.register-bookings.index');
    Route::get('/booking/create', [App\Http\Controllers\HomeController::class, 'create'])->name('employee.register-bookings.create');
    Route::post('/booking/create', [App\Http\Controllers\HomeController::class, 'store'])->name('employee.register-bookings.store');
    Route::get('/booking/show/{id}', [App\Http\Controllers\HomeController::class, 'show'])->name('employee.register-bookings.show');
    Route::get('/patients', [PatientController::class, 'index'])->name('employee.patients.index');
    Route::get('/patients/show/{id}', [PatientController::class, 'show'])->name('employee.patients.show');
    Route::get('/generate-pdf/{booking_slug}', [PatientController::class, 'downloadPdf'])->name('employee.register-bookings.download');
    Route::post('/update-payment/{register_booking_slug}', [App\Http\Controllers\HomeController::class, 'updatePayment'])->name('employee.updatePayment');
    Route::resource('/employee-booking-types', EmployeeBookingTypeController::class);
    Route::resource('/recep-expenditure-manages', ExpenditureController::class);



});

require __DIR__ . '/admin.php';
