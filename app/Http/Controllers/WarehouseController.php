<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouse = Warehouse::first();
        $products = Product::with('unit','media')->get();
        $employees = User::all()->filter(
            fn($user) => $user->hasCheckedInToday() && $user->shiftOn(today()->dayOfWeek) === 'cocina'
        );

        return inertia('Warehouse/Index', compact('warehouse', 'products', 'employees'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Warehouse $warehouse)
    {
        //
    }

    public function edit(Warehouse $warehouse)
    {
        //
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        //
    }

    public function destroy(Warehouse $warehouse)
    {
        //
    }

    public function getProducts()
    {
        $item = Warehouse::find(1)->products;

        return response()->json(compact('item'));
    }
}
