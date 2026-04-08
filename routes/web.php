<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\lokasiController;
use App\Http\Controllers\roleController;
use App\Http\Controllers\usersController;
use App\Http\Controllers\picController;
use App\Http\Controllers\packageController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KasirController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Group protected routes
Route::middleware(['auth'])->group(function () {
    
    // Admin Routes
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/lokasi', [lokasiController::class, 'index'])->name('admin.lokasi.index');
        Route::get('/lokasi/create', [lokasiController::class, 'create'])->name('admin.lokasi.create');
        Route::post('/lokasi', [lokasiController::class, 'store'])->name('admin.lokasi.store');
        Route::get('/lokasi/{id}/edit', [lokasiController::class, 'edit'])->name('admin.lokasi.edit');
        Route::put('/lokasi/{id}', [lokasiController::class, 'update'])->name('admin.lokasi.update');
        Route::delete('/lokasi/{id}', [lokasiController::class, 'destroy'])->name('admin.lokasi.destroy');

        Route::get('/role', [roleController::class, 'index'])->name('admin.role.index');
        Route::get('/role/create', [roleController::class, 'create'])->name('admin.role.create');
        Route::post('/role', [roleController::class, 'store'])->name('admin.role.store');
        Route::get('/role/{id}/edit', [roleController::class, 'edit'])->name('admin.role.edit');
        Route::put('/role/{id}', [roleController::class, 'update'])->name('admin.role.update');
        Route::delete('/role/{id}', [roleController::class, 'destroy'])->name('admin.role.destroy');

        Route::get('/users', [usersController::class, 'index'])->name('admin.users.index');
        Route::get('/users/create', [usersController::class, 'create'])->name('admin.users.create');
        Route::post('/users', [usersController::class, 'store'])->name('admin.users.store');
        Route::get('/users/{id}/edit', [usersController::class, 'edit'])->name('admin.users.edit');
        Route::put('/users/{id}', [usersController::class, 'update'])->name('admin.users.update');
        Route::delete('/users/{id}', [usersController::class, 'destroy'])->name('admin.users.destroy');

        Route::get('/pic', [picController::class, 'index'])->name('admin.pic.index');
        Route::get('/pic/create', [picController::class, 'create'])->name('admin.pic.create');
        Route::post('/pic', [picController::class, 'store'])->name('admin.pic.store');
        Route::get('/pic/{id}/edit', [picController::class, 'edit'])->name('admin.pic.edit');
        Route::put('/pic/{id}', [picController::class, 'update'])->name('admin.pic.update');
        Route::delete('/pic/{id}', [picController::class, 'destroy'])->name('admin.pic.destroy');

        Route::get('/package', [packageController::class, 'index'])->name('admin.package.index');
        Route::get('/package/create', [packageController::class, 'create'])->name('admin.package.create');
        Route::post('/package', [packageController::class, 'store'])->name('admin.package.store');
        Route::get('/package/{id}/edit', [packageController::class, 'edit'])->name('admin.package.edit');
        Route::put('/package/{id}', [packageController::class, 'update'])->name('admin.package.update');
        Route::delete('/package/{id}', [packageController::class, 'destroy'])->name('admin.package.destroy');

    });

    // Kasir Routes
    Route::middleware(['role:kasir'])->prefix('kasir')->group(function () {
        Route::get('/dashboard', [KasirController::class, 'dashboard'])->name('kasir.dashboard');

        Route::get('/transaksi', [App\Http\Controllers\transaksiController::class, 'index'])->name('kasir.transaksi.index');
        Route::post('/transaksi', [App\Http\Controllers\transaksiController::class, 'store'])->name('admin.transactions.store');
        Route::put('/transaksi/{id}', [App\Http\Controllers\transaksiController::class, 'update'])->name('admin.transactions.update');
        Route::put('/transaksi/{id}/cancel', [App\Http\Controllers\transaksiController::class, 'cancel'])->name('admin.transactions.cancel');
        Route::get('/transaksi/{id}/print', [App\Http\Controllers\transaksiController::class, 'printInvoice'])->name('admin.transactions.print');

        Route::get('/riwayat', [App\Http\Controllers\transaksiController::class, 'riwayat'])->name('kasir.riwayat.index');
    });

    // Owner Routes
    Route::middleware(['role:owner'])->prefix('owner')->group(function () {
        Route::get('/dashboard', [OwnerController::class, 'dashboard'])->name('owner.dashboard');
        
        Route::prefix('audit')->group(function () {
            Route::get('/transactions', [OwnerController::class, 'transactionAudit'])->name('owner.audit.transaksi');
            Route::get('/transactions/export', [OwnerController::class, 'exportTransactions'])->name('owner.audit.transactions.export');
            
            Route::get('/users', [OwnerController::class, 'usersAudit'])->name('owner.audit.users');
            Route::post('/users/{id}/toggle', [OwnerController::class, 'toggleUserStatus'])->name('owner.audit.users.toggle');
            
            Route::get('/assets/packages', [OwnerController::class, 'auditAssetsPackages'])->name('owner.audit.packages');
            Route::get('/assets/photographers', [OwnerController::class, 'auditAssetsPhotographer'])->name('owner.audit.photographers');
        });
    });

});
