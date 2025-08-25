<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use App\Models\User;
use App\Models\Product;

Route::get('/', function () {
    return view('index');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

    // CRUD completo de productos
    Route::resource('products', App\Http\Controllers\ProductController::class);

    // CRUD de usuarios
    Route::resource('users', App\Http\Controllers\UserController::class);
    
    // Rutas adicionales del administrador
    Route::get('/products/low-stock', [App\Http\Controllers\ProductController::class, 'lowStock'])->name('products.low-stock');
    Route::get('/sales/reports', [App\Http\Controllers\SaleController::class, 'reports'])->name('sales.reports');


require __DIR__.'/auth.php';
