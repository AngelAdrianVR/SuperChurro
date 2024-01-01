<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $checked_in = auth()->user()->hasCheckedInToday();
        $checked_out = auth()->user()->hasCheckedOutToday();
        $loan = auth()->user()->loans()->where('remaining', '>', 0)->whereNotNull('authorized_at')->first();
        $leaves = auth()->user()->workPermits()->whereDate('date', '>=', today())->with('permissionType')->get();
        $notices = Notice::all();

        $collaborators_birthdays = User::where('is_active', true)->whereMonth('employee_properties->birthdate', '=', now()->month)
            ->get();

        return auth()->user()->is_admin
            ? inertia('AdminDashboard', compact('notices', 'collaborators_birthdays'))
            : inertia('Dashboard', compact('checked_in', 'checked_out', 'loan', 'leaves', 'notices'));
    }
}
