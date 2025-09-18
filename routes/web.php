<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\PromoController;

// Arahkan root ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

// Dashboard Route (redirect /home to /dashboard)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// User Management Routes
Route::middleware(['auth', 'permission:users.view'])->group(function () {
    Route::get('/users', function () {
        return view('users.index');
    })->name('users.index');
});

// Role Management Routes
Route::middleware(['auth', 'permission:roles.view'])->group(function () {
    Route::get('/roles', function () {
        return view('roles.index');
    })->name('roles.index');
});

// Profile Settings Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', function () {
        return view('profile.index');
    })->name('profile.index');
});

Auth::routes();

// Arahkan /home ke Vue SPA (publik) agar tidak masuk dashboard default
Route::get('/home', function () {
    return view('app');
})->name('home');

// Utils: Server status & maintenance manager
Route::middleware(['auth'])->group(function () {
    Route::get('/utils', function () {
        return view('utils.index');
    })->name('utils.index');

    Route::get('/utils/maintenance', function () {
        return view('utils.maintenance');
    })->name('utils.maintenance');

    Route::get('/utils/sessions', function () {
        return view('utils.sessions');
    })->name('utils.sessions');
});

// Admin: Produk & Akun
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::post('products', [ProductController::class, 'store'])->name('products.store');

    Route::get('accounts', [AccountController::class, 'index'])->name('accounts.index');
    Route::post('accounts', [AccountController::class, 'store'])->name('accounts.store');

    // Promos & Banners
    Route::get('promos', [PromoController::class, 'index'])->name('promos.index');
    Route::post('promos', [PromoController::class, 'store'])->name('promos.store');
});

// Public maintenance page (preview)
Route::get('/maintenance', function () {
    return view('maintenance');
})->name('maintenance.page');
