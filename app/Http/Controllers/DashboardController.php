<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth()->user();
        $data = [];

        // Si el usuario es administrador o gerente
        if ($user->hasRole('admin') || $user->hasRole('gerente')) {
            $data['totalProducts'] = Product::count();
            $data['totalUsers'] = User::count();
            $data['todaySales'] = Sale::today()->sum('total_price');
            $data['lowStockCount'] = Product::lowStock()->count();
            $data['lowStockProducts'] = Product::lowStock(5, 5); 
            $data['recentSales'] = Sale::with(['products', 'user'])->orderBy('sale_date', 'desc')->limit(5)->get();
            $data['products'] = Product::all();
        }

        // Si el usuario es vendedor
        if ($user->hasRole('vendedor')) {
            $data['recentSales'] = Sale::where('user_id', $user->id)->latest()->limit(5)->get();
            $data['products'] = Product::all();
        }

        // Si el usuario es administrador, también carga los productos para la sección de "todos los productos"
        if ($user->hasRole('admin')) {
             $data['products'] = Product::all();
        }

        // Retorna la única vista para todos los roles, pasando los datos necesarios
        return view('dashboard.general', $data);
    }
}