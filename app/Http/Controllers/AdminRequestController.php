<?php

namespace App\Http\Controllers;

use App\Models\WorkPermit;
use Illuminate\Http\Request;

class AdminRequestController extends Controller
{
    public function permits()
    {
        $work_permits = WorkPermit::latest()->get();
        // return $work_permits;
        return inertia('AdminRequest/Permits', compact('work_permits')); 
    }

    public function loans()
    {

        return inertia('AdminRequest/Loans'); 
    }
}
