<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\WarehouseMovement;
use Illuminate\Http\Request;

class WarehouseMovementController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    public function showProductRecord($product_id)
    {
        $product = Product::with(['movements' => ['user', 'concept'], 'unit'])
            ->find($product_id);

        // return $product;

        return inertia('Warehouse/ShowProductRecord', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WarehouseMovement  $warehouseMovement
     * @return \Illuminate\Http\Response
     */
    public function edit(WarehouseMovement $warehouseMovement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WarehouseMovement  $warehouseMovement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WarehouseMovement $warehouseMovement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WarehouseMovement  $warehouseMovement
     * @return \Illuminate\Http\Response
     */
    public function destroy(WarehouseMovement $warehouseMovement)
    {
        //
    }
}
