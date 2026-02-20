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

// Halaman Pelajari Selengkapnya
Route::get('/pelajari-selengkapnya', function () {
    return view('pages.pelajari_selengkapnya'); 
})->name('about.detail');

Route::get('/proses/bahan-baku', function () {
    return view('pages.proses.bahan');
})->name('proses.bahan');

/**
 * Route untuk Detail Proses (Kartu yang bisa diklik)
 * Pastikan file-file ini ada di: resources/views/pages/proses/
 */
Route::prefix('proses')->name('proses.')->group(function () {
    Route::get('/pemilihan-benih', function () {
        return view('pages.proses.benih');
    })->name('benih');

    Route::get('/higienis', function () {
        return view('pages.proses.higienis');
    })->name('higienis');

    Route::get('/pengiriman', function () {
        return view('pages.proses.pengiriman');
    })->name('pengiriman');
});

// Route Menu Utama
Route::get('/menu', function () {
    $menuItems = \App\Models\Food::all(); 
    return view('pages.menu', compact('menuItems'));
})->name('menu');

/*
|--------------------------------------------------------------------------
| Guest Routes (Hanya untuk yang BELUM Login)
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
| Authenticated Routes (Harus Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Keranjang Belanja
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::patch('/{id}', [CartController::class, 'update'])->name('update');
        Route::delete('/{id}', [CartController::class, 'destroy'])->name('destroy');
    });

    // Checkout
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/process', [CartController::class, 'processOrder'])->name('checkout.process');

    // Profil & Riwayat User
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
    
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
    
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

    // Kelola Pengguna Admin
    Route::get('/users', [AdminController::class, 'usersIndex'])->name('users.index');
});