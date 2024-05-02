<?php

use App\Http\Controllers\admin\auth\AuthController;
use App\Http\Controllers\admin\dashboard\DashboardController;
use App\Http\Controllers\admin\member\MemberController;
use App\Http\Controllers\admin\operationschemes\OperationSchemesController;
use App\Http\Controllers\admin\registerbooking\RegisterBookingController;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;

Route::get('admin/login', [AuthController::class, 'showLogin'])->name('admin.showlogin');
Route::post('admin/login', [AuthController::class, 'login'])->name('admin.login');

Route::group(['prefix' => 'admin', 'middleware'=>'admin'], function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::resource('/members', MemberController::class);
    Route::resource('/operation-schemes', OperationSchemesController::class);
    Route::resource('/register-bookings', RegisterBookingController::class);
    Route::get('/check-patient-privious-bookings', [RegisterBookingController::class, 'checkPatientPriviousBooking'])->name('admin.checkPatientPriviousBooking');


    Route::get('log-out', [AuthController::class, 'adminLogout'])->name('admin.logout');
});
