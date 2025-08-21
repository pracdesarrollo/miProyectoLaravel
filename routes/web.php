<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth', 'admin'])->group(function () {
    // CRUD completo de productos
    Route::resource('products', App\Http\Controllers\ProductController::class)->except(['index', 'show']);

    // CRUD de usuarios
    Route::resource('users', App\Http\Controllers\UserController::class);
    
    // Rutas adicionales del administrador
    Route::get('/products/low-stock', [App\Http\Controllers\ProductController::class, 'lowStock'])->name('products.low-stock');
    Route::get('/sales/reports', [App\Http\Controllers\SaleController::class, 'reports'])->name('sales.reports');
});

require __DIR__.'/auth.php';
