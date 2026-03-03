<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\ProsesController;
use App\Http\Controllers\ServiceController; // Tambahkan ini



//food beranda dan menu
Route::get('/', [FoodController::class, 'topRating'])->name('home');
Route::get('/menu', [FoodController::class, 'daftarMenu'])->name('menu');

// Detail Proses
Route::get('/pelajari-selengkapnya', [ProsesController::class, 'selengkapnya'])->name('about.detail');
Route::prefix('proses')->name('proses.')->group(function () {
    Route::get('/bahan-baku', [ProsesController::class, 'bahan'])->name('bahan');
    Route::get('/pemilihan-benih', [ProsesController::class, 'benih'])->name('benih');
    Route::get('/higienis', [ProsesController::class, 'higienis'])->name('higienis');
    Route::get('/pengiriman', [ProsesController::class, 'pengiriman'])->name('pengiriman');
});

// Halaman Service
Route::prefix('services')->name('services.')->group(function () {
    Route::get('/delivery', [ServiceController::class, 'delivery'])->name('delivery');
    Route::get('/catering', [ServiceController::class, 'catering'])->name('catering');
    Route::get('/meal-plan', [ServiceController::class, 'mealPlan'])->name('meal-plan');
    Route::get('/gift-card', [ServiceController::class, 'giftCard'])->name('gift-card');
});

//auth
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

//user
Route::middleware(['auth'])->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Keranjang Belanja
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add/{id}', [CartController::class, 'addToCart'])->name('add');
        Route::patch('/{id}', [CartController::class, 'update'])->name('update');
        Route::delete('/{id}', [CartController::class, 'destroy'])->name('destroy');
    });

    // Checkout
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/process', [CartController::class, 'processOrder'])->name('checkout.process');

Route::middleware(['auth'])->group(function () {
    // Route untuk tombol tambah keranjang
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
});

    // Profil & Riwayat User
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::put('/update', [UserController::class, 'update'])->name('update');
    });
    
    Route::get('/orders', [UserController::class, 'orderHistory'])->name('orders');
});


//admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
    Route::get('/financial-report', [AdminController::class, 'financialReport'])->name('financial.report');
    
    // Kelola Menu Admin
    Route::prefix('menu')->name('menu.')->group(function () {
        Route::get('/', [AdminController::class, 'menuIndex'])->name('index'); 
        Route::post('/store', [AdminController::class, 'menuStore'])->name('store');
        Route::put('/{id}', [AdminController::class, 'menuUpdate'])->name('update');
        Route::delete('/{id}', [AdminController::class, 'menuDestroy'])->name('destroy');
    });

    // Kelola Pesanan Admin
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminController::class, 'ordersIndex'])->name('index'); 
        Route::put('/{id}', [AdminController::class, 'orderUpdate'])->name('update');
    });

   // SEBELUMNYA:
// Route::get('/users', [AdminController::class, 'usersIndex'])->name('users.index');

// SESUDAH (Ganti menjadi ini):
Route::get('/users', [UserController::class, 'listUsers'])->name('users.index');
});