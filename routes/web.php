<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

// Rutas de Productos
Route::resource('products', ProductController::class);
Route::get('products/stock/low', [ProductController::class, 'lowStock'])->name('products.low-stock');
Route::get('products/category/{category}', [ProductController::class, 'byCategory'])->name('products.by-category');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

// Rutas de Usuarios
Route::resource('users', UserController::class);

// Rutas de Ventas
Route::resource('sales', SaleController::class)->except(['edit', 'update']);
Route::get('sales/reports', [SaleController::class, 'reports'])->name('sales.reports');

// Rutas de autenticación (si usas Laravel Breeze/Jetstream)
// require __DIR__.'/auth.php';