<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return Auth::user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    }

    return view('welcome');
});

Auth::routes();
Route::get('/home', function () {
    return Auth::user()->isAdmin()
        ? redirect()->route('admin.dashboard')
        : redirect()->route('user.dashboard');
})->middleware('auth')->name('home');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
    Route::resource('umkms', UmkmController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('keuangans', KeuanganController::class);
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/user/profile', [UserDashboardController::class, 'profile'])->name('user.profile');
    Route::get('/user/products/{product}', [UserDashboardController::class, 'showProduct'])->name('user.products.show');
    Route::resource('carts', CartController::class)->except(['create', 'show', 'edit', 'update', 'destroy']);
    Route::resource('orders', OrderController::class)->except(['create', 'edit', 'update', 'destroy']);
    Route::resource('payments', PaymentController::class)->except(['index', 'edit', 'update', 'destroy']);
});

