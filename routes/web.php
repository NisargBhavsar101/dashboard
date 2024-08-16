<?php

use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Torann\GeoIP\Facades\GeoIP;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::post('users/{user}/lock', [UserController::class, 'lock'])->name('users.lock');
    Route::post('users/{user}/unlock', [UserController::class, 'unlock'])->name('users.unlock');
    Route::post('users/{user}/approve', [UserController::class, 'approve'])->name('users.approve');
    Route::post('users/{user}/reject', [UserController::class, 'reject'])->name('users.reject');
});
use App\Http\Middleware\CheckUserStatus;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TrafficController;

Route::middleware(['auth', CheckUserStatus::class])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/payment', [PaymentController::class, 'showPaymentForm'])->name('payment.form');
    Route::post('/payment', [PaymentController::class, 'processPayment'])->name('payment.process');
    Route::get('/traffic', [TrafficController::class, 'index'])->name('traffic.index');

    Route::middleware('admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    });
});
