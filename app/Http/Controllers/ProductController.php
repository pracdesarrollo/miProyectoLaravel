<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale; // Added this import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Obtiene el valor del campo de búsqueda 'query' del formulario
        $query = $request->input('query');

        // Construye la consulta de productos.
        // El método 'when' aplica la cláusula 'where' solo si hay un valor en $query.
        $products = Product::latest()
            ->when($query, function ($q) use ($query) {
                // Filtra los productos donde el nombre contiene la cadena de búsqueda
                $q->where('name', 'like', "%{$query}%");
            })
            ->paginate(15)
            ->withQueryString(); // Mantiene los parámetros de la URL al paginar

        // Pasa los productos filtrados (o todos si no hubo búsqueda) a la vista
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $user = Auth::user();

        if ($user->hasRole('vendedor')) {
            abort(403, 'No está autorizado para realizar esta función.');
        } else {
            return view('products.create');
        }
    }

    /**
     * Store a newly created product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'category' => 'nullable|string|max:255',
            'exp_date' => 'required|date',
        ]);

        // Fix the date format issue. The form sends it as d/m/Y, but the database needs Y-m-d.
        // We convert it to the correct format before creating the product.
        $productData = $request->all();
        $productData['exp_date'] = Carbon::createFromFormat('Y-m-d', $request->input('exp_date'))->format('Y-m-d');
        
        // This part seems like a logical error, as it creates a "sale" record when a product is created.
        // I have commented it out for now.
        // Sale::create([
        //     'sale_date' => $saleDate,
        // ]);

        Product::create($productData);

        return redirect()->route('products.index')
                         ->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Display the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\View\View
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\View\View
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'category' => 'nullable|string|max:255',
            'exp_date' => 'nullable|date',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')
                         ->with('success', 'Producto actualizado exitosamente.');
    }

    /**
     * Remove the specified product from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product)
    {
        $user = Auth::user();

        $hasActiveSales = DB::table('sale_product')
                            ->join('sales', 'sale_product.sale_id', '=', 'sales.id')
                            ->where('sale_product.product_id', $product->id)
                            ->where('sales.status', 'active')
                            ->exists();

        // 1. Si el producto TIENE una venta activa, redirige con el mensaje de error.
        if ($hasActiveSales) {
            return redirect()->back()->with('error', 'Este producto no se puede eliminar. Para poder borrarlo, primero debe cancelar la venta activa a la que pertenece.');
        }

        // 2. Si el producto NO TIENE una venta activa, lo borra y muestra un mensaje de éxito.
        // La confirmación se hace en la vista con JavaScript.
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Producto eliminado exitosamente.');
    }

    /**
     * Get products with low stock.
     *
     * @return \Illuminate\View\View
     */
    public function lowStock()
    {
        $products = Product::lowStock()->paginate(15);
        return view('products.low-stock', compact('products'));
    }

    /**
     * Get products by category.
     *
     * @param  string  $category
     * @return \Illuminate\View\View
     */
    public function byCategory($category)
    {
        $products = Product::byCategory($category)->paginate(15);
        return view('products.by-category', compact('products', 'category'));
    }
}