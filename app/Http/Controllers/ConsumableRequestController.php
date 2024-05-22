<?php

namespace App\Http\Controllers;

use App\Models\Consumable;
use App\Models\ConsumableRequest;
use Illuminate\Http\Request;

class ConsumableRequestController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        $consumables = Consumable::all();

        return inertia('ConsumableRequest/Create', compact('consumables'));
    }

    public function store(Request $request)
    {
        $items = $request->validate([
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.consumable_id' => 'required|numeric|min:1',
        ]);

        // create request
        ConsumableRequest::create([
            'consumables' => $items['items'],
            'user_id' => auth()->id(),
            'cart_id' => 1,
            'notes' => $request->notes,
        ]);

        return to_route('sales.point');
    }

    public function show(ConsumableRequest $consumableRequest)
    {
        //
    }

    public function edit(ConsumableRequest $consumableRequest)
    {
        //
    }

    public function update(Request $request, ConsumableRequest $consumableRequest)
    {
        //
    }

    public function destroy(ConsumableRequest $consumableRequest)
    {
        //
    }
}
