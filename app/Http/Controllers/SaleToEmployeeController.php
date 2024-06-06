<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\SaleToEmployee;
use Illuminate\Http\Request;

class SaleToEmployeeController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        $products = Product::with('unit', 'currentPrice', 'currentEmployeePrice')->get();

        return inertia('SaleToEmployee/Create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.product_id' => 'required|numeric|min:1',
            'notes' => 'required|string|max:255',
        ]);

        $cart = Cart::first();
        $updated_cart_stock = $cart->products;

        // add aditional info to each sale before creating
        foreach ($validated['items'] as $sale) {
            if (boolval($request->is_sell_to_employee)) {
                $sale['price'] = Product::find($sale['product_id'])->currentEmployeePrice->price;
                $sale['notes'] = $request->notes;
            } else {
                $sale['price'] = 0;
            }

            $sale['user_id'] = auth()->id();

            // create sales
            SaleToEmployee::create($sale);

            // substract quantity sold to cart stock
            $updated_cart_stock[$sale['product_id']] -= $sale['quantity'];
        }

        // updte cart stock
        $cart->update(['products' => $updated_cart_stock]);

        return to_route('sales.point');
    }

    public function show(SaleToEmployee $saleToEmployee)
    {
        //
    }

    public function edit(SaleToEmployee $saleToEmployee)
    {
        //
    }

    public function update(Request $request, SaleToEmployee $saleToEmployee)
    {
        //
    }

    public function destroy(SaleToEmployee $saleToEmployee)
    {
        //
    }

    // API
    public function storeSpecialCourtesies(Request $request)
    {
        $validated = $request->validate([
            'bolis' => 'required|numeric|min:0',
            'botana' => 'required|numeric|min:0',
        ]);

        $cart = Cart::first();
        $updated_cart_stock = $cart->products;

        // guardar botana si es que es diferente de 0
        if ($validated['botana']) {
            $product_id = 3;
            SaleToEmployee::create([
                'quantity' => $validated['botana'],
                'product_id' => $product_id,
                'notes' => 'Cortesia para viene viene a las ' . now()->toTimeString(),
                'price' => 0,
                'user_id' => auth()->id(),
            ]);

            // substract quantity sold to cart stock
            $updated_cart_stock[$product_id] -= $validated['botana'];
        }
        // guardar bolis si es que es diferente de 0
        if ($validated['bolis']) {
            $product_id = 4;
            SaleToEmployee::create([
                'quantity' => $validated['bolis'],
                'product_id' => $product_id,
                'notes' => 'Cortesia para viene viene a las ' . now()->toTimeString(),
                'price' => 0,
                'user_id' => auth()->id(),
            ]);

            // substract quantity sold to cart stock
            $updated_cart_stock[$product_id] -= $validated['bolis'];
        }

        // updte cart stock
        $cart->update(['products' => $updated_cart_stock]);

        return to_route('sales.point');
    }
}
