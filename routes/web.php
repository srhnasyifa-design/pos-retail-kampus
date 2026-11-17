
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\TransactionHistoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;

// ===============================
// LOGIN
// ===============================

Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login'])
        ->name('login.process');

});

// ===============================
// LOGOUT
// ===============================

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ===============================
// SEMUA HALAMAN WAJIB LOGIN
// ===============================

Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    // DASHBOARD: ADMIN DAN KASIR
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // ===============================
    // PRODUK
    // ADMIN DAN KASIR: MELIHAT PRODUK
    // ===============================

    Route::get('/products', [ProductController::class, 'index'])
        ->name('products.index');

    // ADMIN: MENGELOLA PRODUK
    Route::middleware('role:admin')->group(function () {

        Route::get('/products/create', [ProductController::class, 'create'])
            ->name('products.create');

        Route::post('/products', [ProductController::class, 'store'])
            ->name('products.store');

        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])
            ->name('products.edit');

        Route::put('/products/{product}', [ProductController::class, 'update'])
            ->name('products.update');

        Route::patch('/products/{product}', [ProductController::class, 'update']);

        Route::delete('/products/{product}', [ProductController::class, 'destroy'])
            ->name('products.destroy');

    });

    // DETAIL PRODUK: ADMIN DAN KASIR
    Route::get('/products/{product}', [ProductController::class, 'show'])
        ->name('products.show');

    // ===============================
    // KATEGORI: ADMIN
    // ===============================

    Route::middleware('role:admin')->group(function () {

        Route::resource('categories', CategoryController::class);

        Route::resource('suppliers', SupplierController::class);

        // LAPORAN
        Route::get('/laporan', [ReportController::class, 'index'])
            ->name('reports.index');

        // PENGATURAN
        Route::get('/pengaturan', [SettingController::class, 'index'])
            ->name('settings.index');

        Route::put('/pengaturan', [SettingController::class, 'update'])
            ->name('settings.update');

    });

    // ===============================
    // PELANGGAN: ADMIN DAN KASIR
    // ===============================

    Route::resource('customers', CustomerController::class);

    // ===============================
    // PENJUALAN: ADMIN DAN KASIR
    // ===============================

    Route::get('/sales', [SaleController::class, 'index'])
        ->name('sales.index');

    Route::get('/sales/create', [SaleController::class, 'create'])
        ->name('sales.create');

    Route::post('/sales', [SaleController::class, 'store'])
        ->name('sales.store');

    Route::get('/sales/{id}', [SaleController::class, 'show'])
        ->name('sales.show');

    // ===============================
    // RIWAYAT TRANSAKSI
    // ADMIN DAN KASIR
    // ===============================

    Route::get('/riwayat-transaksi', [TransactionHistoryController::class, 'index'])
        ->name('history.index');

});
