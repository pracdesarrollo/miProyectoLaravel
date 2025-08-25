<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Sale;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Si el usuario es administrador, carga los datos para el dashboard de administrador
        if ($user->isAdmin()) {
            $totalProducts = Product::count();
            $totalUsers = User::count();
            $todaySales = Sale::today()->sum('total_price');
            $lowStockCount = Product::lowStock()->count();
            $lowStockProducts = Product::lowStock(5, 5); // Obtiene 5 productos con stock bajo
            $recentSales = Sale::with(['product', 'user'])->orderBy('sale_date', 'desc')->limit(5)->get();

            return view('dashboard.admin.dashboard', compact(
                'totalProducts',
                'totalUsers',
                'todaySales',
                'lowStockCount',
                'lowStockProducts',
                'recentSales'
            ));
        }

        // Si el usuario es vendedor, carga los datos para su dashboard
        if ($user->isVendedor()) {
            $recentSales = Sale::where('user_id', $user->id)->latest()->limit(5)->get();
            
            return view('dashboard.vendedor.index', compact('recentSales'));
        }

        // En caso de que no sea ni admin ni vendedor, o para un rol por defecto.
        return view('dashboard');
    }
}