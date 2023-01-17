<?php

namespace App\Http\Controllers;

use App\Http\Resources\PayrollUserResource;
use App\Models\Payroll;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PayrollController extends Controller
{
    
    public function index()
    {
        $payrolls = PayrollUserResource::collection(auth()->user()->payrolls()->orderBy('id', 'desc')->get());

        return Inertia::render('PayRoll/Index', compact('payrolls'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Payroll $payroll)
    {
        //
    }

    public function edit(Payroll $payroll)
    {
        //
    }

    public function update(Request $request, Payroll $payroll)
    {
        //
    }

    public function destroy(Payroll $payroll)
    {
        //
    }

    public function adminIndex()
    {
        return inertia('PayRoll/Admin/Index');
    }
}
