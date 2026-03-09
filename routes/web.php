<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\ProsesController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\FinancialReportController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [FoodController::class, 'topRating'])->name('home');
Route::get('/menu', [FoodController::class, 'daftarMenu'])->name('menu');

Route::get('/pelajari-selengkapnya', [ProsesController::class, 'selengkapnya'])->name('about.detail');

Route::prefix('proses')->name('proses.')->group(function () {
    Route::get('/bahan-baku', [ProsesController::class, 'bahan'])->name('bahan');
    Route::get('/pemilihan-benih', [ProsesController::class, 'benih'])->name('benih');
    Route::get('/higienis', [ProsesController::class, 'higienis'])->name('higienis');
    Route::get('/pengiriman', [ProsesController::class, 'pengiriman'])->name('pengiriman');
});

Route::prefix('services')->name('services.')->group(function () {
    Route::get('/delivery', [ServiceController::class, 'delivery'])->name('delivery');
    Route::get('/catering', [ServiceController::class, 'catering'])->name('catering');
    Route::get('/meal-plan', [ServiceController::class, 'mealPlan'])->name('meal-plan');
    Route::get('/gift-card', [ServiceController::class, 'giftCard'])->name('gift-card');
});

/*
|--------------------------------------------------------------------------
| Guest Routes (Hanya untuk yang BELUM login)
|--------------------------------------------------------------------------
*/
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    // Ubah .post menjadi 'login' saja agar sesuai dengan form action
    Route::post('/login', [AuthController::class, 'login']); 
    
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Harus Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Keranjang Belanja
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add/{id}', [CartController::class, 'addToCart'])->name('add');
        Route::patch('/{id}', [CartController::class, 'update'])->name('update');
        Route::delete('/{id}', [CartController::class, 'destroy'])->name('destroy');
    });

    // Checkout & Pesanan
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/process', [CartController::class, 'processOrder'])->name('checkout.process');
    Route::get('/orders', [UserController::class, 'orderHistory'])->name('orders');

    // Profil & Keamanan
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::put('/update', [UserController::class, 'update'])->name('update');
        Route::put('/password', [UserController::class, 'updatePassword'])->name('password.update');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Harus Login & Role Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard & Analytics
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
    
    // Perbaikan: Rute Laporan Keuangan diarahkan ke FinancialReportController
    Route::get('/financial-report', [FinancialReportController::class, 'index'])->name('financial.report');
    
    // Kelola Menu
    Route::prefix('menu')->name('menu.')->group(function () {
        Route::get('/', [AdminController::class, 'menuIndex'])->name('index'); 
        Route::get('/create', [AdminController::class, 'menuCreate'])->name('create'); // Tambahan: View Create Menu
        Route::post('/store', [AdminController::class, 'menuStore'])->name('store');
        Route::get('/{id}/edit', [AdminController::class, 'menuEdit'])->name('edit'); // Tambahan: View Edit Menu
        Route::put('/{id}', [AdminController::class, 'menuUpdate'])->name('update');
        Route::delete('/{id}', [AdminController::class, 'menuDestroy'])->name('destroy');
    });

    // Kelola Pesanan (Order Management)
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminController::class, 'ordersIndex'])->name('index'); 
        Route::put('/{id}', [AdminController::class, 'orderUpdate'])->name('update');
    });

    // Kelola User Management (CRUD User dari sisi Admin)
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'listUsers'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UserController::class, 'updateAdmin'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
    });
});