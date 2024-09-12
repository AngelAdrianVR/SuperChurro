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
        $total_items = ProductRequest::with('user')->latest()->get();
        $requests = ProductRequestHistoryResource::collection($total_items->take(30));

        return response()->json(['items' => $requests, 'total_items' => $total_items->count()]);
    }

    public function create()
    {
        $products = Product::all();

        return inertia('ProductRequest/Create', compact('products'));
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
        foreach ($request->items as $item) {
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

    public function getItemsByPage($currentPage)
    {
        $offset = $currentPage * 30;
        $requests = ProductRequestHistoryResource::collection(ProductRequest::with('user')->latest()->get()
            ->skip($offset)
            ->take(30));

        return response()->json(['items' => $requests]);
    }

    // public function history()
    // {
    //     $requests = ProductRequestHistoryResource::collection(ProductRequest::with('user')->latest()->get()->take(30));

    //     return inertia('ProductRequest/History', compact('requests'));
    // }
}
