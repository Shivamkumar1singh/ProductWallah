<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Vendor\Auth\LoginController;
use App\Http\Controllers\Vendor\Auth\RegisterController;
use App\Http\Controllers\Vendor\DashboardController;
use App\Http\Controllers\Vendor\ProductController;
use App\Http\Controllers\Vendor\OrderController;
use App\Datatables\Vendor\OrdersDataTable;

Route::prefix('vendor')->name('vendor.')->group(function () {

    // Guest vendor routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

    Route::get('/register', [RegisterController::class, 'showRegistration'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

    // Protected vendor routes
    Route::middleware('auth:vendor')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

        // ✅ Product Management
        Route::prefix('product-management')
            ->name('productManagement.')
            ->group(function () {
                Route::resource('product', ProductController::class);
            });

        // ✅ Order Management (FIXED)
        Route::prefix('orders')->name('orders.')->group(function () {

            // Page
            Route::get('/', [OrderController::class, 'index'])
                ->name('index');


            Route::get('/data', [OrderController::class, 'getOrdersData'])->name('data');
            Route::get('/counts', [OrderController::class, 'getStatusCounts'])->name('counts');
            Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        });
    });

});
