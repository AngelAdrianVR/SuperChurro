<?php

namespace App\Http\Controllers;

use App\Models\MovementConcept;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\WarehouseMovement;
use Illuminate\Http\Request;

class WarehouseMovementController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        $products = Product::with('unit')->get();
        $movement_concepts = MovementConcept::all();

        return inertia('Warehouse/Movement/Create', compact('products', 'movement_concepts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.product_id' => 'required|numeric|min:1',
            'movement_concept_id' => 'required|numeric|min:1',
            'notes' => 'max:191',
        ]);

        $adition_data = ['user_id' => auth()->id(), 'warehouse_id' => 1];

        $warehouse = Warehouse::find(1);
        $current_products = $warehouse->products;

        // create movements
        foreach ($request->items as $item) {
            WarehouseMovement::create([
                'quantity' => $item['quantity'],
                'product_id' => $item['product_id'],
                'movement_concept_id' => $request->movement_concept_id,
                'notes' => $request->notes,
            ] + $adition_data);

            // update stock in warehouse
            if ($request->movement_is_entry)
                $current_products[$item['product_id']] += $item['quantity'];
            else
                $current_products[$item['product_id']] -= $item['quantity'];
        }

        $warehouse->update(['products' => $current_products]);

        request()->session()->flash('flash.banner', 'Se ha generado los movimientos correctamente');
        request()->session()->flash('flash.bannerStyle', 'success');

        return to_route('warehouses.index');
    }

    public function showProductRecord($product_id)
    {
        $product = Product::with(['movements' => ['user', 'concept'], 'unit'])
            ->find($product_id);

            // $item->load(array('tags' => function($query) {
            // $query->orderBy('tag.name');
            // }));

        // return $product;

        return inertia('Warehouse/ShowProductRecord', compact('product'));
    }

    public function edit(WarehouseMovement $warehouseMovement)
    {
        //
    }

    public function update(Request $request, WarehouseMovement $warehouseMovement)
    {
        //
    }

    public function destroy(WarehouseMovement $warehouseMovement)
    {
        //
    }
}
