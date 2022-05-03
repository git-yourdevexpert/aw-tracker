<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Users\DashboardController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::name('pages')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/register', [RegisterController::class, 'index'])->name('.register');
        Route::post('/register', [RegisterController::class, 'store'])->name('.register.store');
        Route::get('/verify-email/{token}', [VerifyEmailController::class, 'check'])->name('.register.verifyEmail');

        Route::get('/login', [LoginController::class, 'index'])->name('.login');
        Route::post('/login', [LoginController::class, 'check'])->name('.login.check');

        Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->name('.forgotPassword');
        Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('.forgotPassword.store');
        Route::get('/reset-password/{token}', [ResetPasswordController::class, 'index'])->name('.resetPassword');
        Route::post('/reset-password', [ResetPasswordController::class, 'update'])->name('.resetPassword.update');
    });
});

Route::middleware('auth')->name('users')->group(function () {
    Route::redirect('/home', '/dashboard');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('.dashboard');
    Route::delete('/logout', [DashboardController::class, 'logout'])->name('.logout');
});
