<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\AppointmentController;

Route::middleware(['auth'])->group(function () {
    Route::get('appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('appointments', [AppointmentController::class, 'store'])->name('appointments.store');
});

use App\Http\Controllers\DashboardController;

Route::middleware(['auth'])->group(function () {
    // Route for the dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});
