<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;


class SaleController extends Controller
{
     public function index()
    {
        $sales = Sale::with(['product', 'user'])->latest()->paginate(15);
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $products = Product::available()->get();
        $users = User::all();
        return view('sales.create', compact('products', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'nullable|exists:users,id',
            'quantity' => 'required|integer|min:1',
            'sale_date' => 'required|date',
        ]);

        $product = Product::findOrFail($request->product_id);

        if (!$product->reduceStock($request->quantity)) {
            return back()->withErrors(['quantity' => 'Stock insuficiente']);
        }

        $sale = Sale::create([
            'product_id' => $request->product_id,
            'user_id' => $request->user_id,
            'quantity' => $request->quantity,
            'sale_date' => $request->sale_date,
            'total_price' => $product->price * $request->quantity,
        ]);

        return redirect()->route('sales.index')
                         ->with('success', 'Venta registrada exitosamente.');
    }

    public function show(Sale $sale)
    {
        return view('sales.show', compact('sale'));
    }

    public function destroy(Sale $sale)
    {
        // Restaurar stock al producto
        if ($sale->product) {
            $sale->product->increment('stock', $sale->quantity);
        }

        $sale->delete();

        return redirect()->route('sales.index')
                         ->with('success', 'Venta eliminada exitosamente.');
    }

    public function reports()
    {
        $todaySales = Sale::today()->sum('total_price');
        $monthSales = Sale::byMonth(now()->month)->sum('total_price');
        $totalSales = Sale::sum('total_price');

        return view('sales.reports', compact('todaySales', 'monthSales', 'totalSales'));
    }
}
