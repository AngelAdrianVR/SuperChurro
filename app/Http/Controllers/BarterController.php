<?php

namespace App\Http\Controllers;

use App\Http\Resources\BarterResource;
use App\Models\Barter;
use Illuminate\Http\Request;

class BarterController extends Controller
{

    public function index()
    {
        $barters = BarterResource::collection(Barter::with('receptor','transmitter')->latest()->get());
        // return $barters;
        // $my_barters = BarterResource::collection(auth()->user()->myBarters()->with('receptor')->latest()->get()); //auth user's barters
        // return $barters;
        return inertia('Barter/Index',compact('barters'));
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
        $validated = $request->validate([
            'date' => 'required|date|after:today',
        ]);
        
        Barter::create($validated + ['transmitter_user_id'=>auth()->id()]);

        request()->session()->flash('flash.banner', '¡Se ha publicado una solicitud de permuta correctamente!');
        request()->session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('barters.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Barter  $barter
     * @return \Illuminate\Http\Response
     */
    public function show(Barter $barter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Barter  $barter
     * @return \Illuminate\Http\Response
     */
    public function edit(Barter $barter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Barter  $barter
     * @return \Illuminate\Http\Response
     */
    public function update(Barter $barter)
    {
        $barter->status = 2;
        $barter->receptor_user_id = auth()->user()->id;
 
        $barter->save();

        return redirect()->route('barters.index');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Barter  $barter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Barter $barter)
    {
        $barter->delete();
        request()->session()->flash('flash.banner', '¡Se ha eliminado correctamente!');
        request()->session()->flash('flash.bannerStyle', 'success'); 
        return redirect()->route('barters.index');
    }
}
