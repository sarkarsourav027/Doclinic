<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ClinicalTestController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth','verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('clinical-test', ClinicalTestController::class);
    Route::resource('doctor', DoctorController::class);
    Route::resource('patient', PatientController::class);
    Route::resource('appointment', AppointmentController::class);
});

require __DIR__.'/auth.php';
