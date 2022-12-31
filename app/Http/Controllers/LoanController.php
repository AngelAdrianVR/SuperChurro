<?php

namespace App\Http\Controllers;

use App\Http\Resources\LoanResource;
use App\Models\Loan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LoanController extends Controller
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
        $loans = LoanResource::collection(auth()->user()->loans()->latest()->get());
        // return $loans;
       return Inertia::render('Loan/Index', compact('loans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Loan/Create');
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
            'amount' => 'numeric|min:1',
            'description' => 'max:191',
        ]);

        Loan::create($validated + ['user_id'=>auth()->id()]);
        
        request()->session()->flash('flash.banner', '¡Se ha creado tu solicitud correctamente!');
        request()->session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('loans.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function show(Loan $loan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function edit(Loan $loan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Loan $loan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loan $loan)
    {
        $loan->delete();
        request()->session()->flash('flash.banner', '¡Se ha eliminado correctamente!');
        request()->session()->flash('flash.bannerStyle', 'success'); 
        return redirect()->route('loans.index');

    }
}
