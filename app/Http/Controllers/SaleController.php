<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sales = Sale::all();
 

        return inertia('Sales/Index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::all();
        return inertia('Sales/Create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cart = Cart::find(1);   
        $cart_products = $cart->products;

        $sales = Cart::find(1);
        $solt_products = [];

        for($i=0; $i<count($cart_products); $i++){
            $solt_products[$i] = $cart_products[$i+1] - $request->remaining[$i];
        }
        //  return $solt_products;
        // Sale::create()
        
        for($i=0; $i<count($cart_products); $i++){
            $cart_products[$i+1] = $request->remaining[$i];
        }
    
        $cart->products = $cart_products;
        $cart->save();
        
        request()->session()->flash('flash.banner', '¡Se ha creado el corte correctamente!');
        request()->session()->flash('flash.bannerStyle', 'success'); 
        return redirect()->route('carts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        //
    }
}
