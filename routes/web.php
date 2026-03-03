<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\ProsesController;
use App\Http\Controllers\ServiceController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [FoodController::class, 'topRating'])->name('home');
Route::get('/menu', [FoodController::class, 'daftarMenu'])->name('menu');

// Detail Proses Produksi
Route::get('/pelajari-selengkapnya', [ProsesController::class, 'selengkapnya'])->name('about.detail');
Route::prefix('proses')->name('proses.')->group(function () {
    Route::get('/bahan-baku', [ProsesController::class, 'bahan'])->name('bahan');
    Route::get('/pemilihan-benih', [ProsesController::class, 'benih'])->name('benih');
    Route::get('/higienis', [ProsesController::class, 'higienis'])->name('higienis');
    Route::get('/pengiriman', [ProsesController::class, 'pengiriman'])->name('pengiriman');
});

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Keranjang Belanja
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        // PASTIKAN AKSES LEWAT FORM POST, BUKAN URL BROWSER
        Route::post('/add/{id}', [CartController::class, 'addToCart'])->name('add');
        Route::patch('/update/{id}', [CartController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [CartController::class, 'destroy'])->name('destroy');
    });

    // Checkout
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/process', [CartController::class, 'processOrder'])->name('checkout.process');

    // Riwayat Pesanan User (Sesuai perbaikan tampilan Bahasa Indonesia)
    Route::get('/orders', [UserController::class, 'orderHistory'])->name('orders');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
    
    // Route Financial Report yang sempat error "Undefined Method"
    Route::get('/financial-report', [AdminController::class, 'financialReport'])->name('financial.report');
    
    // Kelola Menu Admin
    Route::prefix('menu')->name('menu.')->group(function () {
        Route::get('/', [AdminController::class, 'menuIndex'])->name('index'); 
        Route::post('/store', [AdminController::class, 'menuStore'])->name('store');
        Route::put('/update/{id}', [AdminController::class, 'menuUpdate'])->name('update');
        Route::delete('/destroy/{id}', [AdminController::class, 'menuDestroy'])->name('destroy');
    });

    // Kelola Pesanan Admin (Status Bahasa Indonesia)
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminController::class, 'ordersIndex'])->name('index'); 
        Route::put('/update/{id}', [AdminController::class, 'orderUpdate'])->name('update');
    });
});