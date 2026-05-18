<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::post('/handle-login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/cars', [AdminController::class, 'cars'])->name('admin.cars');
    Route::get('/admin/bookings', [AdminController::class, 'bookings'])->name('admin.bookings');
    Route::get('/admin/customers', [AdminController::class, 'customers'])->name('admin.customers');
    Route::get('/admin/payments', [AdminController::class, 'payments'])->name('admin.payments');
    Route::get('/admin/maintenance', [AdminController::class, 'maintenance'])->name('admin.maintenance');

    Route::post('/admin/cars', [AdminController::class, 'storeCar'])->name('admin.cars.store');
    Route::post('/admin/maintenance', [AdminController::class, 'storeMaintenance'])->name('admin.maintenance.store');
    Route::delete('/admin/cars/{car}', [AdminController::class, 'destroyCar'])->name('admin.cars.destroy');
    Route::delete('/admin/maintenance/{maintenance}', [AdminController::class, 'destroyMaintenance'])->name('admin.maintenance.destroy');
    Route::put('/admin/cars/{car}', [AdminController::class, 'updateCar'])->name('admin.cars.update');
    Route::put('/admin/maintenance/{maintenance}', [AdminController::class, 'updateMaintenance'])->name('admin.maintenance.update');
    Route::patch('/admin/bookings/{booking}/confirm', [AdminController::class, 'confirmBooking'])->name('admin.bookings.confirm');
    Route::patch('/admin/bookings/{booking}/cancel', [AdminController::class, 'cancelBooking'])->name('admin.bookings.cancel');
    
    Route::patch('/admin/payments/{payment}/approve', [AdminController::class, 'approvePayment'])->name('admin.payments.approve');
    Route::patch('/admin/payments/{payment}/reject', [AdminController::class, 'rejectPayment'])->name('admin.payments.reject');
    
    Route::get('/staff/dashboard', function () { return view('staff.dashboard'); })->name('staff.dashboard');
    Route::get('/customer/portal', [CustomerController::class, 'index'])->name('customer.portal');
    Route::get('/my-bookings', [CustomerController::class, 'bookingHistory'])->name('customer.bookings');
    
    Route::resource('bookings', BookingController::class);
    Route::delete('/bookings/{booking}/cancel', [BookingController::class, 'destroy'])->name('bookings.cancel');

    Route::get('/payment/gcash/{booking}', [PaymentController::class, 'showGcashCheckout'])->name('payment.gcash');
    Route::post('/payment/gcash/{booking}/submit', [PaymentController::class, 'submitGcashProof'])->name('payment.gcash.submit');
});