<?php

namespace App\Http\Controllers;

use App\Models\Barter;
use Illuminate\Http\Request;

class BarterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return inertia('Barter/Index');
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
        
        var_dump($validated);

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
    public function update(Request $request, Barter $barter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Barter  $barter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Barter $barter)
    {
        //
    }
}
