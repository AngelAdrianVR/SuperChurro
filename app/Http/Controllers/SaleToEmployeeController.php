<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SaleToEmployee;
use Illuminate\Http\Request;

class SaleToEmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::with('unit')->get();

        return inertia('SaleToEmployee/Create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.product_id' => 'required|numeric|min:1',
        ]);

        // create sells
        SaleToEmployee::create([
            'products' => $request->items,
            'user_id' => auth()->id()
        ]);

        request()->session()->flash('flash.banner', 'Se registró la venta a ' . auth()->user()->name);
        request()->session()->flash('flash.bannerStyle', 'success');

        return to_route('carts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SaleToEmployee  $saleToEmployee
     * @return \Illuminate\Http\Response
     */
    public function show(SaleToEmployee $saleToEmployee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SaleToEmployee  $saleToEmployee
     * @return \Illuminate\Http\Response
     */
    public function edit(SaleToEmployee $saleToEmployee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SaleToEmployee  $saleToEmployee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SaleToEmployee $saleToEmployee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SaleToEmployee  $saleToEmployee
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleToEmployee $saleToEmployee)
    {
        //
    }
}
