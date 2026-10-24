<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StockOpnameController;
use App\Http\Controllers\ExpenseController;
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
    Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google.redirect');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

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
    Route::view('/management', 'management.index')->name('management.index');
    Route::get('/management/finance', [PaymentController::class, 'finance'])->name('management.finance');
    Route::get('/management/finance/export', [PaymentController::class, 'exportFinance'])->name('management.finance.export');
    Route::post('/management/expenses', [ExpenseController::class, 'store'])->name('management.expenses.store');
    Route::put('/management/expenses/{expense}', [ExpenseController::class, 'update'])->name('management.expenses.update');
    Route::delete('/management/expenses/{expense}', [ExpenseController::class, 'destroy'])->name('management.expenses.destroy');
    Route::get('/stock-opnames', [StockOpnameController::class, 'index'])->name('stock-opnames.index');
    Route::post('/stock-opnames', [StockOpnameController::class, 'store'])->name('stock-opnames.store');

    // Small dashboard role pages grouped under /dashboard
    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::view('/admin', 'roles.admin')->name('admin');
        Route::view('/pelanggan', 'dashboard')->name('pelanggan');
        // Simple view to test MySQL connection
        Route::view('/koneksi', 'dashboard.koneksi')->name('koneksi');
    });

    // Resources
    Route::resource('menus', MenuController::class);

    Route::get('/orders/history', [OrderController::class, 'history'])->name('orders.history');

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

// Dynamic storage serving for Vercel Serverless /tmp storage and local fallback
Route::get('/storage/{path}', function (string $path) {
    // 1. Check storage_path('app/public/{path}') (e.g. /tmp/storage/app/public in Vercel)
    $storageFile = storage_path('app/public/' . $path);
    if (file_exists($storageFile) && is_file($storageFile)) {
        return response()->file($storageFile);
    }

    // 2. Check public_path('storage/{path}')
    $publicFile = public_path('storage/' . $path);
    if (file_exists($publicFile) && is_file($publicFile)) {
        return response()->file($publicFile);
    }

    abort(404);
})->where('path', '.*')->name('storage.file');

