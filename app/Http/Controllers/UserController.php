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

    public function index()
    {
        $users = UserResource::collection(User::where('id', '!=', auth()->id())->get());

        return inertia('User/Index', compact('users'));
    }

    public function create()
    {
        return inertia('User/Create');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([

            'name'=> 'required|max:30',
            'email'=> 'email',
            'phone_number'=> 'required|numeric|digits:10',
            'employee_properties.birthdate'=> 'required|date',
            'employee_properties.base_salary'=> 'required|numeric',
            'employee_properties.shift'=> 'required',
            'employee_properties.work_days'=> 'required',
            'employee_properties.vacations'=> 'max:30',

        ]);

        $user = User::create($validated + [
            'employee_properties.vacations_updated_date' => now(),
            'password' => bcrypt('123'),

        ]);

        $user->addAllMediaFromRequest()->each(fn ($file) => $file->toMediaCollection());

        request()->session()->flash('flash.banner', '¡Se ha creado un nuevo usuario correctamente!');
        request()->session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('users.index');
    }

    public function show(User $user)
    {
        $media = $user->getMedia()->all();
        return inertia('User/Show', compact('user', 'media'));
    }

    public function edit(User $user)
    {
        //
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|max:30',
            'email' => 'email',
            'phone_number' => 'required|numeric|digits:10',
            'employee_properties.birthdate' => 'required|date',
            'employee_properties.base_salary' => 'required|numeric',
            'employee_properties.shift' => 'required',
            'employee_properties.work_days' => 'required',
            'employee_properties.vacations'=> 'max:30',
        ]);

        $user->update($validated);
        $user->addAllMediaFromRequest()->each(fn ($file) => $file->toMediaCollection());

        request()->session()->flash('flash.banner', '¡Se ha actualizado la información del usuario!');
        request()->session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('users.index');
    }

    public function updateWithResources(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|max:30',
            'email' => 'email',
            'phone_number' => 'required|numeric|digits:10',
            'employee_properties.birthdate' => 'required|date',
            'employee_properties.base_salary' => 'required|numeric',
            'employee_properties.shift' => 'required',
            'employee_properties.work_days' => 'required',
            'employee_properties.vacations'=> 'max:30',
        ]);

        $user->update($validated);
        $user->addAllMediaFromRequest()->each(fn ($file) => $file->toMediaCollection());

        request()->session()->flash('flash.banner', '¡Se ha actualizado la información del usuario!');
        request()->session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('users.index');
    }

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

    public function resetPass(User $user)
    {
        $user->password = bcrypt('12345678');
        $user->save();

        request()->session()->flash('flash.banner', '¡Se ha dado reseteado la contraseña correctamente!');
        request()->session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('users.index');
    }

    public function deleteFile(Request $request)
    {
        User::find($request->user_id)->deleteMedia($request->file_id);

        return response()->json(['success' => 'success'], 200);
    }
}
