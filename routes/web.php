<?php

use App\Http\Controllers\PeopleController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\TimeAttendanceController;
use App\Http\Controllers\AccountsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/people', PeopleController::class)->middleware('permission:view-employees')->name('people.index');
    Route::get('/payroll', PayrollController::class)->middleware('permission:view-payroll')->name('payroll.index');
    Route::get('/time-attendance', TimeAttendanceController::class)->middleware('permission:view-attendance')->name('time-attendance.index');
    Route::get('/accounts', AccountsController::class)->middleware('permission:manage-users')->name('accounts.index');
});

Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');
