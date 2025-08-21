<?php
// app/Http/Controllers/ProductController.php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(15);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'category' => 'nullable|string|max:255',
            'exp_date' => 'nullable|date',
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')
                         ->with('success', 'Producto creado exitosamente.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

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

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
                         ->with('success', 'Producto eliminado exitosamente.');
    }

    public function lowStock()
    {
        $products = Product::lowStock()->paginate(15);
        return view('products.low-stock', compact('products'));
    }

    public function byCategory($category)
    {
        $products = Product::byCategory($category)->paginate(15);
        return view('products.by-category', compact('products', 'category'));
    }
}