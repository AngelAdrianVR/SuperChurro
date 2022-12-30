<?php

namespace App\Http\Controllers;

use App\Models\WorkPermit;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WorkPermitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('WorkPermit/Index');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WorkPermit  $workPermit
     * @return \Illuminate\Http\Response
     */
    public function show(WorkPermit $workPermit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WorkPermit  $workPermit
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkPermit $workPermit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WorkPermit  $workPermit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkPermit $workPermit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WorkPermit  $workPermit
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkPermit $workPermit)
    {
        //
    }
}
