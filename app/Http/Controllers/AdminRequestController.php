<?php

namespace App\Http\Controllers;

use App\Http\Resources\LoanResource;
use App\Http\Resources\WorkPermitResource;
use App\Models\Loan;
use App\Models\WorkPermit;
use Illuminate\Http\Request;

class AdminRequestController extends Controller
{
    public function permits()
    {
        $work_permits = WorkPermitResource::collection(WorkPermit::latest()->get());
        // return $work_permits;
        return inertia('AdminRequest/Permits', compact('work_permits')); 
    }

    public function loans()
    {
        $loans = LoanResource::collection(Loan::latest()->get());

        return inertia('AdminRequest/Loans',compact('loans')); 
    }

    public function acceptWorkPermit(WorkPermit $work_permit)
    {
        $work_permit->status = 2;
        $work_permit->save();
        request()->session()->flash('flash.banner', '¡Se ha aceptado el permiso!');
        request()->session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('admin-requests.permits'); 
    }

    public function rejectWorkPermit(WorkPermit $work_permit)
    {
        $work_permit->status = 3;
        $work_permit->save();
        request()->session()->flash('flash.banner', 'Se ha rechazado el permiso');
        request()->session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('admin-requests.permits'); 
    }

    public function acceptLoan(Loan $loan)
    {

        $loan->status = 2;
        $loan->save();
        request()->session()->flash('flash.banner', '¡Se ha aceptado el préstamo!');
        request()->session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('admin-requests.loans');
    }

    public function rejectLoan(Loan $loan)
    {

        $loan->status = 3;
        $loan->save();
        request()->session()->flash('flash.banner', 'Se ha rechazado el préstamo');
        request()->session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('admin-requests.loans');
    }
}
