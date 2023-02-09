<?php

namespace App\Http\Controllers;

use App\Models\Bonus;
use Illuminate\Http\Request;

class BonusController extends Controller
{
    public function index()
    {
        $bonuses = Bonus::all();

        return inertia('Bonus/Index', compact('bonuses'));
    }

    public function create()
    {
        return inertia('Bonus/Create');
    }

    public function edit(Bonus $bonus)
    {
        return inertia('Bonus/Edit', compact('bonus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric',
        ]);

        Bonus::create($validated);

        request()->session()->flash('flash.banner', 'Se ha creado un nuevo bono');
        request()->session()->flash('flash.bannerStyle', 'success');

        return to_route('bonuses.index');
    }

    public function update(Request $request, Bonus $bonus)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric',
        ]);

        $bonus->update($validated);

        request()->session()->flash('flash.banner', 'Se ha actualizado el bono');
        request()->session()->flash('flash.bannerStyle', 'success');

        return to_route('bonuses.index');
    }
    
    public function toggleStatus(Bonus $bonus)
    {
        $bonus->is_active = !$bonus->is_active;
        $bonus->save();

        return to_route('bonuses.index');
    }
}
