<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Food;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/pelajari-selengkapnya', function () {
    return view('pages.pelajari_selengkapnya'); 
})->name('about.detail');

Route::get('/menu', function () {
    $menuItems = Food::all(); 
    return view('pages.menu', compact('menuItems'));
})->name('menu');

Route::prefix('proses')->name('proses.')->group(function () {
    Route::get('/bahan-baku', function () { return view('pages.proses.bahan'); })->name('bahan');
    Route::get('/pemilihan-benih', function () { return view('pages.proses.benih'); })->name('benih');
    Route::get('/higienis', function () { return view('pages.proses.higienis'); })->name('higienis');
    Route::get('/pengiriman', function () { return view('pages.proses.pengiriman'); })->name('pengiriman');
});

/*
|--------------------------------------------------------------------------
| Guest & Auth Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::patch('/{id}', [CartController::class, 'update'])->name('update');
        Route::delete('/{id}', [CartController::class, 'destroy'])->name('destroy');
    });

    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/process', [CartController::class, 'processOrder'])->name('checkout.process');

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::put('/update', [UserController::class, 'update'])->name('update');
    });
    
    Route::get('/orders', [UserController::class, 'orderHistory'])->name('orders');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard & Analytics
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
    
    // --- PENAMBAHAN ROUTE LAPORAN KEUANGAN ---
    Route::get('/financial-report', [AdminController::class, 'financialReport'])->name('financial.report');
    
    // Kelola Menu
    Route::prefix('menu')->name('menu.')->group(function () {
        Route::get('/', [AdminController::class, 'menuIndex'])->name('index'); 
        Route::post('/store', [AdminController::class, 'menuStore'])->name('store');
        Route::put('/{id}', [AdminController::class, 'menuUpdate'])->name('update');
        Route::delete('/{id}', [AdminController::class, 'menuDestroy'])->name('destroy');
    });

    // Kelola Pesanan
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminController::class, 'ordersIndex'])->name('index'); 
        Route::put('/{id}', [AdminController::class, 'orderUpdate'])->name('update');
    });

    // Kelola Pengguna
    Route::get('/users', [AdminController::class, 'usersIndex'])->name('users.index');
});
