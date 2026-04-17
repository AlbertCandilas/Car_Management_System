<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

// Show the login page
Route::get('/', function () {
    return view('auth.login');
})->name('login');

// Process the login (THIS HANDLES THE POST REQUEST)
Route::post('/handle-login', [LoginController::class, 'login'])->name('login.post');

// Protected Dashboard Routes
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', function () { return view('admin.dashboard'); })->name('admin.dashboard');
    Route::get('/staff/dashboard', function () { return view('staff.dashboard'); })->name('staff.dashboard');
    Route::get('/customer/portal', function () { return view('customer.portal'); })->name('customer.portal');
});