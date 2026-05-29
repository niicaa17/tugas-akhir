<?php

use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
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
    Route::get('/admin/profile', [AdminProfileController::class, 'index'])->name('admin.profile');
    Route::patch('/admin/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');
    Route::get('/keuangans/print', [KeuanganController::class, 'print'])->name('keuangans.print');
    Route::patch('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::resource('members', MemberController::class)->except(['show']);
    Route::resource('products', ProductController::class);
    Route::resource('keuangans', KeuanganController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/confirm', [OrderController::class, 'confirm'])->name('orders.confirm');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/user/profile', [UserDashboardController::class, 'profile'])->name('user.profile');
    Route::patch('/user/profile', [UserDashboardController::class, 'updateProfile'])->name('user.profile.update');
    Route::get('/user/products/{product}', [UserDashboardController::class, 'showProduct'])->name('user.products.show');
    Route::resource('carts', CartController::class)->except(['create', 'show', 'edit', 'update', 'destroy']);
    Route::post('/carts/decrement', [CartController::class, 'decrement'])->name('carts.decrement');
    Route::post('/carts/remove', [CartController::class, 'remove'])->name('carts.remove');
    Route::post('/carts/checkout', [CartController::class, 'checkout'])->name('carts.checkout');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::resource('payments', PaymentController::class)->except(['index', 'edit', 'update', 'destroy']);
});

