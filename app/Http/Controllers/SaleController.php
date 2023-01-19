<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $products = Product::all();
        // return $sales;
        return inertia('Sales/Index', compact('products'));
    }

    public function create()
    {
        $products = Product::all();
        return inertia('Sales/Create', compact('products'));
    }

    public function store(Request $request)
    {
        $sales = [];
        $new_cart_stock = [];
        $cart = Cart::first();

        foreach ($cart->products as $product_id => $quantity) {
            $request->validate([
                "product.$product_id" => "numeric|max:$quantity"
            ]);

            $remaining_quantity = $request->product[$product_id];
            $new_cart_stock[$product_id] = $remaining_quantity;
            $sales[] = [
                'quantity' => $cart->products[$product_id] - $request->product[$product_id],
                'product_id' => $product_id,
                'price_id' => Product::find($product_id)->currentPrice->id,
                'created_at' => now(),
            ];
        }

        Sale::insert($sales);

        $cart->products = $new_cart_stock;
        $cart->save();

        request()->session()->flash('flash.banner', '¡Se ha creado el corte correctamente!');
        request()->session()->flash('flash.bannerStyle', 'success');
        return redirect()->route('carts.index');
    }

    public function show($sale_date)
    {
        $sale = Sale::whereDate('created_at', $sale_date)->get();
        dd($sale);
    }

    public function edit(Sale $sale)
    {
        //
    }

    public function update(Request $request, Sale $sale)
    {
        //
    }

    public function destroy(Sale $sale)
    {
        //
    }

    public function getByDate(Request $request)
    {
        $sales = Sale::whereDate('created_at', $request->date)->get();

        return response()->json(['sales' => $sales]);
    }
}
