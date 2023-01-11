<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
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
        $users = UserResource::collection(User::all());

        // return $users;
        return inertia('User/Index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return inertia('User/Create');
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
            'name'=> 'required|max:30',
            'email'=> 'email',
            'phone_number'=> 'required|numeric|digits:10',
            'employee_properties.birthdate'=> 'required|date',
            'employee_properties.base_salary'=> 'required|numeric',
            'employee_properties.shifts'=> 'required',
            'employee_properties.work_days'=> 'required',
            'employee_properties.vacations'=> 'numeric',
            
        ]);
        User::create($validated + [
            'employee_properties.vacations_updated_date' => now(),
            'password' => bcrypt('123'),
            
        ]);

        request()->session()->flash('flash.banner', '¡Se ha creado un nuevo usuario correctamente!');
        request()->session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('users.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        // return $user;
        return inertia('User/Show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function disable(User $user)
    {
        $user->is_active = false;
        $user->save();

        request()->session()->flash('flash.banner', '¡Se ha dado de baja al usuario correctamente!');
        request()->session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('users.index');
    }

    public function enable(User $user)
    {
        $user->is_active = true;
        $user->save();

        request()->session()->flash('flash.banner', '¡Se ha dado de alta al usuario correctamente!');
        request()->session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('users.index');
    }
}
