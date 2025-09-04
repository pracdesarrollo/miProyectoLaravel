<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Si es gerente, ve todas las ventas
        if ($user->role === 'gerente') {
            $query = Sale::with('user', 'products')->latest();
        } else {
            // Si NO es gerente, ve solo sus propias ventas
            $query = $user->sales()->with('products')->latest();
        }
        
        // Filtro de búsqueda aplicado después de definir el query correcto
        if ($request->filled('query')) {
            $searchTerm = $request->input('query');
            $query->where(function ($q) use ($searchTerm) {
                $q->whereHas('products', function ($p) use ($searchTerm) {
                    $p->where('name', 'like', "%{$searchTerm}%");
                })
                ->orWhereHas('user', function ($u) use ($searchTerm) {
                    $u->where('name', 'like', "%{$searchTerm}%");
                });
            });
        }

        $sales = $query->paginate(10);

        return view('sales.index', compact('sales'));
    }

    public function create(Request $request)
    {
        $products = Product::all();
        $users = User::all();

        return view('sales.create', compact('products', 'users'));
    }
    
    public function store(Request $request)
    {
        $userId = Auth::id();
        
        $request->validate([
            'sale_datetime' => 'required|date',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);
        
        DB::transaction(function () use ($request, $userId) {
            $totalPrice = 0;
            $productsToAttach = [];
            
            foreach ($request->input('products') as $productData) {
                $product = Product::find($productData['product_id']);
                if ($product) {
                    $subtotal = $product->price * $productData['quantity'];
                    $totalPrice += $subtotal;
                    
                    $productsToAttach[$product->id] = [
                        'quantity' => $productData['quantity'],
                        'price_at_sale' => $product->price,
                    ];
                }
            }

            $sale = Sale::create([
                'user_id' => $userId, 
                'sale_date' => $request->input('sale_datetime'),
                'total_price' => $totalPrice,
            ]);
            
            $sale->products()->attach($productsToAttach);
        });

        return redirect()->route('sales.index')->with('success', 'Venta registrada con éxito.');
    }
    
    public function show(Sale $sale)
    {
        $sale->load('user', 'products');
        
        return view('sales.show', compact('sale'));
    }
}
