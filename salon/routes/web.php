<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => redirect()->route('login'));

Route::get('/login',  [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->name('login.post')->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Protected Routes (require auth)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Service Management
    Route::resource('services', ServiceController::class);

    // Appointment / Booking Management
    Route::resource('appointments', AppointmentController::class);

    // Payment Management
    Route::resource('payments', PaymentController::class);
    Route::patch('/payments/{payment}/mark-paid',   [PaymentController::class, 'markPaid'])->name('payments.markPaid');
    Route::patch('/payments/{payment}/mark-unpaid', [PaymentController::class, 'markUnpaid'])->name('payments.markUnpaid');
});
