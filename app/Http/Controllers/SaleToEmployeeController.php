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
            'notes' => 'max:255'
        ]);

        $cart = Cart::first();
        $updated_cart_stock = $cart->products;

        // add aditional info to each sale before creating
        foreach ($validated['items'] as $sale) {
            if(boolval($request->is_sell_to_employee)) {
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


        request()->session()->flash('flash.banner', 'Se registró la venta/cortesía');
        request()->session()->flash('flash.bannerStyle', 'success');

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
}
