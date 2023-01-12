<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductRequest;
use App\Models\Warehouse;
use App\Models\WarehouseMovement;
use Illuminate\Http\Request;

class ProductRequestController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        $products = Product::all();
        $warehouse_stock = Warehouse::find(1)->products;

        return inertia('ProductRequest/Create', compact('products', 'warehouse_stock'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.product_id' => 'required|numeric|min:1',
        ]);

        // create request
        ProductRequest::create([
            'products' => $request->items,
            'user_id' => auth()->id(),
            'cart_id' => 1,
        ]);

        // update warehouse stock
        $warehouse = Warehouse::find(1);
        $current_products = $warehouse->products;

        $cart = Cart::find(1);
        $current_products_cart = $cart->products;      
        foreach($request->items as $item) {
            WarehouseMovement::create([
                'quantity' => $item['quantity'],
                'product_id' => $item['product_id'],
                'movement_concept_id' => 3,
                'notes' => 'Mercancía solicitada para carrito 1',
                'user_id' => auth()->id(),
                'warehouse_id' => 1
            ]);

            $current_products[$item['product_id']] -= $item['quantity'];
            $current_products_cart[$item['product_id']] += $item['quantity'];
        }

        $warehouse->update(['products' => $current_products]);

        request()->session()->flash('flash.banner', 'Se ha pasado la mercancía de la cocina al carrito');
        request()->session()->flash('flash.bannerStyle', 'success');

        return to_route('carts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductRequest  $productRequest
     * @return \Illuminate\Http\Response
     */
    public function show(ProductRequest $productRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductRequest  $productRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductRequest $productRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductRequest  $productRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductRequest $productRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductRequest  $productRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductRequest $productRequest)
    {
        //
    }
}
