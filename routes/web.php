<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Auth::routes();

Route::group(['middleware' => 'receptionist'], function () {
    Route::get('/booking-list', [App\Http\Controllers\HomeController::class, 'index'])->name('employee.register-bookings.index');
    Route::get('/booking/create', [App\Http\Controllers\HomeController::class, 'create'])->name('employee.register-bookings.create');
    Route::post('/booking/create', [App\Http\Controllers\HomeController::class, 'store'])->name('employee.register-bookings.store');
    Route::get('/booking/show/{id}', [App\Http\Controllers\HomeController::class, 'show'])->name('employee.register-bookings.show');
});

require __DIR__ . '/admin.php';
