<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('name')->paginate(20);
        return view('purchasing.products.index', compact('products'));
    }

    public function create()
    {
        return view('purchasing.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'cost_price' => 'required|numeric|min:0',
            'sales_price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'status' => 'required|in:active,phased_out,out_of_stock',
            'length' => 'required|numeric|min:0',
            'width' => 'required|numeric|min:0',
            'breadth' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
        ]);

        if ((int) $validated['stock'] === 0) {
            $validated['status'] = 'out_of_stock';
        }

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Product succesvol aangemaakt');
    }

    public function edit(Product $product)
    {
        return view('purchasing.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'cost_price' => 'required|numeric|min:0',
            'sales_price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
            'status' => 'required|in:active,phased_out,out_of_stock',
            'length' => 'required|numeric|min:0',
            'width' => 'required|numeric|min:0',
            'breadth' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
        ]);

        if ((int) $validated['stock'] === 0) {
            $validated['status'] = 'out_of_stock';
        }

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Product succesvol bijgewerkt');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product succesvol verwijderd');
    }
}
