<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Homepage: redirect to dashboard if authenticated, otherwise to login
Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : redirect()->route('login');
});

// Guest routes: login & register
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.perform');
});

// Logout (keeps simple closure behavior)
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

// Authenticated area
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Small dashboard role pages grouped under /dashboard
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::view('/admin', 'roles.admin')->name('admin');
        Route::view('/owner', 'roles.owner')->name('owner');
        Route::view('/kasir', 'roles.kasir')->name('kasir');
        Route::view('/karyawan', 'roles.karyawan')->name('karyawan');
        // Simple view to test MySQL connection
        Route::view('/koneksi', 'dashboard.koneksi')->name('koneksi');
    });

    // Resources
    Route::resource('menus', MenuController::class);

    // Order confirmation route (show a confirmation page before payment or marking paid)
    Route::get('/orders/{order}/confirm', [OrderController::class, 'confirm'])->name('orders.confirm');

    Route::resource('orders', OrderController::class);

    // Quick order from dashboard (single-item instant order)
    Route::post('/orders/quick-store', [OrderController::class, 'quickStore'])->name('orders.quick_store');

    // Payments (explicitly limit to used actions)
    Route::resource('payments', PaymentController::class)->only([
        'index', 'create', 'store', 'show', 'edit', 'update', 'destroy'
    ]);
});
