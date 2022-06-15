<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Users\CompanyController;
use App\Http\Controllers\Users\DashboardController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Users\AccountSettingsController;
use App\Http\Controllers\Users\SubscriptionPaymentController;
use App\Http\Controllers\Users\ManagesitesController;
use App\Http\Controllers\Users\SiteController;

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

Route::stripeWebhooks('stripe-webhook');

Route::name('pages')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/register', [RegisterController::class, 'index'])->name('.register');
        Route::post('/register', [RegisterController::class, 'store'])->name('.register.store');
        Route::get('/verify-email/{token}', [VerifyEmailController::class, 'check'])->name('.register.verifyEmail');
        Route::post('/registerCompany', [RegisterController::class, 'storeCompany'])->name('.registerCompany.store');
        Route::post('/registerBilling/{id}', [RegisterController::class, 'registerBilling'])->name('.registerBilling.store');
        Route::post('/siteStore', [RegisterController::class, 'siteStore'])->name('.site.store');

        Route::get('/login', [LoginController::class, 'index'])->name('.login');
        Route::post('/login', [LoginController::class, 'check'])->name('.login.check');

        Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->name('.forgotPassword');
        Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('.forgotPassword.store');
        Route::get('/reset-password/{token}', [ResetPasswordController::class, 'index'])->name('.resetPassword');
        Route::post('/reset-password', [ResetPasswordController::class, 'update'])->name('.resetPassword.update');
    });
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'is_verify_email'])->name('users.dashboard');
Route::middleware('auth')->name('users')->group(function () {
    Route::redirect('/home', '/dashboard');

    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('.dashboard');
    Route::delete('/logout', [DashboardController::class, 'logout'])->name('.logout');

    Route::prefix('company')->name('.company')->group(function () {
        Route::get('/', [CompanyController::class, 'index']);
        Route::post('/', [CompanyController::class, 'store'])->name('.store');
        Route::patch('/{id}', [CompanyController::class, 'update'])->name('.update');
    });

    Route::prefix('subscription')->name('.subscription')->group(function () {
        Route::get('/select', [SubscriptionPaymentController::class, 'index']);
        Route::post('/select', [SubscriptionPaymentController::class, 'store'])->name('.pay');

        Route::post('/credit-card', [SubscriptionPaymentController::class, 'storeCard'])->name('.storeCard');

        Route::get('/success', [SubscriptionPaymentController::class, 'success'])->name('.success');
    });

    Route::prefix('account-settings')->name('.accountSettings')->group(function () {
        Route::get('/', [AccountSettingsController::class, 'index']);
        Route::patch('/general', [AccountSettingsController::class, 'updateGeneral'])->name('.updateGeneral');
        Route::patch('/change-password', [AccountSettingsController::class, 'changePassword'])->name('.changePassword');
        Route::get('/changeDefaultCard',[AccountSettingsController::class, 'changeDefaultCard'])->name('.changeDefaultCard');
    });

    Route::prefix('site')->name('.site')->group(function () {
        Route::get('/', [SiteController::class, 'index']);
    });
});
