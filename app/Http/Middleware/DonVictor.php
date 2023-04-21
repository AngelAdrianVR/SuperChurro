<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DonVictor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->is_admin) 
            return  $next($request);

        // if user isn't admin, search for at least one don Victor shift
        foreach (auth()->user()->employee_properties['work_days'] as $work_day) {
           if($work_day['shift'] == 'Don Victor'){
            return $next($request);
           }
        }

        return redirect('dashboard');
    }
}
