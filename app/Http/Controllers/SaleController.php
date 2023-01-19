<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::all();
        return inertia('Sales/Index', compact('sales'));
    }

    public function create()
    {
        $products = Product::all();
        return inertia('Sales/Create', compact('products'));
    }

    public function store(Request $request)
    {
        $cart = Cart::first();   
        $cart_products_ids = collect($cart->products)->keys();
        // $solt_products = $cart->products; 

        $cart_products_ids->each(function ($product_id) use ($cart, $request) {
            $cart->products[$product_id] - $request->remaining[$product_id];
            // revisar la manera en que se guardan los sobrantes desde la vista
        });

        // for($i=0; $i<count($cart_products); $i++){
        //     $solt_products[$i+1] = $cart_products[$i+1] - $request->remaining[$i];
        // }
        //  return $solt_products;
        // Sale::create()
        
        // for($i=0; $i<count($cart_products); $i++){
        //     $cart_products[$i+1] = $request->remaining[$i];
        // }
    
        // $cart->products = $cart_products;
        // $cart->save();
        
        request()->session()->flash('flash.banner', '¡Se ha creado el corte correctamente!');
        request()->session()->flash('flash.bannerStyle', 'success'); 
        return redirect()->route('carts.index');
    }

    public function show(Sale $sale)
    {
        //
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
}
