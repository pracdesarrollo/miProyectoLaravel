<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use App\Models\User;
use App\Models\Product;
use App\Models\Sale;
use App\Http\Controllers\ReportController;


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
    // CRUD completo de productos
    Route::resource('products', ProductController::class);

    // CRUD de usuarios
    Route::resource('users', UserController::class);


    // CRUD de ventas
    Route::resource('sales', SaleController::class);
    

   // Ruta para la vista del formulario
   Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

   // **Ruta POST para el reporte en pantalla (AJAX)**
   Route::post('/reports/generate', [ReportController::class, 'generateApi'])->name('reports.generate_api');

   // **Nueva ruta GET para la descarga del PDF**
   Route::get('/reports/sale-pdf', [ReportController::class, 'generatePdf'])->name('reports.sale_pdf');
});

require __DIR__.'/auth.php';
