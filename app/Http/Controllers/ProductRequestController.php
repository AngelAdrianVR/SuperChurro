<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductRequestHistoryResource;
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
        $items = $request->validate([
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.product_id' => 'required|numeric|min:1',
        ]);

        // create request
        ProductRequest::create([
            'products' => $items['items'],
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
        $cart->update(['products' => $current_products_cart]);

        request()->session()->flash('flash.banner', 'Se ha pasado la mercancía de la cocina al carrito');
        request()->session()->flash('flash.bannerStyle', 'success');

        return to_route('sales.point');
    }

    public function show(ProductRequest $product_request)
    {
        $products = Product::with('unit')->get();
        
        return inertia('ProductRequest/Show', compact('product_request', 'products'));
    }


    public function edit(ProductRequest $productRequest)
    {
        //
    }


    public function update(Request $request, ProductRequest $productRequest)
    {
        //
    }


    public function destroy(ProductRequest $productRequest)
    {
        //
    }

    public function history()
    {
        $requests = ProductRequestHistoryResource::collection(ProductRequest::with('user')->latest()->paginate(30));
        // return $requests;
        return inertia('ProductRequest/History', compact('requests'));
    }
}
