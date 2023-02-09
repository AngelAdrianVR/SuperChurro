<?php

namespace App\Http\Controllers;

use App\Http\Resources\LoanResource;
use App\Models\Loan;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LoanController extends Controller
{
    public function index()
    {
        $loans = LoanResource::collection(auth()->user()->loans()->latest()->get());
        $user_has_active_loan = auth()->user()->activeLoan;


        return Inertia::render('Loan/Index', compact('loans', 'user_has_active_loan'));
    }

    public function create()
    {
        return Inertia::render('Loan/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'numeric|min:1',
            'description' => 'max:191',
        ]);

        Loan::create($validated + [
            'user_id' => auth()->id(),
            'remaining' => $request->amount,
        ]);

        request()->session()->flash('flash.banner', '¡Se ha creado tu solicitud correctamente!');
        request()->session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('loans.index');
    }

    public function show(Loan $loan)
    {
        //
    }

    public function edit(Loan $loan)
    {
        //
    }

    public function update(Request $request, Loan $loan)
    {
        //
    }

    public function destroy(Loan $loan)
    {
        $loan->delete();
        request()->session()->flash('flash.banner', '¡Se ha eliminado correctamente!');
        request()->session()->flash('flash.bannerStyle', 'success');
        return redirect()->route('loans.index');
    }
}
