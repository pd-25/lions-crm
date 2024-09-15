<?php

use App\Http\Controllers\admin\auth\AuthController;
use App\Http\Controllers\admin\bookingtypes\BookingTypesController;
use App\Http\Controllers\admin\dashboard\DashboardController;
use App\Http\Controllers\admin\expenditure\ExpenditureController;
use App\Http\Controllers\admin\member\MemberController;
use App\Http\Controllers\admin\operationschemes\OperationSchemesController;
use App\Http\Controllers\admin\patient\PatientController;
use App\Http\Controllers\admin\registerbooking\RegisterBookingController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;

Route::get('admin/login', [AuthController::class, 'showLogin'])->name('admin.showlogin');
Route::post('admin/login', [AuthController::class, 'login'])->name('admin.login');

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('/members', MemberController::class);
    Route::resource('/patients', PatientController::class)->except(['create', 'edit']);

    Route::resource('/operation-schemes', OperationSchemesController::class);
    Route::resource('/register-bookings', RegisterBookingController::class);
    Route::resource('/booking-types', BookingTypesController::class);
    Route::get('/check-patient-privious-bookings', [RegisterBookingController::class, 'checkPatientPriviousBooking'])->name('admin.checkPatientPriviousBooking');
    Route::get('/check-bookingtype-operation', [RegisterBookingController::class, 'checkIfBookingTypeOperation'])->name('admin.checkIfBookingTypeOperation');
    Route::post('/update-payment/{register_booking_slug}', [RegisterBookingController::class, 'updatePayment'])->name('admin.updatePayment');
    Route::resource('/expenditure-manages', ExpenditureController::class);



    Route::get('log-out', [AuthController::class, 'adminLogout'])->name('admin.logout');
});
//these routes is common for both employee and admin
Route::get('/check-patient-privious-bookings', [RegisterBookingController::class, 'checkPatientPriviousBooking'])->name('admin.checkPatientPriviousBooking');
Route::get('/check-bookingtype-operation', [RegisterBookingController::class, 'checkIfBookingTypeOperation'])->name('admin.checkIfBookingTypeOperation');
Route::get('/get-print/{slug}',[RegisterBookingController::class, 'getPrint'])->name("get-print");

