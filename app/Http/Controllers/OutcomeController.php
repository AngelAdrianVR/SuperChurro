<?php

namespace App\Http\Controllers;

use App\Models\Outcome;
use Illuminate\Http\Request;

class OutcomeController extends Controller
{
    
    public function index()
    {
        $outcomes = Outcome::with('user')->latest()->get()->groupBy('created_at');
        // return $outcomes;
        return inertia('Outcome/Index', compact('outcomes'));
    }

    
    public function create()
    {
        return inertia('Outcome/Create');
    }

    
    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'items.*.concept' => 'required|max:191',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.cost' => 'required|numeric|min:1',
            'notes' => 'max:191|nullable',
        ]);
     
        foreach ($request->items as $item) {
            Outcome::create([
                'concept' => $item['concept'],
                'quantity' => $item['quantity'],
                'cost' => $item['cost'],
                'notes' => $request->notes,
                'user_id' => auth()->id(),
                ]);
            }

            return to_route('outcomes.index');
    }

    
    public function show(Outcome $outcome)
    {
        $outcomes = Outcome::where('created_at', $outcome->created_at)->get();
        return inertia('Outcome/Show', compact('outcomes'));
    }

    
    public function edit(Outcome $outcome)
    {

    }

    
    public function update(Request $request, Outcome $outcome)
    {
        $outcome->update([
            'concept' => $request->concept,
            'quantity' => $request->quantity,
            'cost' => $request->cost
        ]);
    }

   
    public function destroy(Outcome $outcome)
    {
        //
    }
}
