<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes();

Route::middleware(['authenticate'])->group(function () {
    // Home Route
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Product Route
    Route::resource('products', ProductController::class);

    // Member Route
    Route::resource('members', MemberController::class);

    // Superadmin Route
    Route::middleware(['superadmin'])->group(function () {
        // User Route
        Route::resource('user', UserController::class);

        // Product Route
        Route::put('/products/{id}/update-stock', [ProductController::class, 'updateStock'])->name('products.updateStock');

        // Sale Route
        Route::resource('sales', SaleController::class);
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/profile/change-password', [ProfileController::class, 'changepassword'])->name('profile.change-password');
        Route::put('/profile/password', [ProfileController::class, 'password'])->name('profile.password');
    });
    
    // User Route
    Route::middleware(['user'])->group(function () {    
        // Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    });
});

