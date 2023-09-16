<?php

namespace App\Http\Controllers;

use App\Models\Outcome;
use Illuminate\Http\Request;

class OutcomeController extends Controller
{

    public function index()
    {
        $total_outcomes_money = 0;
        $outcomes = Outcome::with('user')->latest()->get()->groupBy(function ($data) {
            return $data->created_at->toDateString();
        });

        // return $outcomes;
        foreach ($outcomes as $outcome) {
            $total_outcomes_money += $outcome->sum(function ($outcome) {
                return $outcome->cost * $outcome->quantity;
            });
        }

        $total_outcomes_money = number_format($total_outcomes_money, 2);

        return inertia('Outcome/Index', compact('outcomes', 'total_outcomes_money'));
    }


    public function create()
    {
        return inertia('Outcome/Create');
    }


    public function store(Request $request)
    {
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
        $outcomes = Outcome::whereDate('created_at', $outcome->created_at)->get();

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

    public function filter(Request $request)
    {
        $total_outcomes_money = 0;
        $outcomes = Outcome::query()->when($request->year, function ($query) use ($request) {
            return $query->whereYear('created_at', $request->year);
        })->when($request->month, function ($query) use ($request) {
            return $query->whereMonth('created_at', $request->month);
        })->with('user')->latest()->get()->groupBy(function ($data) {
            return $data->created_at->toDateString();
        });


        foreach ($outcomes as $outcome) {
            $total_outcomes_money += $outcome->sum(function ($outcome) {
                return $outcome->cost * $outcome->quantity;
            });
        }

        $total_outcomes_money = number_format($total_outcomes_money, 2);

        return response()->json(compact('outcomes', 'total_outcomes_money'));
    }
}
