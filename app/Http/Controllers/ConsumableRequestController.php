<?php

namespace App\Http\Controllers;

use App\Http\Resources\ConsumableRequestResource;
use App\Models\Consumable;
use App\Models\ConsumableRequest;
use Illuminate\Http\Request;

class ConsumableRequestController extends Controller
{

    public function index()
    {
        $total_items = ConsumableRequest::with('user')->latest()->get();
        $requests = ConsumableRequestResource::collection($total_items->take(30));

        return response()->json(['items' => $requests, 'total_items' => $total_items->count()]);
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

    public function show(ConsumableRequest $consumable_request)
    {
        $consumables = Consumable::with('unit')->get();

        return inertia('ConsumableRequest/Show', compact('consumable_request', 'consumables'));
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

    public function getItemsByPage($currentPage)
    {
        $offset = $currentPage * 30;
        $requests = ConsumableRequestResource::collection(ConsumableRequest::with('user')->latest()->get()
            ->skip($offset)
            ->take(30));

        return response()->json(['items' => $requests]);
    }

}
