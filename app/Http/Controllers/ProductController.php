<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Price;
use App\Models\Product;
use App\Models\Unit;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class productController extends Controller
{
    
    public function index()
    {
        $products = ProductResource::collection(Product::with('unit', 'currentPrice')->get());
        // return $products;
        return inertia('Product/Index', compact('products'));
    }

    
    public function create()
    {
        $units = Unit::all();
        return inertia('Product/Create', compact('units'));
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:25',
            'low_stock' => 'numeric',
            'unit_id' => 'required',
        ]);

        // return $request;

       $new_product = Product::create($validated);
        Price::create([
            'price' => $request->price,
            'product_id' => $new_product->id,
            'created_at' => now(),
        ]);

        // Add new product to warehouse
        $warehouse = Warehouse::first();
        $products = $warehouse->products + [$new_product->id => $request->initial_stock];
        $warehouse->update(['products' => $products]);

        request()->session()->flash('flash.banner', '¡Se ha creado un nuevo producto correctamente!');
        request()->session()->flash('flash.bannerStyle', 'success');

        return to_route('products.index');
    }

    
    public function show(product $product)
    {
        $product = Product::with('currentPrice', 'unit')->find($product->id);
        $units = Unit::all();

        return inertia('Product/Show', compact('product', 'units'));
    }

    
    public function edit(product $product)
    {
        //
    }

    
    public function update(Request $request, product $product)
    {
        $validated = $request->validate([
            'name' => 'required|max:25',
            'low_stock' => 'numeric',
            'unit_id' => 'required',
        ]);

       $product->update($validated);
        Price::create([
            'price' => $request->price,
            'product_id' => $product->id,
            'createdated_at' => now(),
        ]);

        request()->session()->flash('flash.banner', '¡Se ha actualizado correctamente!');
        request()->session()->flash('flash.bannerStyle', 'success');

        return to_route('products.index');
    }

    
    public function destroy(product $product)
    {
        $product->delete();
        request()->session()->flash('flash.banner', '¡Se ha eliminado correctamente!');
        request()->session()->flash('flash.bannerStyle', 'success'); 
        return redirect()->route('products.index');
    }
}
