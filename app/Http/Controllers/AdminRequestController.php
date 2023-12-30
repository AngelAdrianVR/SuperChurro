<?php

namespace App\Http\Controllers;

use App\Http\Resources\LoanResource;
use App\Http\Resources\WorkPermitResource;
use App\Models\Loan;
use App\Models\User;
use App\Models\WorkPermit;
use Illuminate\Http\Request;

class AdminRequestController extends Controller
{
    public function permits()
    {
        $work_permits = WorkPermitResource::collection(WorkPermit::with('user')->latest()->paginate(15));
        // return $work_permits;
        return inertia('AdminRequest/Permits', compact('work_permits')); 
    }

    public function loans()
    {
        $loans = LoanResource::collection(Loan::with('user')->latest()->paginate(15));
        return inertia('AdminRequest/Loans',compact('loans')); 
    }

    public function acceptWorkPermit(WorkPermit $work_permit)
    {
        $user = WorkPermit::find($work_permit->id)->user;
        $current_properties = $user->employee_properties;
        // return $user;

        if($work_permit->permission_type_id == 3){
            $current_properties['vacations'] -= 1;
            $user->update(['employee_properties' => $current_properties]);
        }

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
        $loan->user->update(['loan_active' => true]);
        $loan->authorized_at = now();
        $loan->save();
        
          request()->session()->flash('flash.banner', '¡Se ha aceptado el préstamo!');
        request()->session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('admin-requests.loans');
    }

    public function rejectLoan(Loan $loan)
    {
        $loan->remaining = 0;
        $loan->save();
        request()->session()->flash('flash.banner', 'Se ha rechazado el préstamo');
        request()->session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('admin-requests.loans');
    }
}
