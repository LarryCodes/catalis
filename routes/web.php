<?php

use App\Http\Controllers\PeopleController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\TimeAttendanceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/people', PeopleController::class)->name('people.index');
    Route::get('/payroll', PayrollController::class)->name('payroll.index');
    Route::get('/time-attendance', TimeAttendanceController::class)->name('time-attendance.index');
});

Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');
