<?php

use App\Http\Controllers\PeopleController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\TimeAttendanceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('people.index');
});

Route::get('/people', PeopleController::class)->name('people.index');
Route::get('/payroll', PayrollController::class)->name('payroll.index');
Route::get('/time-attendance', TimeAttendanceController::class)->name('time-attendance.index');
