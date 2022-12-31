<?php

namespace App\Http\Controllers;

use App\Http\Resources\WorkPermitResource;
use App\Models\PermissionType;
use App\Models\WorkPermit;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WorkPermitController extends Controller
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
        $work_permits = WorkPermitResource::collection(auth()->user()->workPermits()->latest()->get());
        // return  $work_permits;
        return Inertia::render('WorkPermit/Index',compact('work_permits'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission_types = PermissionType::all();
        return Inertia::render('WorkPermit/Create', compact('permission_types'));
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
            'date' => 'required|after:today',
            'time_requested' => 'max:1',
            'description' => 'max:191',
            'permission_type_id' => 'required',
        ]);

        WorkPermit::create($validated + ['user_id'=>auth()->id()]);
        
        request()->session()->flash('flash.banner', '¡Se ha creado tu solicitud correctamente!');
        request()->session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('work-permits.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WorkPermit  $workPermit
     * @return \Illuminate\Http\Response
     */
    public function show(WorkPermit $workPermit)
    {
             
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
        $workPermit->delete();
        request()->session()->flash('flash.banner', '¡Se ha eliminado correctamente!');
        request()->session()->flash('flash.bannerStyle', 'success'); 
        return redirect()->route('work-permits.index');
    }
}
