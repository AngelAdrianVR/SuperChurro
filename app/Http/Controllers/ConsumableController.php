<?php

namespace App\Http\Controllers;

use App\Http\Resources\ConsumableResource;
use App\Models\Consumable;
use App\Models\Unit;
use Illuminate\Http\Request;

class ConsumableController extends Controller
{

    public function index()
    {
        $consumables = ConsumableResource::collection(Consumable::with('unit', 'media')->get());

        return inertia('Consumable/Index', compact('consumables'));
    }

    public function create()
    {
        $units = Unit::all();

        return inertia('Consumable/Create', compact('units'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:25',
            'low_stock' => 'numeric',
            'unit_id' => 'required',
            'code' => 'nullable|string',
        ]);

        $new_consumable = Consumable::create($validated);

        // Guardar el archivo en media
        if ($request->hasFile('media')) {
            $new_consumable->addAllMediaFromRequest()->each(fn ($file) => $file->toMediaCollection());
        }

        return to_route('consumables.index');
    }

    public function show(Consumable $consumable)
    {
        //
    }

    public function edit(Consumable $consumable)
    {
        $consumable->load('unit', 'media');
        $units = Unit::all();

        return inertia('Consumable/Edit', compact('consumable', 'units'));
    }

    public function update(Request $request, Consumable $consumable)
    {
        $request->validate([
            'name' => 'required|max:25',
            'low_stock' => 'numeric',
            'unit_id' => 'required',
            'code' => 'nullable|string',
        ]);

        $consumable->update($request->all());

        return to_route('consumables.index');
    }

    public function updateWithMedia(Request $request, Consumable $consumable)
    {
        $request->validate([
            'name' => 'required|max:25',
            'low_stock' => 'numeric',
            'unit_id' => 'required',
            'code' => 'nullable|string',
        ]);

        $consumable->update($request->all());

        // update image
        $consumable->clearMediaCollection();
        $consumable->addAllMediaFromRequest()->each(fn ($file) => $file->toMediaCollection());

        return to_route('consumables.index');
    }

    public function destroy(Consumable $consumable)
    {
        $consumable->delete();

        return redirect()->route('consumables.index');
    }
}
